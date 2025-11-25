<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login • WokaTask</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: "Poppins", sans-serif;
            background: #0e1538;
            height: 100vh;
            overflow: hidden;
            position: relative;
        }

        /* Animated Scientific Background */
        .scientist-bg {
            position: absolute;
            width: 100%;
            height: 100%;
            background: url('https://i.ibb.co/WDVjZkM/tech-bg.jpg');
            background-size: cover;
            background-position: center;
            opacity: 0.23;
            animation: move-bg 28s linear infinite;
            z-index: 1;
        }

        @keyframes move-bg {
            from {
                background-position: 0 0;
            }

            to {
                background-position: 2000px 1200px;
            }
        }

        /* Center Container */
        .login-container {
            min-height: 100vh;
            z-index: 2;
            position: relative;
        }

        /* Login Box */
        .login-card {
            width: 420px;
            background: rgba(255, 255, 255, 0.13);
            backdrop-filter: blur(12px);
            border-radius: 18px;
            padding: 30px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            animation: fadeUp .8s ease;
        }

        @keyframes fadeUp {
            from {
                transform: translateY(30px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .brand-title {
            font-size: 30px;
            color: #13e8ff;
            font-weight: 700;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.18);
            border: none;
            color: #fff;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.27);
            color: #fff;
            border-color: #13e8ff;
            box-shadow: 0 0 8px #13e8ff;
        }

        .btn-primary {
            background: #13e8ff;
            border: none;
            font-weight: 600;
        }

        .btn-primary:hover {
            background: #10cadc;
        }

        a {
            color: #13e8ff;
            text-decoration: none;
        }

        a:hover {
            color: #0dc2d4;
        }
    </style>
</head>

<body>

    <!-- Scientific Background -->
    <div class="scientist-bg"></div>

    <!-- Center Form -->
    <div class="container d-flex justify-content-center align-items-center login-container">
        <div class="login-card text-center">

            <i class="bi bi-bezier2 fs-1 mb-2" style="color:#13e8ff;"></i>
            <h3 class="brand-title">WokaTask</h3>
            <p class="mb-4">Scientific Project Monitoring</p>

            {{-- ALERT ERROR LOGIN --}}
            @if ($errors->any())
            <div class="alert alert-danger text-start">
                @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
                @endforeach
            </div>
            @endif

            @error('success')
            <div class="alert alert-success text-start">{{ $message }}</div>
            @enderror


            <form method="POST" action="{{ url('/login') }}" role="form">
                @csrf
                <!-- If Laravel: @csrf -->
                <div class="mb-3 text-start">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control form-control-lg" placeholder="Masukan email" required>
                </div>

                <div class="mb-3 text-start">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control form-control-lg" placeholder="Masukan password" required>
                </div>

                <button class="btn btn-primary w-100 btn-lg mt-3">Login</button>
            </form>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>