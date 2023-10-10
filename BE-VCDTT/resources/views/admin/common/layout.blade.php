<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>@yield('meta_title')</title>

    @yield('meta_tags')


    <!-- CSS files -->
    <link href="{{ asset('admin/assets/css/tabler.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/assets/css/tabler-flags.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/assets/css/tabler-payments.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/assets/css/tabler-vendors.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/assets/css/demo.min.css') }}" rel="stylesheet" />
    @yield('header_js')
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }
    </style>
    @yield('page_css')

</head>

<body>
    <script src="{{ asset('admin/assets/js/demo-theme.min.js') }}"></script>
    <div class="page">
        @include('admin.common.sidebar')
        <div class="page-wrapper">
            @include('admin.common.header')
            @yield('content')
            @include('admin.common.footer')
        </div>
    </div>
    @include('admin.common.javascript')
    @yield('page_js')
</body>

</html>
