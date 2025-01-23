<!doctype html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @laravelPWA
    @if(\App\Models\Setting::where('key' , 'font')->pluck('value')->first() == 0)
        <link rel="stylesheet" href="/css/font-iransans.css" type="text/css"/>
    @elseif(\App\Models\Setting::where('key' , 'font')->pluck('value')->first() == 1)
        <link rel="stylesheet" href="/css/font-vazir.css" type="text/css"/>
    @else
        <link rel="stylesheet" href="/css/font-sahel.css" type="text/css"/>
    @endif
    <link rel="stylesheet" href="/css/admin.css?v=7" type="text/css"/>
    @yield('links')
    @yield('links2')
    <script src="/js/jquery-3.6.1.min.js"></script>
    <script src="/js/jquery.toast.min.js"></script>
    <link rel="stylesheet" href="/css/jquery.toast.min.css"/>
    @yield('jsScript')
    @yield('jsScript2')
    @yield('mapLink')
    <title>{{env('APP_NAME')}}</title>
</head>
<body>
    @yield('map')
    @include('icons2')
    @include('admin.side.sidebar' , ['logo' => $logo,'sideColor' => $sideColor])
    @include('admin.header.header' , ['headerColor' => $headerColor])
    <div class="allPanel">
        @yield('content')
    </div>
    @yield('scripts')
    @yield('scripts2')
    @yield('scripts3')
    @yield('scripts4')
</body>
</html>
