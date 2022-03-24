<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>File Helper Dashboard | Login</title>
    <link rel="icon" href="{{URL::asset('favicon.ico')}}" type="image/x-icon">
    <meta name="description" content="" />
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if(session()->get('filehelper_user'))
        <script>
            window.location = '{{url("/files/file_helper_dashboard")}}'
        </script>
    @endif

    @include('keltron::layout.style')
    @stack('commonstyle')
    @stack('pagestyle')
</head>

<body class="hold-transition login-page">

    @if($errors->any())
    @foreach ($errors->all() as $error)
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        {{ $error }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endforeach
    @endif

    <div class="login-box">

        <div class="card">
            <div class="card-body login-card-body">
                <div class="login-logo">
                    <a href=" {{ url('files/file_helper_login') }}">FileHelper</a>
                </div>
                <p class="login-box-msg">Sign in to view the files</p>
                <form action="{{ url('files/file_helper_login') }}" method="POST">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="username" placeholder="Username" value="{{old('username')}}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password" placeholder="Password" value="{{old('password')}}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>

    @include('keltron::layout.script')
    @stack('commonjs')

</body>

</html>