<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login – Student Portal</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4f46e5 100%);
            min-height: 100vh; display: flex; align-items: center; justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }
        .login-wrap {
            background: #fff; border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,.3);
            width: 100%; max-width: 420px; padding: 40px 36px;
        }
        .login-logo {
            text-align: center; margin-bottom: 28px;
        }
        .login-logo .icon-circle {
            width: 68px; height: 68px; background: #ede9fe;
            border-radius: 50%; display: inline-flex; align-items: center;
            justify-content: center; font-size: 2rem; color: #4f46e5; margin-bottom: 12px;
        }
        .login-logo h2 { font-weight: 800; color: #1e1b4b; font-size: 1.45rem; margin: 0; }
        .login-logo p  { color: #9ca3af; font-size: 0.85rem; margin-top: 4px; }
        .form-label { font-weight: 600; font-size: 0.85rem; color: #374151; }
        .form-control {
            border: 1.5px solid #e5e7eb; border-radius: 9px;
            padding: 11px 14px; font-size: 0.92rem;
        }
        .form-control:focus {
            border-color: #4f46e5; box-shadow: 0 0 0 3px rgba(79,70,229,.12); outline: none;
        }
        .btn-login {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: #fff; border: none; border-radius: 9px;
            padding: 12px; font-size: 0.95rem; font-weight: 700;
            width: 100%; cursor: pointer; transition: opacity .15s;
            letter-spacing: 0.3px;
        }
        .btn-login:hover { opacity: 0.9; }
        .alert-err {
            background: #fef2f2; border: 1px solid #fecaca; color: #dc2626;
            padding: 10px 14px; border-radius: 9px; font-size: 0.85rem; margin-bottom: 16px;
        }
        .demo-box {
            background: #f8f7ff; border: 1px solid #ede9fe;
            border-radius: 10px; padding: 14px 16px; margin-top: 22px;
            font-size: 0.8rem; color: #5b21b6;
        }
        .demo-box strong { display: block; color: #4f46e5; margin-bottom: 6px; font-size: 0.82rem; }
    </style>
</head>
<body>
<div class="login-wrap">
    <div class="login-logo">
        <div class="icon-circle"><i class="fas fa-graduation-cap"></i></div>
        <h2>StudyPortal</h2>
        <p>Apne account mein login karein</p>
    </div>

    @if($errors->any())
        <div class="alert-err">
            <i class="fas fa-exclamation-circle"></i>
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control"
                   value="{{ old('email') }}" placeholder="aap@email.com" required autofocus>
        </div>
        <div class="mb-4">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control"
                   placeholder="••••••••" required>
        </div>
        <button type="submit" class="btn-login">
            <i class="fas fa-sign-in-alt"></i> Login Karein
        </button>
    </form>

    <div class="demo-box">
        <strong><i class="fas fa-info-circle"></i> Default Admin Login:</strong>
        📧 admin@portal.com &nbsp;|&nbsp; 🔑 password
    </div>
</div>
</body>
</html>
