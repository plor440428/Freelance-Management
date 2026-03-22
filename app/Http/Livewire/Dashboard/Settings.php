<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\File;
use App\Models\Setting;
use App\Models\PaymentProof;
use App\Models\ProjectPaymentProof;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class Settings extends Component
{
    use WithFileUploads;

    public $profileImage;
    public $previewUrl;
    public $paymentSlipUrl;
    public $registrationPaymentStatus;

    // Profile settings
    public $name;
    public $email;
    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    // Pricing settings - Lifetime prices per role
    public $freelance_price;
    public $customer_price;

    public function mount()
    {
        $user = auth()->user();
        
        // Load user data
        $this->name = $user->name;
        $this->email = $user->email;
        
        // Load profile image with proper path checking
        if ($user->profile_image_path && Storage::disk('public')->exists($user->profile_image_path)) {
            $this->previewUrl = Storage::disk('public')->url($user->profile_image_path);
        }

        // Load payment slip if exists
        $paymentProof = PaymentProof::where('user_id', $user->id)->latest()->first();
        if ($paymentProof && $paymentProof->proof_file) {
            $this->paymentSlipUrl = Storage::disk('public')->url($paymentProof->proof_file);
            $this->registrationPaymentStatus = $paymentProof->status;
        }

        // Load pricing settings for admin
        if ($user->role === 'admin') {
            $this->freelance_price = Setting::get('freelance_price', 2990);
            $this->customer_price = Setting::get('customer_price', 1990);
        }
    }

    public function updateProfile()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'profileImage' => 'nullable|image|max:2048',
        ]);

        $user = auth()->user();
        
        // Update name
        $user->update(['name' => $this->name]);

        // Upload new profile image if provided
        if ($this->profileImage) {
            try {
                // Delete old profile image if exists
                if ($user->profile_image_path && Storage::disk('public')->exists($user->profile_image_path)) {
                    Storage::disk('public')->delete($user->profile_image_path);
                }

                // Store the new image
                $path = $this->profileImage->store('profiles', 'public');

                // Save to files table
                File::create([
                    'module_name' => 'user',
                    'module_id' => $user->id,
                    'file_name' => $this->profileImage->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => 'image',
                    'mime_type' => $this->profileImage->getMimeType(),
                    'file_size' => $this->profileImage->getSize(),
                ]);

                // Update user profile_image_path
                $user->update(['profile_image_path' => $path]);

                // Update preview URL
                $this->previewUrl = Storage::disk('public')->url($path);
                
                // Reset the file input
                $this->reset('profileImage');
                
                $this->dispatch('notify', message: 'Profile and image updated successfully!', type: 'success');
            } catch (\Exception $e) {
                $this->dispatch('notify', message: 'Profile updated but image upload failed: ' . $e->getMessage(), type: 'error');
            }
        } else {
            $this->dispatch('notify', message: 'Profile updated successfully!', type: 'success');
        }
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($this->current_password, $user->password)) {
            $this->addError('current_password', 'Current password is incorrect.');
            return;
        }

        $user->update(['password' => Hash::make($this->new_password)]);

        $this->current_password = '';
        $this->new_password = '';
        $this->new_password_confirmation = '';

        $this->dispatch('notify', message: 'Password updated successfully!', type: 'success');
    }

    public function savePricing()
    {
        $this->validate([
            'freelance_price' => 'required|numeric|min:0',
            'customer_price' => 'required|numeric|min:0',
        ]);

        Setting::set('freelance_price', $this->freelance_price);
        Setting::set('customer_price', $this->customer_price);

        $this->dispatch('notify', message: 'Pricing settings saved successfully!', type: 'success');
    }

    public function render()
    {
        $user = auth()->user();

        $projectPaymentQuery = ProjectPaymentProof::with(['project', 'user'])
            ->latest();

        if ($user->role === 'customer') {
            $projectPaymentQuery->where('user_id', $user->id);
        } elseif ($user->role === 'freelance') {
            $projectPaymentQuery->whereHas('project', function ($q) use ($user) {
                $q->where('freelance_id', $user->id)
                  ->orWhere('created_by', $user->id);
            });
        }

        $projectPaymentHistory = $projectPaymentQuery->limit(100)->get();

        $projectPaymentSummary = [
            'customer_rounds' => $projectPaymentHistory->where('submitted_as', 'customer')->count(),
            'freelance_rounds' => $projectPaymentHistory->where('submitted_as', 'freelance')->count(),
            'my_rounds' => $projectPaymentHistory->where('user_id', $user->id)->count(),
        ];

        return view('livewire.dashboard.settings', [
            'projectPaymentHistory' => $projectPaymentHistory,
            'projectPaymentSummary' => $projectPaymentSummary,
        ]);
    }
}
