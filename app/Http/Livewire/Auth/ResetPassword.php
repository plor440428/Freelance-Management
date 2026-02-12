<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPassword extends Component
{
    public $token;
    public $email = '';
    public $password = '';
    public $password_confirmation = '';

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|string|min:6|confirmed',
    ];

    public function mount($token)
    {
        $this->token = $token;
        $this->email = request()->query('email', '');
    }

    public function resetPassword()
    {
        $this->validate();

        $user = User::where('email', $this->email)->first();

        if (!$user) {
            $this->addError('email', 'ไม่พบอีเมลนี้ในระบบ');
            return;
        }

        if (!$user->is_approved) {
            $this->addError('email', 'บัญชีนี้ยังไม่ได้รับการอนุมัติ');
            return;
        }

        $status = Password::reset(
            [
                'email' => $this->email,
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
                'token' => $this->token,
            ],
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            $this->dispatch('notify', message: 'เปลี่ยนรหัสผ่านสำเร็จแล้ว', type: 'success');
            return redirect()->route('login');
        }

        $this->addError('email', 'ลิงก์รีเซ็ตไม่ถูกต้องหรือหมดอายุ');
    }

    public function render()
    {
        return view('livewire.auth.reset-password');
    }
}
