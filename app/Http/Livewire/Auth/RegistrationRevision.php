<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\User;
use App\Models\File;
use App\Models\PaymentProof;
use App\Models\ApprovalLog;
use App\Mail\AdminRevisionSubmitted;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class RegistrationRevision extends Component
{
    use WithFileUploads;

    public User $user;

    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $role = 'customer';
    public $profile_image = null;
    public $payment_slip = null;

    public function mount(User $user)
    {
        if ($user->is_approved || !$user->rejection_reason) {
            abort(403, 'Unauthorized access.');
        }

        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email:rfc|unique:users,email,' . $this->user->id . '|max:255',
            'password' => 'nullable|string|min:6|max:255|confirmed',
            'role' => 'required|in:customer,freelance',
            'profile_image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
            'payment_slip' => 'nullable|file|mimes:jpeg,jpg,png,gif,pdf|max:5120',
        ];
    }

    public function submitRevision()
    {
        $validatedData = $this->validate();

        $this->user->name = trim($validatedData['name']);
        $this->user->email = strtolower(trim($validatedData['email']));
        $this->user->role = $validatedData['role'];
        $this->user->is_approved = false;
        $this->user->approved_at = null;
        $this->user->approved_by = null;
        $this->user->rejection_reason = null;
        $this->user->rejected_at = null;
        $this->user->rejected_by = null;

        if (!empty($validatedData['password'])) {
            $this->user->password = Hash::make($validatedData['password']);
        }

        $this->user->save();

        if ($this->profile_image) {
            $filename = 'profile_' . $this->user->id . '_' . time() . '.' . $this->profile_image->getClientOriginalExtension();
            $path = $this->profile_image->storeAs('profiles', $filename, 'public');

            File::create([
                'module_name' => 'user',
                'module_id' => $this->user->id,
                'file_name' => $this->profile_image->getClientOriginalName(),
                'file_path' => $path,
                'file_type' => 'image',
                'mime_type' => $this->profile_image->getMimeType(),
                'file_size' => $this->profile_image->getSize(),
            ]);

            $this->user->profile_image_path = $path;
            $this->user->save();
        }

        if ($this->payment_slip) {
            $slipFilename = 'payment_slip_' . $this->user->id . '_' . time() . '.' . $this->payment_slip->getClientOriginalExtension();
            $slipPath = $this->payment_slip->storeAs('payment_slips', $slipFilename, 'public');

            PaymentProof::create([
                'user_id' => $this->user->id,
                'subscription_type' => 'lifetime',
                'amount' => PaymentProof::where('user_id', $this->user->id)->latest()->value('amount') ?? 0,
                'proof_file' => $slipPath,
                'status' => 'pending',
            ]);
        } else {
            // Create a pending payment proof entry even without file
            // to enable admin review buttons
            $lastProof = PaymentProof::where('user_id', $this->user->id)->latest()->first();
            if ($lastProof) {
                PaymentProof::create([
                    'user_id' => $this->user->id,
                    'subscription_type' => $lastProof->subscription_type,
                    'amount' => $lastProof->amount,
                    'proof_file' => $lastProof->proof_file,
                    'status' => 'pending',
                ]);
            }
        }

        ApprovalLog::create([
            'user_id' => $this->user->id,
            'action' => 'revision_submitted',
            'reason' => null,
            'acted_by' => null,
            'meta' => [
                'submitted_at' => now()->toDateTimeString(),
            ],
        ]);

        $adminEmails = User::where('role', 'admin')
            ->pluck('email')
            ->filter()
            ->values()
            ->all();

        if (!empty($adminEmails)) {
            $reviewUrl = URL::to('/dashboard');

            try {
                Mail::to($adminEmails)->send(new AdminRevisionSubmitted($this->user, $reviewUrl));
            } catch (\Throwable $e) {
                \Log::error('Admin revision email failed', [
                    'user_id' => $this->user->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        $this->dispatch('show-notification', [
            'type' => 'success',
            'message' => 'ส่งข้อมูลแก้ไขเรียบร้อยแล้ว แอดมินจะพิจารณาอีกครั้ง',
        ]);

        // Store success flag in session for admin notification
        session()->flash('user.revision.submitted', [
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
        ]);

        $this->redirect(route('login'), navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.registration-revision');
    }
}
