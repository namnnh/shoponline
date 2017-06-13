<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('page-title')</title>

    {!! HTML::style("assets/admin/css/bootstrap.min.css") !!}
    {!! HTML::style("assets/admin/css/font-awesome.min.css") !!}
    {!! HTML::style("assets/admin/css/app.css") !!}
    {!! HTML::style("assets/admin/css/bootstrap-social.css") !!}

    @yield('header-scripts')
</head>
<body class="auth">

    <div class="container">

        @yield('content')

        <footer id="footer">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <p>@lang('app.copyright') © - {{ date('Y') }}</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    {!! HTML::script('assets/admin/js/jquery-2.1.4.min.js') !!}
    {!! HTML::script('assets/admin/js/bootstrap.min.js') !!}
    {!! HTML::script('vendor/jsvalidation/js/jsvalidation.js') !!}
    {!! HTML::script('assets/admin/js/as/app.js') !!}
    {!! HTML::script('assets/admin/js/as/btn.js') !!}

    @yield('scripts')
</body>
</html>
