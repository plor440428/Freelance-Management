<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\User;
use App\Models\File;
use App\Models\Setting;
use App\Models\PaymentProof;
use App\Mail\AdminSignupRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

class Register extends Component
{
    use WithFileUploads;

    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $role = 'customer';
    public $profile_image = null;
    public $payment_slip = null;
    public $isSubmitting = false;

    protected $rules = [
        'name' => 'required|string|min:3|max:255',
        'email' => 'required|email:rfc|unique:users,email|max:255',
        'password' => 'required|string|min:6|max:255|confirmed',
        'role' => 'required|in:customer,freelance',
        'profile_image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
        'payment_slip' => 'required|file|mimes:jpeg,jpg,png,gif,pdf|max:5120',
    ];

    protected $messages = [
        'name.required' => 'Full name is required',
        'name.min' => 'Name must be at least 3 characters',
        'name.max' => 'Name cannot exceed 255 characters',
        'email.required' => 'Email address is required',
        'email.email' => 'Please enter a valid email address',
        'email.unique' => 'This email is already registered in our system. Please use another email or login.',
        'email.max' => 'Email cannot exceed 255 characters',
        'password.required' => 'Password is required',
        'password.min' => 'Password must be at least 6 characters',
        'password.max' => 'Password cannot exceed 255 characters',
        'password.confirmed' => 'Password confirmation does not match',
        'role.required' => 'Please select an account type',
        'role.in' => 'Invalid account type selected',
        'profile_image.image' => 'Profile picture must be an image file',
        'profile_image.mimes' => 'Profile picture must be JPEG, JPG, PNG or GIF format',
        'profile_image.max' => 'Profile picture must not exceed 2MB',
        'payment_slip.required' => 'Payment slip is required to complete registration',
        'payment_slip.file' => 'Payment slip must be a valid file',
        'payment_slip.mimes' => 'Payment slip must be JPEG, JPG, PNG, GIF or PDF format',
        'payment_slip.max' => 'Payment slip must not exceed 5MB',
    ];

    public function getAmountProperty()
    {
        return Setting::get($this->role . '_price', 0);
    }

    public function updatedEmail()
    {
        // Real-time email validation
        $this->validateOnly('email');

        // Check if email exists (case insensitive)
        $existingUser = User::whereRaw('LOWER(email) = ?', [strtolower(trim($this->email))])->first();

        if ($existingUser) {
            $this->addError('email', 'This email is already registered in our system. Please use another email or login.');

            $this->dispatch('show-notification', [
                'type' => 'error',
                'message' => '⚠️ Email already exists! Please use a different email address.'
            ]);
        }
    }

    public function updatedRole()
    {
        // Force re-render when role changes
    }

