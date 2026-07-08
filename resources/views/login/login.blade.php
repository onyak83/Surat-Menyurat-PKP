<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <title>Login</title>

    @include('login.loginheader')
</head>

<body>
    <div class="d-lg-flex half">
        <div class="bg order-1 order-md-2"
            style="background-image: url('{{ asset('templatelogin/images/gbr_login.png') }}');"></div>
        <div class="contents order-2 order-md-1">

            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-7">
                        @if ($errors->any())
                            <div class="text-danger text-center mb-2" style="font-size: 0.875rem;">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <h3 class="text-center mb-2">
                            Selamat Datang di <strong>SIPAT</strong>
                        </h3>

                        <p class="text-center text-muted mb-4">
                            Sistem Informasi Pencatatan Surat
                        </p>

                        <form action="{{ route('authenticate') }}" method="POST">
                            @csrf
                            <div class="form-group first">
                                <label for="username">Username</label>
                                <input type="email" class="form-control" name="email" id="email"
                                    placeholder="example@gmail.com" value="{{ old('email') }}" autocomplete="email"
                                    required>

                                @error('email')
                                    <div class="text-danger mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>
                            <div class="form-group last mb-3">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" id="password"
                                    placeholder="Masukkan Password" autocomplete="current-password" required>

                                @error('password')
                                    <div class="text-danger mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="d-flex mb-5 align-items-center">
                                <label class="control control--checkbox mb-0"><span class="caption">Ingatkan saya</span>
                                    <input type="checkbox" id="ckb1" name="remember" />
                                    <div class="control__indicator"></div>
                                </label>
                                <span class="ml-auto"><a href="#" class="forgot-pass">Lupa Password</a></span>
                            </div>

                            <input type="submit" value="Login" class="btn btn-block btn-primary">

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('login.loginfooter')

</body>

</html>
