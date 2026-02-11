<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ผู้สมัครสมาชิกใหม่ {{ $user->email }}</title>
</head>

<body style="background: #f3f4f6; font-family: 'Segoe UI', Arial, Helvetica, sans-serif; color: #111827; padding: 0; margin: 0;">
    <div style="max-width: 600px; margin: 32px auto; background: #fff; border-radius: 16px; box-shadow: 0 4px 24px #0001; overflow: hidden;">
        <div style="background: linear-gradient(90deg, #2563eb 0%, #9333ea 100%); color: #fff; padding: 32px 24px 24px 24px;">
            <h2 style="margin: 0 0 8px 0; font-size: 2rem; font-weight: bold; letter-spacing: 0.5px;">ผู้สมัครสมาชิกใหม่</h2>
            <p style="margin: 0; font-size: 1.1rem;">ผู้ใช้ใหม่ได้ส่งคำขอสมัครสมาชิกแล้ว</p>
        </div>
        <div style="padding: 24px;">
            <table cellpadding="6" cellspacing="0" border="0" style="border-collapse: collapse; width: 100%; max-width: 560px; margin-bottom: 24px;">
                <tr>
                    <td style="font-weight: bold; width: 160px; background: #f9fafb;">ชื่อ</td>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; background: #f9fafb;">อีเมล</td>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; background: #f9fafb;">บทบาท</td>
                    <td>{{ ucfirst($user->role) }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; background: #f9fafb;">วันที่ร้องขอ</td>
                    <td>{{ $user->created_at?->format('M d, Y H:i') ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; background: #f9fafb;">จำนวนเงิน</td>
                    <td>{{ $paymentProof?->amount ? number_format($paymentProof->amount, 2) : '-' }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; background: #f9fafb;">สถานะ</td>
                    <td>{{ $paymentProof?->status ?? 'pending' }}</td>
                </tr>
            </table>

            @if($paymentProof?->proof_file)
                <div style="margin-bottom: 24px; color: #374151; background: #f9fafb; border-radius: 8px; padding: 12px 16px;">
                    <div style="font-weight: bold; margin-bottom: 6px;">หลักฐานการโอนเงิน</div>
                    <div>หากต้องการดูภาพสลิป กรุณาคลิก "เปิดแดชบอร์ด" เพื่อเข้าสู่ระบบและตรวจสอบรายละเอียดการโอนเงิน</div>
                </div>
            @endif

            <div style="margin-top: 24px;">
                <a href="{{ route('dashboard') }}" style="display: inline-block; background: linear-gradient(90deg, #2563eb 0%, #9333ea 100%); color: #fff; font-weight: bold; padding: 12px 32px; border-radius: 8px; text-decoration: none; font-size: 1.1rem; box-shadow: 0 2px 8px #0001;">เปิดแดชบอร์ด</a>
            </div>
        </div>
        <div style="background: #f9fafb; color: #6b7280; text-align: center; font-size: 0.95rem; padding: 16px 0;">
            <span>Freelance Management System &copy; {{ date('Y') }}</span>
        </div>
    </div>
</body>
</html>
