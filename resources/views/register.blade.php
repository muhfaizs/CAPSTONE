<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Certification Monitoring</title>
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
        .login-card {
            background: rgba(255,255,255,0.7);
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.13);
            padding: 2.5rem 2rem 2rem 2rem;
            max-width: 480px;
            margin: 3rem auto;
            width: 100%;
        }
        .login-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #444;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        .form-control {
            border-radius: 8px;
            background: rgba(255,255,255,0.6);
            border: 1px solid #cfd8dc;
        }
        .login-btn {
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
        .login-btn:hover {
            background: #4d6a8a;
        }
        .login-link {
            text-align: center;
            margin-top: 0.5rem;
            font-size: 0.97rem;
        }
        .login-link a {
            font-weight: 600;
            color: #2196f3 !important;
            text-decoration: underline;
        }
        .terms {
            font-size: 0.93rem;
            color: #666;
            margin-bottom: 1.2rem;
        }
        @media (max-width: 576px) {
            .login-card { padding: 1.5rem 0.5rem; }
        }
        .password-group {
            position: relative;
        }
        .form-control {
            background: #f7f7f7; /* abu-abu muda */
            border-radius: 24px;
            padding-right: 2.5rem;
        }
        .password-group .form-control {
            border-radius: 24px;
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
        <div class="login-card">
            <div class="login-title">Create your account</div>
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
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required autofocus>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-control" id="role" name="role" required>
                        <option value="">Select Role</option>
                        <option value="HRD">HRD</option>
                        <option value="Employee">Employee</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="password-group">
                        <input type="password" class="form-control" id="password" name="password" required>
                        <button class="toggle-password" type="button" data-target="password" tabindex="-1">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>
                <ul class="small text-muted mb-3" id="password-rules" style="list-style: none; padding-left: 0;">
                    <li id="rule-length"><span class="rule-icon">&#9675;</span> Use 8 or more characters</li>
                    <li id="rule-upper"><span class="rule-icon">&#9675;</span> One Uppercase character</li>
                    <li id="rule-lower"><span class="rule-icon">&#9675;</span> One lowercase character</li>
                    <li id="rule-number"><span class="rule-icon">&#9675;</span> One number</li>
                </ul>
                <div class="terms mb-3">
                    By creating an account, you agree to the <a href="#">Terms of use</a> and <a href="#">Privacy Policy</a>.
                </div>
                <button type="submit" class="login-btn">Register</button>
            </form>
            <div class="login-link">
                Already have an account? <a href="{{ route('login') }}">Log in</a>
            </div>
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

            // Password rules validation for register
            const passwordInput = document.getElementById('password');
            const rules = [
                { id: 'rule-length', test: v => v.length >= 8 },
                { id: 'rule-upper', test: v => /[A-Z]/.test(v) },
                { id: 'rule-lower', test: v => /[a-z]/.test(v) },
                { id: 'rule-number', test: v => /[0-9]/.test(v) },
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

            // Toggle show/hide password for register
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