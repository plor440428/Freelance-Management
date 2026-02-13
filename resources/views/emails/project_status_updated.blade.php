<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>อัปเดตสถานะโปรเจกต์</title>
</head>
<body style="background: #f3f4f6; font-family: 'Segoe UI', Arial, Helvetica, sans-serif; color: #111827; padding: 0; margin: 0;">
    <div style="max-width: 600px; margin: 32px auto; background: #fff; border-radius: 16px; box-shadow: 0 4px 24px #0001; overflow: hidden;">
        <div style="background: linear-gradient(90deg, #0ea5e9 0%, #2563eb 100%); color: #fff; padding: 28px 24px;">
            <h2 style="margin: 0 0 8px 0; font-size: 1.7rem; font-weight: bold;">สถานะโปรเจกต์ถูกอัปเดต</h2>
            <p style="margin: 0;">โปรเจกต์ของคุณมีการเปลี่ยนสถานะล่าสุด</p>
        </div>

        <div style="padding: 24px;">
            <p style="margin: 0 0 12px 0;">สวัสดี {{ $customer->name }}</p>
            <p style="margin: 0 0 16px 0;">โปรเจกต์ <strong>{{ $project->name }}</strong> ได้อัปเดตสถานะดังนี้:</p>

            <table cellpadding="6" cellspacing="0" border="0" style="border-collapse: collapse; width: 100%; max-width: 560px; margin-bottom: 18px;">
                <tr>
                    <td style="font-weight: bold; width: 160px; background: #f9fafb;">สถานะเดิม</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $oldStatus)) }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; background: #f9fafb;">สถานะใหม่</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $newStatus)) }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; background: #f9fafb;">อัปเดตเมื่อ</td>
                    <td>{{ $project->updated_at?->format('M d, Y H:i') ?? '-' }}</td>
                </tr>
            </table>

            <a href="{{ route('dashboard.projects.detail', $project->id) }}" style="display: inline-block; background: #111827; color: #fff; font-weight: 600; padding: 12px 22px; border-radius: 8px; text-decoration: none;">ดูรายละเอียดโปรเจกต์</a>
        </div>

        <div style="background: #f9fafb; color: #6b7280; text-align: center; font-size: 0.95rem; padding: 16px 0;">
            Freelance Management System &copy; {{ date('Y') }}
        </div>
    </div>
</body>
</html>
