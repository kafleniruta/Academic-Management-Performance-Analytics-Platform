<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body { background: #f8fafc; font-family: 'Segoe UI', sans-serif; }
        .glass-card { background: white; border-radius: 1rem; border: 1px solid #e2e8f0; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .section-divider { border-top: 1px solid #e2e8f0; padding-top: 1.25rem; margin-top: 1.25rem; }
        .form-label { font-size: 0.85rem; font-weight: 600; color: #475569; }
        .form-control:focus { border-color: #93c5fd; box-shadow: 0 0 0 3px rgba(147,197,253,0.3); }
        .input-icon { position: relative; }
        .input-icon i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.85rem; }
        .input-icon .form-control { padding-left: 2.2rem; }
        .btn-save { background: linear-gradient(135deg, #3b82f6, #2563eb); border: none; color: white; border-radius: 0.6rem; padding: 0.5rem 1.5rem; font-weight: 600; transition: opacity 0.2s; }
        .btn-save:hover { opacity: 0.9; color: white; }
        .avatar-circle { width: 64px; height: 64px; border-radius: 50%; background: linear-gradient(135deg, #3b82f6, #7c3aed); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: 700; color: white; }
    </style>
</head>
<body>

<div class="container py-4" style="max-width: 680px;">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('student.dashboard') }}" class="btn btn-outline-secondary btn-sm mb-2">
                <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
            </a>
            <h4 class="fw-bold mb-0">Edit Profile</h4>
            <p class="text-muted small mb-0">Update your contact details and password</p>
        </div>
    </div>

    {{-- Success / Error Alerts --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Profile Card --}}
    <div class="glass-card p-4">

        {{-- Avatar + Name --}}
        <div class="d-flex align-items-center gap-3 mb-4">
            <div class="avatar-circle">
                {{ strtoupper(substr(Auth::user()->email, 0, 1)) }}
            </div>
            <div>
                <div class="fw-bold">{{ Auth::user()->student->student_name ?? Auth::user()->email }}</div>
                <div class="text-muted small">{{ Auth::user()->email }}</div>
                <span class="badge bg-primary bg-opacity-10 text-primary small text-capitalize">{{ Auth::user()->role }}</span>
            </div>
        </div>

        {{-- ── Section 1: Contact Info ── --}}
        <form method="POST" action="{{ route('student.profile.update') }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="form_type" value="contact">

            <h6 class="fw-semibold mb-3 text-primary"><i class="fas fa-address-book me-2"></i>Contact Information</h6>

            <div class="mb-3">
                <label class="form-label">Contact Number</label>
                <div class="input-icon">
                    <i class="fas fa-phone"></i>
                    <input
                        type="text"
                        name="contact_number"
                        class="form-control @error('contact_number') is-invalid @enderror"
                        value="{{ old('contact_number', Auth::user()->contact_number) }}"
                        placeholder="e.g. 9800000000"
                        maxlength="20"
                    >
                </div>
                @error('contact_number')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Address</label>
                <div class="input-icon">
                    <i class="fas fa-map-marker-alt"></i>
                    <input
                        type="text"
                        name="address"
                        class="form-control @error('address') is-invalid @enderror"
                        value="{{ old('address', Auth::user()->student->address ?? '') }}"
                        placeholder="e.g. 123 Main St, City"
                    >
                </div>
                @error('address')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-save">
                <i class="fas fa-save me-2"></i>Save Contact Info
            </button>
        </form>

        {{-- ── Section 2: Change Password ── --}}
        <div class="section-divider">
            <form method="POST" action="{{ route('student.profile.update') }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="form_type" value="password">

                <h6 class="fw-semibold mb-3 text-primary"><i class="fas fa-lock me-2"></i>Change Password</h6>

                <div class="mb-3">
                    <label class="form-label">Current Password</label>
                    <div class="input-icon">
                        <i class="fas fa-key"></i>
                        <input
                            type="password"
                            name="current_password"
                            class="form-control @error('current_password') is-invalid @enderror"
                            placeholder="Enter your current password"
                            autocomplete="current-password"
                        >
                    </div>
                    @error('current_password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">New Password</label>
                    <div class="input-icon">
                        <i class="fas fa-lock"></i>
                        <input
                            type="password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Minimum 8 characters"
                            autocomplete="new-password"
                        >
                    </div>
                    @error('password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Confirm New Password</label>
                    <div class="input-icon">
                        <i class="fas fa-lock"></i>
                        <input
                            type="password"
                            name="password_confirmation"
                            class="form-control"
                            placeholder="Re-enter new password"
                            autocomplete="new-password"
                        >
                    </div>
                </div>

                <button type="submit" class="btn btn-save" style="background: linear-gradient(135deg, #10b981, #059669);">
                    <i class="fas fa-shield-alt me-2"></i>Update Password
                </button>
            </form>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
