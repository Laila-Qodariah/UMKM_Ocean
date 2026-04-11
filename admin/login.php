<?php
if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | UMKM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&display=swap" rel="stylesheet">
    <style>
        .login-header h3 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        :root{
            --ocean-1:#023e8a;
            --ocean-2:#0077b6;
            --ocean-3:#0096c7;
            --ocean-4:#48cae4;
        }
        body{
            min-height:100vh;
            margin:0;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:20px;
            background:
                radial-gradient(circle at top left, rgba(72,202,228,.35), transparent 30%),
                linear-gradient(135deg, var(--ocean-1), var(--ocean-2), var(--ocean-3));
            font-family: Arial, sans-serif;
        }
        .login-card{
            width:100%;
            max-width:450px;
            border:none;
            border-radius:24px;
            overflow:hidden;
            box-shadow:0 20px 50px rgba(2,62,138,.28);
        }
        .login-header{
            background:linear-gradient(135deg, var(--ocean-1), var(--ocean-3));
            color:#fff;
            text-align:center;
            padding:34px 24px 24px;
        }
        .login-body{
            background:#fff;
            padding:30px;
        }
        .form-control{
            border-radius:14px;
            padding:12px 14px;
        }
        .btn-login{
            border:none;
            border-radius:14px;
            padding:12px;
            font-weight:700;
            background:linear-gradient(135deg, var(--ocean-2), var(--ocean-3));
        }
        .captcha-box{
            display:flex;
            gap:10px;
            align-items:center;
            flex-wrap:wrap;
        }
        .captcha-img{
            border:1px solid #d7e7f3;
            border-radius:12px;
            height:50px;
            background:#f8fbff;
        }
    </style>
</head>
<body>

<div class="card login-card">
    <div class="login-header">
        <h3 class="mb-1">ADMIN LOGIN</h3>
        <p class="mb-0">Silakan masuk ke panel admin</p>
    </div>

    <div class="login-body">
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <form action="proses_login.php" method="POST" autocomplete="off">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Captcha</label>
                <div class="captcha-box mb-2">
                    <img src="captcha.php" alt="captcha" class="captcha-img" id="captchaImage">
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="refreshCaptcha()">Refresh</button>
                </div>
                <input type="text" name="captcha" class="form-control" placeholder="Masukkan 4 karakter captcha" maxlength="4" required>
            </div>

            <div class="d-grid">
                <button type="submit" name="login" class="btn btn-primary btn-login">Login Admin</button>
            </div>
        </form>
    </div>
</div>

<script>
function refreshCaptcha() {
    document.getElementById('captchaImage').src = 'captcha.php?' + Date.now();
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>