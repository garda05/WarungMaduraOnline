<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Warung Madura Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background:#222831">

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow-lg p-4"
         style="width:420px;border-radius:16px;background:#393E46;color:#EEEEEE">

        <div class="text-center mb-4">
            <div class="rounded-circle d-inline-flex align-items-center justify-content-center"
                 style="width:64px;height:64px;font-size:28px;background:#00ADB5;color:#222831">
                🛒
            </div>
            <h4 class="mt-3">Warung Madura Online</h4>
            <p style="color:#bfc3c7">Masuk ke akun kamu</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email"
                       name="email"
                       class="form-control"
                       style="background:#222831;color:#EEEEEE;border:1px solid #00ADB5"
                       required autofocus>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password"
                       name="password"
                       class="form-control"
                       style="background:#222831;color:#EEEEEE;border:1px solid #00ADB5"
                       required>
            </div>

            <button class="btn w-100 fw-bold"
                    style="background:#00ADB5;color:#222831">
                Masuk
            </button>
        </form>

        <div class="text-center mt-3">
            <a href="{{ route('register') }}"
               style="color:#00ADB5;text-decoration:none;font-weight:600">
                Belum punya akun? Daftar sekarang
            </a>
        </div>

    </div>
</div>

</body>
</html>
