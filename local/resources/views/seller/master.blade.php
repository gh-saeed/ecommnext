<!doctype html>
<html lang="en">
<head>
    @laravelPWA
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/css/seller.css?v=7"/>
    @yield('links')
    @yield('links2')
    <script src="/js/jquery-3.6.1.min.js"></script>
    <script src="/js/jquery.toast.min.js"></script>
    <link rel="stylesheet" href="/css/jquery.toast.min.css"/>
    @yield('jsScript')
    @yield('jsScript2')
    <title>{{env('APP_NAME')}}</title>
</head>
<body>
    @include('icons2')
    @include('seller.side.sidebar' , ['logo' => $logo])
    @include('seller.header.header')
    <div class="allPanel">
        @yield('content')
    </div>
    @yield('scripts')
    @yield('scripts2')
    @yield('scripts3')
    @yield('scripts4')
</body>
</html>
