<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile – Teacher</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f2f5;
            color: #333;
            min-height: 100vh;
            padding: 40px 20px;
            display: flex;
            justify-content: center; /* Centers horizontally */
        }

        /* ── Centered Container ── */
        .main-wrapper {
            width: 100%;
            max-width: 800px; /* Increased width for a better feel */
        }

        /* ── Back Button ── */
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 7px 16px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #fff;
            color: #374151;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            margin-bottom: 24px;
            transition: background 0.2s;
        }
        .back-btn:hover { background: #f9fafb; }

        /* ── Page Title ── */
        .page-header {
            text-align: center; /* Centers the title text */
            margin-bottom: 32px;
        }
        .page-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #111;
            margin-bottom: 6px;
        }
        .page-subtitle {
            font-size: 0.95rem;
            color: #6b7280;
        }

        /* ── Card ── */
        .card {
            background: #fff;
            border-radius: 14px;
            border: 1px solid #e5e7eb;
            padding: 40px; /* Increased padding */
            width: 100%;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        /* ── Profile Header ── */
        .profile-header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 35px;
            padding-bottom: 25px;
            border-bottom: 1px dashed #e5e7eb;
        }
        .avatar {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }
        .profile-info-name {
            font-size: 1.25rem;
            font-weight: 700;
            color: #111;
        }
        .profile-info-email {
            font-size: 0.9rem;
            color: #6b7280;
            margin-top: 2px;
        }
        .role-badge {
            display: inline-block;
            margin-top: 8px;
            padding: 3px 14px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            background: #dbeafe;
            color: #1d4ed8;
        }

        /* ── Section Title ── */
        .section-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            color: #2563eb;
            margin-bottom: 24px;
        }

        /* ── Form Styling ── */
        .form-group { margin-bottom: 22px; }
        .form-group label {
            display: block;
            font-size: 0.9rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 8px;
        }
        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }
        .input-icon {
            position: absolute;
            left: 16px;
            color: #9ca3af;
            font-size: 0.9rem;
        }
        .form-control {
            width: 100%;
            padding: 12px 16px 12px 42px;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            font-size: 0.95rem;
            color: #111;
            background: #fff;
            transition: all 0.2s;
            outline: none;
        }
        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37,99,235,0.1);
        }

        /* ── Buttons ── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 28px;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
        }
        .btn-primary { background: #2563eb; color: #fff; }
        .btn-primary:hover { background: #1d4ed8; }
        .btn-success { background: #059669; color: #fff; }
        .btn-success:hover { background: #047857; }

        .divider { border: none; border-top: 1px solid #e5e7eb; margin: 35px 0; }
        .alert { padding: 14px; border-radius: 10px; margin-bottom: 20px; font-size: 0.9rem; display: flex; align-items: center; gap: 10px; }
        .alert-success { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }
        .alert-error { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
        .field-error { font-size: 0.85rem; color: #dc2626; margin-top: 6px; }
    </style>
</head>
<body>

    <div class="main-wrapper">
        {{-- Back Button --}}
        <a href="{{ route('teacher.dashboard') }}" class="back-btn">
            <i class="fa fa-arrow-left"></i> Back to Dashboard
        </a>

        {{-- Page Header --}}
        <div class="page-header">
            <div class="page-title">Edit Profile</div>
            <div class="page-subtitle">Update your contact details and password</div>
        </div>

        <div class="card">
            {{-- Profile Header --}}
            <div class="profile-header">
                <div class="avatar">
                    {{ strtoupper(substr(Auth::user()->email, 0, 1)) }}
                </div>
                <div>
                    <div class="profile-info-name">
                        {{ Auth::user()->teacher->teacher_name ?? Auth::user()->full_name ?? 'Teacher' }}
                    </div>
                    <div class="profile-info-email">{{ Auth::user()->email }}</div>
                    <span class="role-badge">Teacher Account</span>
                </div>
            </div>

            {{-- ── Contact Information ── --}}
            <div class="section-title">
                <i class="fa fa-address-card"></i> Contact Information
            </div>

            @if(session('contact_success'))
                <div class="alert alert-success">
                    <i class="fa fa-circle-check"></i> {{ session('contact_success') }}
                </div>
            @endif

            <form action="{{ route('teacher.profile.updateContact') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Contact Number</label>
                    <div class="input-wrapper">
                        <i class="fa fa-phone input-icon"></i>
                        <input type="text" name="contact_number" class="form-control" value="{{ old('contact_number', Auth::user()->contact_number) }}">
                    </div>
                    @error('contact_number') <div class="field-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label>Address</label>
                    <div class="input-wrapper">
                        <i class="fa fa-location-dot input-icon"></i>
                        <input type="text" name="address" class="form-control" value="{{ old('address', Auth::user()->address) }}">
                    </div>
                    @error('address') <div class="field-error">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-floppy-disk"></i> Save Contact Info
                </button>
            </form>

            <hr class="divider">

            {{-- ── Change Password ── --}}
            <div class="section-title">
                <i class="fa fa-lock"></i> Security & Password
            </div>

            @if(session('password_success'))
                <div class="alert alert-success">
                    <i class="fa fa-circle-check"></i> {{ session('password_success') }}
                </div>
            @endif

            <form action="{{ route('teacher.profile.updatePassword') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Current Password</label>
                    <div class="input-wrapper">
                        <i class="fa fa-key input-icon"></i>
                        <input type="password" name="current_password" class="form-control" placeholder="Required to make changes">
                    </div>
                    @error('current_password') <div class="field-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label>New Password</label>
                    <div class="input-wrapper">
                        <i class="fa fa-lock input-icon"></i>
                        <input type="password" name="new_password" class="form-control" placeholder="At least 8 characters">
                    </div>
                    @error('new_password') <div class="field-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label>Confirm New Password</label>
                    <div class="input-wrapper">
                        <i class="fa fa-lock input-icon"></i>
                        <input type="password" name="new_password_confirmation" class="form-control">
                    </div>
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="fa fa-shield-halved"></i> Update Password
                </button>
            </form>
        </div>
    </div>

</body>
</html>