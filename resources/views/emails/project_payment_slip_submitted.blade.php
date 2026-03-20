<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>มีการส่งสลิปชำระเงินโปรเจ็ค</title>
</head>
<body style="background: #f3f4f6; font-family: 'Segoe UI', Arial, Helvetica, sans-serif; color: #111827; padding: 0; margin: 0;">
    <div style="max-width: 620px; margin: 24px auto; background: #ffffff; border-radius: 14px; overflow: hidden; border: 1px solid #e5e7eb;">
        <div style="background: linear-gradient(90deg, #0ea5e9 0%, #2563eb 100%); color: #fff; padding: 24px;">
            <h2 style="margin: 0 0 8px 0; font-size: 1.4rem; font-weight: 700;">มีผู้ส่งสลิปชำระเงิน</h2>
            <p style="margin: 0; font-size: 0.95rem; opacity: 0.95;">ระบบแจ้งเตือนการส่งสลิปในโปรเจ็ค</p>
        </div>

        <div style="padding: 20px 24px;">
            <table cellpadding="8" cellspacing="0" border="0" style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="width: 170px; background: #f8fafc; font-weight: 700;">ชื่อผู้ส่ง</td>
                    <td>{{ $payment->user?->name ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="background: #f8fafc; font-weight: 700;">บทบาทผู้ส่ง</td>
                    <td>{{ ucfirst($payment->submitted_as) }}</td>
                </tr>
                <tr>
                    <td style="background: #f8fafc; font-weight: 700;">โปรเจ็ค</td>
                    <td>{{ $payment->project?->name ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="background: #f8fafc; font-weight: 700;">จำนวนเงิน</td>
                    <td>{{ $payment->amount ? number_format($payment->amount, 2) . ' บาท' : '-' }}</td>
                </tr>
                <tr>
                    <td style="background: #f8fafc; font-weight: 700;">เวลาที่ส่ง</td>
                    <td>{{ $payment->created_at?->format('d/m/Y H:i') ?? '-' }}</td>
                </tr>
            </table>

            @if($payment->note)
                <div style="margin-top: 14px; padding: 12px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px;">
                    <div style="font-weight: 700; margin-bottom: 6px;">หมายเหตุ</div>
                    <div style="white-space: pre-line;">{{ $payment->note }}</div>
                </div>
            @endif

            <div style="margin-top: 18px;">
                <a href="{{ route('dashboard.projects.detail', ['id' => $payment->project_id]) }}"
                   style="display: inline-block; padding: 10px 18px; background: #2563eb; color: #fff; text-decoration: none; border-radius: 8px; font-weight: 700;">
                    ดูรายละเอียดในระบบ
                </a>
            </div>
        </div>

        <div style="padding: 12px 24px; border-top: 1px solid #e5e7eb; color: #6b7280; font-size: 0.85rem;">
            Freelance Management System
        </div>
    </div>
</body>
</html>
