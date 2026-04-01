<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ลงทะเบียนสำเร็จ รอการอนุมัติ</title>
</head>
<body style="background: #f3f4f6; font-family: 'Segoe UI', Arial, Helvetica, sans-serif; color: #111827; padding: 0; margin: 0;">
    <div style="max-width: 600px; margin: 32px auto; background: #fff; border-radius: 16px; box-shadow: 0 4px 24px #0001; overflow: hidden;">
        <div style="background: linear-gradient(90deg, #2563eb 0%, #0ea5e9 100%); color: #fff; padding: 28px 24px;">
            <h2 style="margin: 0 0 8px 0; font-size: 1.8rem; font-weight: bold;">ลงทะเบียนสำเร็จแล้ว</h2>
            <p style="margin: 0;">บัญชีของคุณอยู่ระหว่างรอการอนุมัติจากแอดมิน</p>
        </div>

        <div style="padding: 24px;">
            <p style="margin: 0 0 12px 0;">สวัสดี {{ $user->name }}</p>
            <p style="margin: 0 0 12px 0; color: #374151;">ระบบได้รับคำขอสมัครสมาชิกของคุณเรียบร้อยแล้ว</p>
            <p style="margin: 0 0 16px 0; color: #374151;">สถานะปัจจุบัน: <strong>รออนุมัติ</strong></p>
            <p style="margin: 0 0 16px 0; color: #6b7280;">เมื่อแอดมินอนุมัติแล้ว ระบบจะส่งอีเมลแจ้งอีกครั้งให้คุณเข้าสู่ระบบได้ทันที</p>

            <a href="{{ route('login') }}" style="display: inline-block; background: #111827; color: #fff; font-weight: 600; padding: 12px 22px; border-radius: 8px; text-decoration: none;">ไปหน้าเข้าสู่ระบบ</a>
        </div>

        <div style="background: #f9fafb; color: #6b7280; text-align: center; font-size: 0.95rem; padding: 16px 0;">
            Freelance Management System &copy; {{ date('Y') }}
        </div>
    </div>
</body>
</html>
