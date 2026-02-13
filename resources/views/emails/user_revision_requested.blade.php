<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>กรุณาแก้ไขข้อมูลการสมัคร</title>
</head>
<body style="background: #f3f4f6; font-family: 'Segoe UI', Arial, Helvetica, sans-serif; color: #111827; padding: 0; margin: 0;">
    <div style="max-width: 600px; margin: 32px auto; background: #fff; border-radius: 16px; box-shadow: 0 4px 24px #0001; overflow: hidden;">
        <div style="background: linear-gradient(90deg, #dc2626 0%, #f59e0b 100%); color: #fff; padding: 28px 24px;">
            <h2 style="margin: 0 0 8px 0; font-size: 1.7rem; font-weight: bold;">ยังไม่อนุมัติการสมัคร</h2>
            <p style="margin: 0;">กรุณาแก้ไขข้อมูลแล้วส่งกลับมาเพื่อให้แอดมินพิจารณาใหม่</p>
        </div>

        <div style="padding: 24px;">
            <p style="margin: 0 0 16px 0;">สวัสดี {{ $user->name }}</p>
            <p style="margin: 0 0 8px 0;">แอดมินยังไม่สามารถอนุมัติบัญชีของคุณได้ โดยมีเหตุผลดังนี้:</p>

            <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 14px 16px; border-radius: 10px; margin: 12px 0 18px 0;">
                {{ $reason }}
            </div>

            <p style="margin: 0 0 18px 0; color: #374151;">กดปุ่มด้านล่างเพื่อแก้ไขข้อมูล เมื่อส่งแล้วระบบจะส่งแจ้งเตือนกลับไปยังแอดมินทันที</p>

            <a href="{{ $revisionUrl }}" style="display: inline-block; background: #111827; color: #fff; font-weight: 600; padding: 12px 22px; border-radius: 8px; text-decoration: none;">แก้ไขข้อมูลการสมัคร</a>

            <p style="margin: 18px 0 0 0; color: #6b7280; font-size: 13px;">ลิงก์นี้มีอายุการใช้งาน 7 วัน</p>
        </div>

        <div style="background: #f9fafb; color: #6b7280; text-align: center; font-size: 0.95rem; padding: 16px 0;">
            Freelance Management System &copy; {{ date('Y') }}
        </div>
    </div>
</body>
</html>
