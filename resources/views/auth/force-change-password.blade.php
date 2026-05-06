<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Password - Perpus Sandikta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family:'Inter',sans-serif; min-height:100vh; background:linear-gradient(135deg,#0f172a,#1e3a8a,#3b82f6); display:flex; align-items:center; justify-content:center; }
        .card-change { background:rgba(255,255,255,0.08); backdrop-filter:blur(40px); border:1px solid rgba(255,255,255,0.12); border-radius:24px; padding:48px 40px; max-width:460px; width:100%; margin:20px; box-shadow:0 25px 60px rgba(0,0,0,0.3); }
        .card-change h3 { color:#fff; font-weight:800; text-align:center; margin-bottom:8px; }
        .card-change p { color:rgba(255,255,255,0.5); text-align:center; font-size:14px; margin-bottom:30px; }
        .card-change label { color:rgba(255,255,255,0.7); font-size:13px; font-weight:600; margin-bottom:8px; display:block; }
        .card-change input { width:100%; padding:14px 16px; background:rgba(255,255,255,0.06); border:2px solid rgba(255,255,255,0.1); border-radius:14px; color:#fff; font-size:15px; margin-bottom:16px; }
        .card-change input:focus { outline:none; border-color:rgba(96,165,250,0.6); background:rgba(255,255,255,0.1); }
        .card-change input::placeholder { color:rgba(255,255,255,0.3); }
        .btn-save { width:100%; padding:15px; background:linear-gradient(135deg,#3b82f6,#1e40af); border:none; border-radius:14px; color:#fff; font-size:16px; font-weight:700; cursor:pointer; box-shadow:0 4px 20px rgba(59,130,246,0.35); }
        .btn-save:hover { transform:translateY(-2px); box-shadow:0 8px 30px rgba(59,130,246,0.5); }
        .error-msg { background:rgba(239,68,68,0.15); border:1px solid rgba(239,68,68,0.3); border-radius:12px; padding:12px 16px; color:#fca5a5; font-size:13px; margin-bottom:20px; }
        .icon-wrap { width:72px; height:72px; background:linear-gradient(135deg,#f59e0b,#d97706); border-radius:20px; margin:0 auto 18px; display:flex; align-items:center; justify-content:center; }
        .icon-wrap i { font-size:32px; color:#fff; }
        .password-group {
            position: relative;
            margin-bottom: 16px;
        }
        .password-group input {
            margin-bottom: 0 !important;
            padding-right: 48px !important;
        }
        .toggle-password-btn {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            z-index: 5;
            color: rgba(255, 255, 255, 0.4);
            font-size: 18px;
            transition: color 0.3s ease;
        }
        .toggle-password-btn:hover {
            color: rgba(255, 255, 255, 0.8);
        }
    </style>
</head>
<body>
    <div class="card-change">
        <div class="icon-wrap"><i class="bi bi-shield-lock"></i></div>
        <h3>Ubah Password</h3>
        <p>Demi keamanan, Anda wajib mengubah password sebelum melanjutkan.</p>

        @if($errors->any())
        <div class="error-msg"><i class="bi bi-exclamation-circle me-2"></i>{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('password.force-update') }}">
            @csrf
            <label>Password Baru</label>
            <div class="password-group">
                <input type="password" name="password" id="password" placeholder="Minimal 8 karakter" required>
                <i class="bi bi-eye-slash toggle-password-btn" id="togglePassword"></i>
            </div>
            <label>Konfirmasi Password</label>
            <div class="password-group">
                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Ulangi password baru" required>
                <i class="bi bi-eye-slash toggle-password-btn" id="togglePasswordConfirmation"></i>
            </div>
            <button type="submit" class="btn-save"><i class="bi bi-check-lg me-2"></i>Simpan Password Baru</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const setupToggle = (toggleId, inputId) => {
                const toggle = document.querySelector(toggleId);
                const input = document.querySelector(inputId);
                if (toggle && input) {
                    toggle.addEventListener('click', function () {
                        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                        input.setAttribute('type', type);
                        
                        this.classList.toggle('bi-eye');
                        this.classList.toggle('bi-eye-slash');
                    });
                }
            };

            setupToggle('#togglePassword', '#password');
            setupToggle('#togglePasswordConfirmation', '#password_confirmation');
        });
    </script>
</body>
</html>
