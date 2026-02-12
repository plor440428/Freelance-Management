<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>บัญชีได้รับการอนุมัติ</title>
</head>

<body style="background: #f3f4f6; font-family: 'Segoe UI', Arial, Helvetica, sans-serif; color: #111827; padding: 0; margin: 0;">
    <div style="max-width: 600px; margin: 32px auto; background: #fff; border-radius: 16px; box-shadow: 0 4px 24px #0001; overflow: hidden;">
        <div style="background: linear-gradient(90deg, #0ea5e9 0%, #22c55e 100%); color: #fff; padding: 32px 24px 24px 24px;">
            <h2 style="margin: 0 0 8px 0; font-size: 2rem; font-weight: bold; letter-spacing: 0.5px;">บัญชีของคุณได้รับการอนุมัติแล้ว</h2>
            <p style="margin: 0; font-size: 1.1rem;">ยินดีต้อนรับสู่ระบบ Freelance Management</p>
        </div>
        <div style="padding: 24px;">
            <p style="margin: 0 0 16px 0;">สวัสดี {{ $user->name }} ข้อมูลการอนุมัติของคุณมีรายละเอียดดังนี้</p>

            <table cellpadding="6" cellspacing="0" border="0" style="border-collapse: collapse; width: 100%; max-width: 560px; margin-bottom: 24px;">
                <tr>
                    <td style="font-weight: bold; width: 180px; background: #f9fafb;">ชื่อผู้สมัคร</td>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; background: #f9fafb;">อีเมล</td>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; background: #f9fafb;">วันที่สมัคร</td>
                    <td>{{ $user->created_at?->format('d/m/Y H:i') ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; background: #f9fafb;">ผู้อนุมัติ</td>
                    <td>{{ $approver?->name ?? $user->approver?->name ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; background: #f9fafb;">วันที่อนุมัติ</td>
                    <td>{{ $user->approved_at?->format('d/m/Y H:i') ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; background: #f9fafb;">ประเภทสมาชิก</td>
                    <td>{{ $paymentProof?->subscription_type ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; background: #f9fafb;">จำนวนเงิน</td>
                    <td>{{ $paymentProof?->amount ? number_format($paymentProof->amount, 2) : '-' }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; background: #f9fafb;">สถานะการชำระเงิน</td>
                    <td>{{ $paymentProof?->status ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; background: #f9fafb;">วันที่ส่งหลักฐาน</td>
                    <td>{{ $paymentProof?->created_at?->format('d/m/Y H:i') ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; background: #f9fafb;">หมายเหตุจากผู้ดูแล</td>
                    <td>{{ $paymentProof?->admin_note ?: '-' }}</td>
                </tr>
            </table>

            <div style="margin-top: 24px;">
                <a href="{{ route('login') }}" style="display: inline-block; background: linear-gradient(90deg, #0ea5e9 0%, #22c55e 100%); color: #fff; font-weight: bold; padding: 12px 32px; border-radius: 8px; text-decoration: none; font-size: 1.1rem; box-shadow: 0 2px 8px #0001;">เข้าสู่ระบบ</a>
            </div>
        </div>
        <div style="background: #f9fafb; color: #6b7280; text-align: center; font-size: 0.95rem; padding: 16px 0;">
            <span>Freelance Management System &copy; {{ date('Y') }}</span>
        </div>
    </div>
</body>
</html>
