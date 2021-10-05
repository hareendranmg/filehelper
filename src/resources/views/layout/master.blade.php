<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>File Helper Dashboard</title>
    <link rel="icon" href="{{URL::asset('favicon.ico')}}" type="image/x-icon">
    <meta name="description" content="" />
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script type="text/javascript">
    const APP_URL = "{{ URL::to('/file_helper_dashboard') }}";
    </script>
    @include('keltron::layout.style')
    @stack('commonstyle')
    @stack('pagestyle')
</head>

<body class="control-sidebar-slide-open  layout-fixed sidebar-mini " style="height: auto;">
    <div class="wrapper">

        @include('keltron::layout.header')
        @include('keltron::layout.sidebar')

        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h4>File Helper Dashboard</h1>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>

        @include('keltron::layout.footer')

        @include('keltron::layout.script')
        @stack('commonjs')
        @stack('utiljs')
        @stack('pagescript')
</body>

</html>