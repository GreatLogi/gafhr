<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }}</title>
    <link rel="icon" href="{{ asset('assets/images/LOGO-ICON.PNG') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @livewireStyles
</head>

<body>
    <div class="auth-wrapper align-items-stretch aut-bg-img">
        <div class="flex-grow-1">
            <div class="h-100 d-md-flex align-items-center auth-side-img">
                <div class="w-auto col-sm-10 auth-content"></div>
            </div>
            <div class="auth-side-form">
                <div class="auth-content">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/vendor-all.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/ripple.js') }}"></script>
    <script src="{{ asset('assets/js/pcoded.min.js') }}"></script>
    @livewireScripts
</body>

</html>
