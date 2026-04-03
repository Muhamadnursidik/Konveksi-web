<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/theme.min.css') }}">
</head>

<body>
<main class="auth-minimal-wrapper">
    <div class="auth-minimal-inner">
        <div class="minimal-card-wrapper">
            <div class="card mb-4 mt-5 mx-4 mx-sm-0 position-relative">

                {{-- Logo --}}
                <div class="wd-50 bg-white p-2 rounded-circle shadow-lg position-absolute translate-middle top-0 start-50">
                    <img src="{{ asset('assets/images/logo-abbr.png') }}" class="img-fluid">
                </div>

                <div class="card-body p-sm-5">

                    <h2 class="fs-20 fw-bolder mb-2 text-center">Login</h2>
                    <p class="fs-12 fw-medium text-muted text-center mb-4">
                        Login ke akun Anda untuk melanjutkan
                    </p>

                    {{-- Session status --}}
                    <x-auth-session-status class="mb-3" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="w-100 mt-3">
                        @csrf

                        {{-- Email --}}
                        <div class="mb-4">
                            <input
                                type="email"
                                name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="Email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                            >
                            <x-input-error :messages="$errors->get('email')" class="mt-1"/>
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <input
                                type="password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Password"
                                required
                            >
                            <x-input-error :messages="$errors->get('password')" class="mt-1"/>
                        </div>

                        {{-- Remember + Forgot --}}
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="remember"
                                    id="remember"
                                >
                                <label class="form-check-label" for="remember">
                                    Remember me
                                </label>
                            </div>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="fs-11 text-primary">
                                    Forgot password?
                                </a>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-lg btn-primary w-100">
                            Login
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</main>

<script src="{{ asset('assets/vendors/js/vendors.min.js') }}"></script>
<script src="{{ asset('assets/js/common-init.min.js') }}"></script>
<script src="{{ asset('assets/js/theme-customizer-init.min.js') }}"></script>
</body>
</html>
