<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta20
* @link https://tabler.io
* Copyright 2018-2023 The Tabler Authors
* Copyright 2018-2023 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Dashboard - Tabler - Premium and Open Source dashboard template with responsive and high quality UI.</title>
    <!-- CSS files -->
    <link href="{{ asset('admin/assets/css/tabler.min.css?1692870487') }}" rel="stylesheet" />
    <link href="{{ asset('admin/assets/css/tabler-flags.min.css?1692870487') }}" rel="stylesheet" />
    <link href="{{ asset('admin/assets/css/tabler-payments.min.css?1692870487') }}" rel="stylesheet" />
    <link href="{{ asset('admin/assets/css/tabler-vendors.min.css?1692870487') }}" rel="stylesheet" />
    <link href="{{ asset('admin/assets/css/demo.min.css?1692870487') }}" rel="stylesheet" />
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
    </style>
</head>

<body>
    <script src="{{ asset('admin/assets/js/demo-theme.min.js?1692870487') }}"></script>
    <div class="page">
        @include('admin.layouts.sidebar')
        <div class="page-wrapper">
            <!-- Page header -->
            @include('admin.layouts.header')
            <!-- Page body -->
            <div class="page-body">
                <div class="container-xl">
               @yield('admin.layouts.content')
                </div>
            </div>
            @include('admin.layouts.footer')
        </div>
    </div>
    @include('admin.layouts.javascript')
</body>

</html>
