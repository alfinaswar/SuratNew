<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="DexignLab">
    <meta name="robots" content="">
    <meta name="keywords" content="Sistem Kalibrasi Alat Medis">
    <meta name="description"
        content="We proudly present Jobick, a Job Admin dashboard HTML Template, If you are hiring a job expert you would like to build a superb website for your Jobick, it's a best choice.">
    <meta property="og:title" content="Jobick : Job Admin Dashboard Bootstrap 5 Template + FrontEnd">
    <meta property="og:description" content="Sistem Kalibrasi Alat Medis">
    <meta property="og:image" content="https://jobick.dexignlab.com/xhtml/social-image.png">

    <!-- Mobile Specific -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- PAGE TITLE HERE -->
    <title>Login Page</title>

    <!-- Favicon icon -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('') }}assets/images/favicon.png">
    <link href="{{ asset('') }}assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="{{ asset('') }}assets/css/style.css" rel="stylesheet">

</head>

<body class="vh-100">
    <div class="container-fluid vh-100 d-flex align-items-center justify-content-center" style="background: #f5f6fa;">
        <div class="row w-100" style="min-height: 80vh;">
            <!-- Keterangan Aplikasi (Kiri) -->
            <div class="col-md-6 d-flex flex-column justify-content-center align-items-center text-center p-5"
                style="background: #fff;">
                <img src="{{ asset('assets/images/logo/e-surat.png') }}" alt="Logo" style="max-width: 180px;"
                    class="mb-4">
                <h2 class="mb-3" style="font-weight: 700;">Sistem aplikasi e-surat</h2>
                <p class="mb-4" style="font-size: 1.1rem;">
                    Selamat datang di aplikasi e-surat <b>aplikasi e-surat</b>.<br>
                    Silakan login untuk mengakses fitur aplikasi.<br>
                    <br>
                    <span class="text-muted" style="font-size: 0.95rem;">
                        © {{ date('Y') }} Alfin Aswar.
                    </span>
                </p>
            </div>
            <!-- Form Login (Kanan) -->
            <div class="col-md-6 d-flex align-items-center justify-content-center" style="background: #f5f6fa;">
                <div class="w-100" style="max-width: 400px;">
                    <div class="card shadow border-0">
                        <div class="card-body p-4">
                            <h4 class="mb-4 text-center">Login</h4>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus
                                        placeholder="Masukkan email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password" placeholder="Masukkan password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">Ingat saya</label>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--**********************************
 Scripts
***********************************-->
    <!-- Required vendors -->
    <script src="{{ asset('') }}assets/vendor/global/global.min.js"></script>
    <script src="{{ asset('') }}assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="{{ asset('') }}assets/js/dlabnav-init.js"></script>
    <script src="{{ asset('') }}assets/js/custom.min.js"></script>

</body>

</html>