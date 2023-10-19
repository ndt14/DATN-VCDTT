<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>@yield('meta_title')</title>

    @yield('meta_tags')


    @include('admin.common.css')
    @yield('header_js')
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }
    </style>
    @yield('page_css')

</head>

<body class="layout-fluid">
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
