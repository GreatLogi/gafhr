<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ config('app.name') }}</title>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="keywords" content="">
    <meta name="author" content="Phoenixcoded" />
    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('assets/images/LOGO-ICON.PNG ') }}" type="image/x-icon">
    <!-- vendor css -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<!-- [ signin-img ] start -->
<div class="auth-wrapper align-items-stretch aut-bg-img">
    <div class="flex-grow-1">
        <div class="h-100 d-md-flex align-items-center auth-side-img">
            <div class="w-auto col-sm-10 auth-content">
                {{-- <img src="assets/images/auth/auth-logo.png" alt="" class="img-fluid"> --}}
                {{-- <h1 class="my-4 text-white">Welcome Back!</h1>
                <h4 class="text-white font-weight-normal">Signin to your account and get explore the Able pro Dashboard
                    Template.<br />Do not forget to play with live customizer</h4> --}}
            </div>
        </div>
        <div class="auth-side-form">
            <div class=" auth-content">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <h5 class="mb-3 f-w-400">USER AUTHENTICATION</h5>
                <form method="POST" action="{{ route('login.dashboard') }}">
                    @csrf
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ session('success') }}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if (session('info'))
                        <div class="alert alert-info">
                            {{ session('info') }}
                        </div>
                    @endif
                    <div class="mb-3 form-group">
                        <label class="floating-label" for="Email">Email address</label>
                        <input type="text" class="form-control" id="email" type="email" name="email">
                        @if ($error = $errors->first('email'))
                            <div class="alert alert-danger">
                                {{ $error }}
                            </div>
                        @endif
                    </div>
                    <div class="mb-4 form-group">
                        <label class="floating-label" for="Password">Password</label>
                        <input type="password" class="form-control" id="password" type="password" name="password">
                        @if ($error = $errors->first('password'))
                            <div class="alert alert-danger">
                                {{ $error }}
                            </div>
                        @endif
                    </div>
                    <button class="mb-4 btn btn-block btn-primary">Signin</button>
                    <p class="mb-2 text-muted">Forgot password?
                        <a href="{{ route('forgot-password') }}" class="f-w-400">Reset</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- [ signin-img ] end -->
<!-- Required Js -->
<script src="{{ asset('assets/js/vendor-all.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/ripple.js') }}"></script>
<script src="{{ asset('assets/js/pcoded.min.js') }}"></script>

</body>

</html>
