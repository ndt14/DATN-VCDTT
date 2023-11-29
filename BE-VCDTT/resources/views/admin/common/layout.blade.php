<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="{{ asset('ckeditor-5/ckeditor.js') }}"></script>
    <script src="{{ asset('ckfinder/ckfinder.js') }}"></script>
    <title>@yield('meta_title') - VCDTT quản trị</title>

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
    @yield('select2_css')
</head>

<body class="layout-fluid">
    <script src="{{ asset('admin/assets/js/demo-theme.min.js') }}"></script>
    <div class="page">
        @include('admin.common.header')
        @include('admin.common.sidebar')
        <div class="page-wrapper">
            @yield('content')
        </div>
    </div>
    @include('admin.common.javascript')
    @yield('page_js')
    @yield('select2_js')
    @yield('ckeditor_5')
</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
</html>
