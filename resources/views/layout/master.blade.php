<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="{{ asset('assets/img/kaiadmin/favicon.ico') }}" type="image/x-icon" />
    <title>Dashboard - Surat Menyurat</title>

    @include('layout.header')

</head>

<body>
    <div class="wrapper">
        @include('sweetalert::alert')

        @include('layout.sidebar')


        <div class="main-panel">

            @include('layout.navbar')

            @yield('content')

            <footer class="footer">
                <div class="container-fluid d-flex justify-content-between">

                    <div class="copyright">
                        2024, made with <i class="fa fa-heart heart text-danger"></i> by
                        <a href="http://www.themekita.com">ThemeKita</a>
                    </div>

                </div>
            </footer>
        </div>

    </div>

    @include('layout.footer')

</body>

</html>