    public function register()
    {
        if ($this->isSubmitting) {
            return;
        }

        $this->isSubmitting = true;

        try {
            $paymentProof = null;

            // Validate all inputs
            $this->resetErrorBag();
            $validatedData = $this->validate();

            \Log::info('=== Registration Started ===', [
                'email' => $this->email,
                'role' => $this->role,
                'has_profile_image' => !is_null($this->profile_image),
                'has_payment_slip' => !is_null($this->payment_slip),
            ]);

            // Double-check email uniqueness (case insensitive) before creating user
            $emailExists = User::whereRaw('LOWER(email) = ?', [strtolower(trim($validatedData['email']))])->exists();

            if ($emailExists) {
                \Log::warning('Registration blocked: Email already exists', ['email' => $validatedData['email']]);

                $this->addError('email', 'This email is already registered in our system. Please use another email or login.');

                $this->dispatch('show-notification', [
                    'type' => 'error',
                    'message' => '⚠️ This email address is already registered! Please use a different email or try logging in.'
                ]);

                return;
            }

            // Check if amount is available
            if ($this->amount <= 0) {
                $this->dispatch('show-notification', [
                    'type' => 'error',
                    'message' => 'Pricing not configured. Please contact administrator.'
                ]);
                return;
            }

            // Create user (not approved yet)
            $user = User::create([
                'name' => trim($validatedData['name']),
                'email' => strtolower(trim($validatedData['email'])),
                'password' => Hash::make($validatedData['password']),
                'role' => $validatedData['role'],
                'is_approved' => false,
            ]);

            if (!$user) {
                throw new \Exception('Failed to create user account');
            }

            \Log::info('User created', ['user_id' => $user->id]);

            // Handle profile image upload
            if ($this->profile_image) {
                try {
                    $filename = 'profile_' . $user->id . '_' . time() . '.' . $this->profile_image->getClientOriginalExtension();
                    $path = $this->profile_image->storeAs('profiles', $filename, 'public');

                    if (!$path) {
                        throw new \Exception('Failed to store profile image');
                    }

                    File::create([
                        'module_name' => 'user',
                        'module_id' => $user->id,
                        'file_name' => $this->profile_image->getClientOriginalName(),
                        'file_path' => $path,
                        'file_type' => 'image',
                        'mime_type' => $this->profile_image->getMimeType(),
                        'file_size' => $this->profile_image->getSize(),
                    ]);

                    $user->profile_image_path = $path;
                    $user->save();

                    \Log::info('Profile image uploaded', ['path' => $path]);
                } catch (\Exception $e) {
                    \Log::error('Profile image upload failed', ['error' => $e->getMessage()]);
                    // Continue even if profile image fails (it's optional)
                }
            }

            // Handle payment slip upload (REQUIRED)
            if (!$this->payment_slip) {
                throw new \Exception('Payment slip is required');
            }

            try {
                $slipFilename = 'payment_slip_' . $user->id . '_' . time() . '.' . $this->payment_slip->getClientOriginalExtension();
                $slipPath = $this->payment_slip->storeAs('payment_slips', $slipFilename, 'public');

                if (!$slipPath) {
                    throw new \Exception('Failed to store payment slip');
                }

                \Log::info('Payment slip uploaded', [
                    'filename' => $slipFilename,
                    'path' => $slipPath,
                    'size' => $this->payment_slip->getSize(),
                ]);

                $paymentProof = PaymentProof::create([
                    'user_id' => $user->id,
                    'subscription_type' => 'lifetime',
                    'amount' => $this->amount,
                    'proof_file' => $slipPath,
                    'status' => 'pending',
                ]);

                if (!$paymentProof) {
                    throw new \Exception('Failed to save payment proof');
                }

                \Log::info('PaymentProof created', ['id' => $paymentProof->id]);
            } catch (\Exception $e) {
                \Log::error('Payment slip upload failed', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);

                // Delete user if payment slip upload fails
                $user->delete();

                throw new \Exception('Failed to upload payment slip. Please try again.');
            }

            $adminEmails = User::where('role', 'admin')
                ->pluck('email')
                ->filter()
                ->values()
                ->all();

            if (!empty($adminEmails)) {
                $fromAddress = config('mail.from.address');
                $fromName = config('mail.from.name');

                \Log::info('Sending admin signup email', [
                    'from' => $fromAddress,
                    'from_name' => $fromName,
                    'to' => $adminEmails,
                    'user_id' => $user->id,
                ]);

                Mail::to($adminEmails)->send(new AdminSignupRequest($user, $paymentProof));
            } else {
                \Log::warning('No admin email recipients found for signup request');
            }

            \Log::info('=== Registration Completed Successfully ===');

            // Clear form
            $this->reset(['name', 'email', 'password', 'password_confirmation', 'profile_image', 'payment_slip']);

            // Show success modal
            $this->dispatch('registration-success');

            // Also show notification
            $this->dispatch('show-notification', [
                'type' => 'success',
                'message' => '✓ Registration successful! Please check your email for verification.'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed', ['errors' => $e->errors()]);

            // Show validation errors in notification
            $errorMessages = collect($e->errors())->flatten()->implode(', ');
            $this->dispatch('show-notification', [
                'type' => 'error',
                'message' => 'Validation Error: ' . $errorMessages
            ]);

            throw $e;
        } catch (\Exception $e) {
            \Log::error('Registration failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            $this->dispatch('show-notification', [
                'type' => 'error',
                'message' => 'Registration failed: ' . $e->getMessage()
            ]);

            session()->flash('error', 'Registration failed: ' . $e->getMessage());
        } finally {
            $this->isSubmitting = false;
        }
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
