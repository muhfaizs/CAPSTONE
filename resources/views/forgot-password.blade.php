<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.reset_password') }} - Certification Monitoring</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
        }

        body {
            min-height: 100vh;
            background: none;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
        }
        .bg-slideshow {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            width: 100vw;
            height: 100vh;
            z-index: -1;
            overflow: hidden;
        }
        .bg-slideshow img {
            position: absolute;
            width: 100vw;
            height: 100vh;
            object-fit: cover;
            left: 0; top: 0;
            opacity: 0;
            transition: opacity 1s ease-in-out;
            pointer-events: none;
            user-select: none;
        }
        .bg-slideshow img.active {
            opacity: 1;
            z-index: 1;
        }
        .forgot-card {
            background: rgba(255,255,255,0.7);
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.13);
            padding: 2.5rem 2rem 2rem 2rem;
            max-width: 480px;
            margin: 3rem auto;
            width: 100%;
        }
        .forgot-title {
            font-size: 2rem;
            font-weight: 600;
            color: #444;
            margin-bottom: 1.5rem;
            text-align: left;
        }
        .forgot-desc {
            font-size: 1rem;
            color: #444;
            margin-bottom: 1.5rem;
        }
        .form-control {
            border-radius: 24px;
            background: rgba(255,255,255,0.6);
            border: 1px solid #cfd8dc;
        }
        .forgot-btn {
            width: 100%;
            border-radius: 24px;
            font-weight: 600;
            font-size: 1.1rem;
            background: #6b90b6;
            color: #fff;
            border: none;
            padding: 0.7rem 0;
            margin-top: 1rem;
            margin-bottom: 0.5rem;
            transition: background 0.2s;
        }
        .forgot-btn:hover {
            background: #4d6a8a;
        }
        .forgot-info {
            font-size: 0.95rem;
            color: #888;
            margin-top: 1.2rem;
        }
        @media (max-width: 576px) {
            .forgot-card { padding: 1.5rem 0.5rem; }
        }

        .password-group {
            position: relative;
        }
        .form-control {
            border-radius: 24px !important;
            background: #f7f7f7;
            padding-right: 2.5rem;
        }
        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            padding: 0;
            margin: 0;
            color: #333;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 70%;
        }
        .toggle-password:focus {
            outline: none;
        }
        .toggle-password i {
            font-size: 1.5rem;
            line-height: 1;
        }
    </style>
</head>
<body>
    <div class="bg-slideshow">
        <img src="/images/EMP1.jpeg" class="active" draggable="false">
        <img src="/images/EMP2.jpeg" draggable="false">
        <img src="/images/EMP3.jpeg" draggable="false">
    </div>
    <div class="d-flex flex-column justify-content-center align-items-center min-vh-100">
        <div class="forgot-card">
            <div class="forgot-title">{{ __('messages.reset_password_title') }}</div>
            <div class="forgot-desc">{{ __('messages.reset_password_desc') }}</div>
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <div class="mb-3">
                    <label for="user" class="form-label">{{ __('messages.email_address') }} / {{ __('messages.username') }}</label>
                    <input type="text" class="form-control" id="user" name="user" required autofocus placeholder="{{ __('messages.enter_email_or_username') }}">
                </div>
                <div class="mb-3">
                    <label for="new_password" class="form-label">New Password</label>
                    <div class="password-group">
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                        <button class="toggle-password" type="button" data-target="new_password" tabindex="-1">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    <div class="form-text">{{ __('messages.password_must_be_8_chars') }}</div>
                    <ul class="small text-muted mb-3" id="password-rules" style="list-style: none; padding-left: 0;">
                        <li id="rule-length"><span class="rule-icon">&#9675;</span> {{ __('messages.use_8_or_more_chars') }}</li>
                        <li id="rule-upper"><span class="rule-icon">&#9675;</span> {{ __('messages.one_uppercase_char') }}</li>
                        <li id="rule-lower"><span class="rule-icon">&#9675;</span> {{ __('messages.one_lowercase_char') }}</li>
                        <li id="rule-number"><span class="rule-icon">&#9675;</span> {{ __('messages.one_number') }}</li>
                        <li id="rule-special"><span class="rule-icon">&#9675;</span> {{ __('messages.one_special_char') }}</li>
                    </ul>
                </div>
                <button type="submit" class="forgot-btn">{{ __('messages.reset_password') }}</button>
            </form>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const slides = document.querySelectorAll('.bg-slideshow img');
            let current = 0;
            setInterval(() => {
                slides[current].classList.remove('active');
                current = (current + 1) % slides.length;
                slides[current].classList.add('active');
            }, 5000);

            // Password rules validation for forgot password
            const passwordInput = document.getElementById('new_password');
            const rules = [
                { id: 'rule-length', test: v => v.length >= 8 },
                { id: 'rule-upper', test: v => /[A-Z]/.test(v) },
                { id: 'rule-lower', test: v => /[a-z]/.test(v) },
                { id: 'rule-number', test: v => /[0-9]/.test(v) },
                { id: 'rule-special', test: v => /[@$!%*#?&]/.test(v) },
            ];
            passwordInput.addEventListener('input', function() {
                const val = passwordInput.value;
                rules.forEach(rule => {
                    const li = document.getElementById(rule.id);
                    const icon = li.querySelector('.rule-icon');
                    if (rule.test(val)) {
                        icon.innerHTML = '&#10003;';
                        icon.style.color = 'green';
                        li.style.color = 'green';
                    } else {
                        icon.innerHTML = '&#9675;';
                        icon.style.color = '';
                        li.style.color = '';
                    }
                });
            });

            document.querySelectorAll('.toggle-password').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const target = document.getElementById(this.getAttribute('data-target'));
                    const icon = this.querySelector('i');
                    if (target.type === 'password') {
                        target.type = 'text';
                        icon.classList.remove('bi-eye');
                        icon.classList.add('bi-eye-slash');
                    } else {
                        target.type = 'password';
                        icon.classList.remove('bi-eye-slash');
                        icon.classList.add('bi-eye');
                    }
                });
            });
        });
    </script>
</body>
</html> 