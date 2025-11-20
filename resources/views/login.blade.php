<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="icon" type="image/x-icon" href="xxxxxx"/>
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/icons/bootstrap-icons.css">
        <title>CekSPP | Login</title>
        <style>
            body {
                background: #dff2ff;
            }

            .login-card {
                width: 380px;
                border-radius: 20px;
                padding: 30px;
                background: #ffffffd9;
                backdrop-filter: blur(6px);
                box-shadow: 0px 6px 25px rgba(0,0,0,0.15);
            }

            .logo {
                width: 90px;
                height: 90px;
                border-radius: 50%;
                object-fit: cover;
                margin-bottom: 10px;
            }

            .btn-primary {
                background-color: #3399ff;
                border: none;
            }

            .btn-primary:hover {
                background-color: #1a8cff;
            }

            .small-info {
                font-size: 0.85rem;
                color: #555;
            }

            .show-btn {
                cursor: pointer;
            }
        </style>
    </head>
    <body>

        <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
            <div class="login-card text-center">

                <!-- Logo -->
                <img src="" alt="Logo" class="logo">

                <h4 class="mb-3" style="color:#007acc;">Selamat Datang</h4>
                <p class="small-info mb-4">Silakan login untuk mengakses aplikasi.</p>

                @if ($errors->any())
                    <div class="alert alert-danger" id="gagal">
                        {{ $errors->first() }}
                    </div>

                    <script>
                        setTimeout(function() {
                            var alertElement = document.getElementById('gagal');
                            alertElement.remove('show');
                        }, 3000);
                    </script>
                @endif


                <form action="/login/proses" method="POST">@csrf

                    <div class="mb-3 text-start">
                        <label class="form-label fw-semibold">Username</label>
                        <input type="text" class="form-control" name="username" placeholder="Masukkan username / NIS" required>
                    </div>

                    <div class="mb-3 text-start">
                        <label class="form-label fw-semibold">Password</label>

                        <div class="input-group">
                            <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password" required>
                            <span class="input-group-text show-btn" onclick="togglePassword()">
                                <i class="bi bi-eye"></i>
                            </span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember">Remember me</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mt-2">Masuk</button>
                </form>

                <p class="small-info mt-4">CekSPP — Versi 1.0</p>

            </div>
        </div>

        <script>
            function togglePassword() {
                const field = document.getElementById("password");
                field.type = field.type === "password" ? "text" : "password";
            }
        </script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
