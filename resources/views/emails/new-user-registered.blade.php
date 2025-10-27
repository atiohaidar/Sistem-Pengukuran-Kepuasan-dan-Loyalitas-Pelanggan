<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Baru Mendaftar</title>
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
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #f3f4f6;
        }
        .info-label {
            font-weight: 600;
            color: #374151;
        }
        .info-value {
            color: #6b7280;
        }
        .status-badge {
            padding: 4px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .status-approved { background: #dcfce7; color: #166534; }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-rejected { background: #fee2e2; color: #dc2626; }
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
            <h1 style="color: #1f2937; font-size: 24px; font-weight: bold; margin: 0;">User Baru Mendaftar</h1>
            <p style="color: #6b7280; margin: 8px 0 0 0;">Sistem Pengukuran Kepuasan dan Loyalitas</p>
        </div>

        <!-- User Details -->
        <div class="card">
            <h2 style="color: #1f2937; font-size: 20px; margin-bottom: 16px;">Detail User Baru</h2>

            <div class="info-row">
                <span class="info-label">Nama:</span>
                <span class="info-value">{{ $user->name }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Email:</span>
                <span class="info-value">{{ $user->email }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Role:</span>
                <span class="info-value">{{ ucfirst($user->role ?? 'user') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Status:</span>
                <span class="status-badge status-{{ $user->status }}">{{ ucfirst($user->status) }}</span>
            </div>
            @if($user->umkm)
            <div class="info-row">
                <span class="info-label">UMKM:</span>
                <span class="info-value">{{ $user->umkm->nama_usaha }}</span>
            </div>
            @endif

            <div style="margin-top: 24px; padding-top: 16px; border-top: 1px solid #e5e7eb;">
                <p style="color: #374151; margin-bottom: 16px;">User baru memerlukan approval untuk mengakses sistem.</p>
                <a href="{{ url('/user-management') }}" class="btn">Lihat di Panel Admin</a>
                <a href="{{ route('user-management.show', $user->id) }}" class="btn" style="margin-left: 12px;">Approve User</a>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Terima kasih,<br><strong>{{ config('app.name') }}</strong></p>
        </div>
    </div>
</body>
</html>