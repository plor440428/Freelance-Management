<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>คุณได้ถูกระบุเป็นผู้จัดการโปรเจ็กต์</title>
</head>

<body style="background: #f3f4f6; font-family: 'Segoe UI', Arial, Helvetica, sans-serif; color: #111827; padding: 0; margin: 0;">
    <div style="max-width: 600px; margin: 32px auto; background: #fff; border-radius: 16px; box-shadow: 0 4px 24px #0001; overflow: hidden;">
        <div style="background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 50%, #5b21b6 100%); color: #fff; padding: 32px 24px 24px 24px;">
            <h2 style="margin: 0 0 8px 0; font-size: 2rem; font-weight: bold; letter-spacing: 0.5px;">สมาชิกทีม</h2>
            <p style="margin: 0; font-size: 1.1rem;">คุณได้ถูกเพิ่มเข้าเป็นสมาชิกของทีม</p>
        </div>
        <div style="padding: 24px;">
            <p style="margin: 0 0 16px 0; font-size: 1.05rem;">สวัสดี <strong>{{ $manager->name }}</strong></p>
            <p style="margin: 0 0 24px 0; color: #4b5563;">คุณได้ถูกเพิ่มเข้าเป็นสมาชิกของทีมในระบบ Freelance Management โดยมีรายละเอียดดังนี้</p>

            <table cellpadding="10" cellspacing="0" border="0" style="border-collapse: collapse; width: 100%; max-width: 560px; margin-bottom: 24px; border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden;">
                <tr>
                    <td style="font-weight: bold; width: 180px; background: #f8fafc; border-bottom: 1px solid #e5e7eb;">ชื่อโปรเจ็กต์</td>
                    <td style="border-bottom: 1px solid #e5e7eb;">{{ $project->name }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; background: #f8fafc; border-bottom: 1px solid #e5e7eb;">คำอธิบาย</td>
                    <td style="border-bottom: 1px solid #e5e7eb;">{{ $project->description ?? 'ไม่ระบุ' }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; background: #f8fafc; border-bottom: 1px solid #e5e7eb;">สถานะ</td>
                    <td style="border-bottom: 1px solid #e5e7eb;">
                        @if($project->status === 'active')
                            <span style="background: #ecfdf5; color: #047857; padding: 4px 12px; border-radius: 12px; font-size: 0.9rem; font-weight: 500;">กำลังดำเนินการ</span>
                        @elseif($project->status === 'completed')
                            <span style="background: #eff6ff; color: #1e40af; padding: 4px 12px; border-radius: 12px; font-size: 0.9rem; font-weight: 500;">เสร็จสิ้น</span>
                        @elseif($project->status === 'cancelled')
                            <span style="background: #fee2e2; color: #b91c1c; padding: 4px 12px; border-radius: 12px; font-size: 0.9rem; font-weight: 500;">ยกเลิก</span>
                        @else
                            <span style="background: #fef3c7; color: #92400e; padding: 4px 12px; border-radius: 12px; font-size: 0.9rem; font-weight: 500;">พักดำเนินการ</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold; background: #f8fafc; border-bottom: 1px solid #e5e7eb;">ผู้สร้างโปรเจ็กต์</td>
                    <td style="border-bottom: 1px solid #e5e7eb;">{{ $project->creator?->name ?? '-' }}</td>
                </tr>
                @if($project->freelance)
                <tr>
                    <td style="font-weight: bold; background: #f8fafc; border-bottom: 1px solid #e5e7eb;">Freelancer</td>
                    <td style="border-bottom: 1px solid #e5e7eb;">{{ $project->freelance->name }}</td>
                </tr>
                @endif
                <tr>
                    <td style="font-weight: bold; background: #f8fafc; border-bottom: 1px solid #e5e7eb;">จำนวนสมาชิกทีม</td>
                    <td style="border-bottom: 1px solid #e5e7eb;">{{ $project->managers->count() }} คน</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; background: #f8fafc; border-bottom: 1px solid #e5e7eb;">จำนวนลูกค้า</td>
                    <td style="border-bottom: 1px solid #e5e7eb;">{{ $project->customers->count() }} คน</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; background: #f8fafc; border-bottom: 1px solid #e5e7eb;">จำนวนงาน</td>
                    <td style="border-bottom: 1px solid #e5e7eb;">{{ $project->tasks->count() }} งาน</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; background: #f8fafc;">วันที่สร้างโปรเจ็กต์</td>
                    <td>{{ $project->created_at->format('d/m/Y H:i') }} น.</td>
                </tr>
            </table>

            @if($project->managers->count() > 1)
            <div style="background: #f8fafc; border-left: 4px solid #7c3aed; padding: 16px; margin-bottom: 24px; border-radius: 4px;">
                <p style="margin: 0 0 8px 0; font-weight: bold; color: #1e293b;">สมาชิกทีมอื่นๆ</p>
                <ul style="margin: 0; padding-left: 20px; color: #475569;">
                    @foreach($project->managers as $projectManager)
                        @if($projectManager->id !== $manager->id)
                            <li style="margin-bottom: 4px;">{{ $projectManager->name }} ({{ $projectManager->email }})</li>
                        @endif
                    @endforeach
                </ul>
            </div>
            @endif

            <div style="margin-top: 32px;">
                <a href="{{ route('login') }}" style="display: inline-block; background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%); color: #fff; font-weight: bold; padding: 14px 32px; border-radius: 8px; text-decoration: none; font-size: 1.05rem; box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);">เข้าสู่ระบบเพื่อดูรายละเอียด</a>
            </div>

            <div style="margin-top: 24px; padding-top: 24px; border-top: 1px solid #e5e7eb; color: #6b7280; font-size: 0.9rem;">
                <p style="margin: 0;">หากคุณมีคำถามเกี่ยวกับโปรเจ็กต์นี้ สามารถติดต่อผู้สร้างโปรเจ็กต์ได้โดยตรง</p>
            </div>
        </div>
        <div style="background: #f8fafc; color: #64748b; text-align: center; font-size: 0.9rem; padding: 16px 0; border-top: 1px solid #e5e7eb;">
            <span>Freelance Management System &copy; {{ date('Y') }}</span>
        </div>
    </div>
</body>
</html>
