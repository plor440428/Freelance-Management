<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Password;

class ForgotPassword extends Component
{
    public $email = '';

    protected $rules = [
        'email' => 'required|email',
    ];

    public function submit()
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

        $status = Password::sendResetLink(['email' => $this->email]);

        if ($status === Password::RESET_LINK_SENT) {
            $this->dispatch('notify', message: 'ส่งลิงก์รีเซ็ตรหัสผ่านไปที่อีเมลแล้ว', type: 'success');
            $this->dispatch('password-link-sent', message: 'ส่งลิงก์รีเซ็ตรหัสผ่านสำเร็จแล้ว กรุณาไปตรวจสอบอีเมลของคุณ หากไม่พบให้ดูที่ถังขยะหรือสแปม หากยังไม่พบให้กดส่งใหม่ หรือติดต่อแอดมินที่เบอร์ 085-xxxxxxx');
            $this->reset('email');
            return;
        }

        $this->addError('email', 'ส่งอีเมลไม่สำเร็จ กรุณาลองใหม่อีกครั้ง');
    }

    public function render()
    {
        return view('livewire.auth.forgot-password');
    }
}
