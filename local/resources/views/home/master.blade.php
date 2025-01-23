<!doctype html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {!! SEO::generate() !!}
    @laravelPWA
    @if(\App\Models\Setting::where('key' , 'font')->pluck('value')->first() == 0)
        <link rel="stylesheet" href="/css/font-iransans.css" type="text/css"/>
    @elseif(\App\Models\Setting::where('key' , 'font')->pluck('value')->first() == 1)
        <link rel="stylesheet" href="/css/font-vazir.css" type="text/css"/>
    @else
        <link rel="stylesheet" href="/css/font-sahel.css" type="text/css"/>
    @endif
    <link rel="stylesheet" href="/css/home.css?v=7" type="text/css"/>
    @yield('linkPage')
    {!! \App\Models\Setting::where('key' , 'headScript')->pluck('value')->first() !!}
    @yield('mapLink')
</head>
    <body>
        <script  src="/js/jquery-3.6.1.min.js"></script>
        <script src="/js/lazyload.min.js"></script>
        @yield('map')
        @include('icons')
        @if(\App\Models\Setting::where('key' , 'headerDesign')->value('value') == 2)
            @include('home.header.header2')
        @else
            @include('home.header.header')
        @endif
        @yield('content')
        @include('home.bottomNavs')
        @if(\App\Models\Setting::where('key' , 'footerDesign')->value('value') == 2)
            @include('home.footer.index2')
        @else
            @include('home.footer.index')
        @endif
        @yield('scriptPage')
        {!! \App\Models\Setting::where('key' , 'bodyScript')->pluck('value')->first() !!}
    </body>
</html>

<script>
    $(document).ready(function (){
        var greenColor = {!! json_encode(\App\Models\Setting::where('key' , 'greenColorLight')->pluck('value')->first(), JSON_HEX_TAG) !!};
        var backColor1 = {!! json_encode(\App\Models\Setting::where('key' , 'backColorLight1')->pluck('value')->first(), JSON_HEX_TAG) !!};
        var redColorLight = {!! json_encode(\App\Models\Setting::where('key' , 'redColorLight')->pluck('value')->first(), JSON_HEX_TAG) !!};
        document.documentElement.style.setProperty('--green-color', greenColor);
        document.documentElement.style.setProperty('--back4-color', backColor1);
        document.documentElement.style.setProperty('--red-color', redColorLight);
        $("img.lazyload").lazyload();

        var form = {
            "_token": "{{ csrf_token() }}",
        };
        $.ajax({
            url: "/get-cart",
            type: "post",
            data: form,
            success: function (data) {
                $('.link #cartCount').text(parseInt(data[3]));
            },
        });
    })
</script>
