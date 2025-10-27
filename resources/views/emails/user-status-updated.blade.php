<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Akun Diperbarui</title>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #eff6ff 0%, #e0e7ff 50%, #f3e8ff 100%);
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            padding: 24px;
            margin-bottom: 24px;
            text-align: center;
        }
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            padding: 24px;
            margin-bottom: 24px;
        }
        .status-approved {
            background: #dcfce7;
            color: #166534;
            padding: 8px 16px;
            border-radius: 6px;
            display: inline-block;
            font-weight: 600;
        }
        .status-rejected {
            background: #fee2e2;
            color: #dc2626;
            padding: 8px 16px;
            border-radius: 6px;
            display: inline-block;
            font-weight: 600;
        }
        .btn {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            font-weight: 600;
        }
        .footer {
            text-align: center;
            color: #6b7280;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1 style="color: #1f2937; font-size: 24px; font-weight: bold; margin: 0;">Status Akun Diperbarui</h1>
            <p style="color: #6b7280; margin: 8px 0 0 0;">Sistem Pengukuran Kepuasan dan Loyalitas</p>
        </div>

        <!-- Main Content -->
        <div class="card">
            <h2 style="color: #1f2937; font-size: 20px; margin-bottom: 16px;">Halo, {{ $user->name }}</h2>
            <p style="color: #374151; margin-bottom: 16px;">Status akun Anda telah diperbarui menjadi:</p>

            @if($status === 'approved')
                <div class="status-approved">Disetujui</div>
                <p style="color: #059669; margin-top: 16px;"><i>✓</i> Selamat! Anda sekarang dapat mengakses fitur UMKM penuh.</p>
                <a href="{{ url('/login') }}" class="btn">Login Sekarang</a>
            @elseif($status === 'rejected')
                <div class="status-rejected">Ditolak</div>
                <p style="color: #dc2626; margin-top: 16px;"><i>✗</i> Maaf, akun Anda ditolak. Silakan hubungi admin untuk informasi lebih lanjut.</p>
                <p style="margin-top: 16px;">Kontak Admin: <a href="mailto:admin@umkm.com" style="color: #3b82f6;">admin@umkm.com</a></p>
            @else
                <div style="background: #fef3c7; color: #92400e; padding: 8px 16px; border-radius: 6px; display: inline-block; font-weight: 600;">Pending</div>
            @endif

            <div style="margin-top: 24px; padding-top: 16px; border-top: 1px solid #e5e7eb;">
                <p style="color: #6b7280; font-size: 14px;">Jika Anda memiliki pertanyaan, silakan hubungi tim support kami.</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Terima kasih,<br><strong>{{ config('app.name') }}</strong></p>
        </div>
    </div>
</body>
</html>