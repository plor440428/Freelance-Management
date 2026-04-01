<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Setting;
use App\Models\PaymentProof;
use App\Models\ProjectPaymentProof;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Throwable;

class Settings extends Component
{
    public $paymentSlipUrl;
    public $registrationPaymentStatus;

    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    // Pricing settings - Lifetime prices per role
    public $freelance_price;
    public $customer_price;

    public function mount()
    {
        $user = auth()->user();

        // Load payment slip if exists
        $paymentProof = PaymentProof::where('user_id', $user->id)->latest()->first();
        if ($paymentProof && $paymentProof->proof_file) {
            $this->paymentSlipUrl = asset('storage/' . ltrim($paymentProof->proof_file, '/'));
            $this->registrationPaymentStatus = $paymentProof->status;
        }

        // Load pricing settings for admin
        if ($user->role === 'admin') {
            $this->freelance_price = Setting::get('freelance_price', 2990);
            $this->customer_price = Setting::get('customer_price', 1990);
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

        // Guard against missing optional table in environments with partial migrations
        if (!Schema::hasTable('project_payment_proofs')) {
            return view('livewire.dashboard.settings', [
                'projectPaymentHistory' => collect(),
                'projectPaymentSummary' => [
                    'customer_rounds' => 0,
                    'freelance_rounds' => 0,
                    'my_rounds' => 0,
                ],
            ]);
        }

        try {
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
        } catch (Throwable $e) {
            Log::warning('Settings project payment history fallback', [
                'user_id' => $user?->id,
                'message' => $e->getMessage(),
            ]);

            $projectPaymentHistory = collect();
            $projectPaymentSummary = [
                'customer_rounds' => 0,
                'freelance_rounds' => 0,
                'my_rounds' => 0,
            ];
        }

        return view('livewire.dashboard.settings', [
            'projectPaymentHistory' => $projectPaymentHistory,
            'projectPaymentSummary' => $projectPaymentSummary,
        ]);
    }
}
