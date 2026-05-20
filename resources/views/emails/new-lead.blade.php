<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lead Baru Masuk</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 20px; }
        .container { max-width: 580px; margin: 0 auto; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .header { background: #0d4c54; color: #fff; padding: 24px 32px; }
        .header h1 { margin: 0; font-size: 20px; }
        .header p { margin: 4px 0 0; font-size: 13px; opacity: 0.8; }
        .body { padding: 32px; }
        .badge { display: inline-block; background: #fbbf24; color: #7c3a00; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        td { padding: 10px 0; border-bottom: 1px solid #f0f0f0; vertical-align: top; }
        td:first-child { color: #666; width: 140px; font-weight: 600; }
        td:last-child { color: #222; }
        .cta { margin-top: 28px; text-align: center; }
        .btn { display: inline-block; background: #0d4c54; color: #fff; text-decoration: none; padding: 12px 28px; border-radius: 6px; font-size: 14px; font-weight: 600; }
        .footer { background: #f9f9f9; padding: 16px 32px; font-size: 12px; color: #999; text-align: center; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>🔔 Lead Baru Masuk!</h1>
        <p>Ada calon jamaah baru yang mendaftar melalui landing page.</p>
    </div>
    <div class="body">
        <div class="badge">SEGERA FOLLOW UP</div>
        <table>
            <tr>
                <td>Nama</td>
                <td><strong>{{ $lead->name }}</strong></td>
            </tr>
            <tr>
                <td>No. WhatsApp</td>
                <td>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $lead->phone) }}" style="color: #16a34a; font-weight: 600;">
                        {{ $lead->phone }}
                    </a>
                </td>
            </tr>
            @if($lead->package)
            <tr>
                <td>Pilihan Paket</td>
                <td>{{ $lead->package }}</td>
            </tr>
            @endif
            <tr>
                <td>Landing Page</td>
                <td>{{ $page->title }}</td>
            </tr>
            <tr>
                <td>Waktu Masuk</td>
                <td>{{ $lead->created_at->format('d M Y, H:i') }} WIB</td>
            </tr>
        </table>
        <div class="cta">
            <a href="{{ route('admin.landing-pages.leads.index') }}" class="btn">Lihat di Dashboard CRM</a>
        </div>
    </div>
    <div class="footer">
        Email ini dikirim otomatis oleh sistem Elnair. Jangan balas email ini.
    </div>
</div>
</body>
</html>
