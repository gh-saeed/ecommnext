@extends('home.master')

@section('title' , $page->title)
@section('content')
    <main class="allPageIndex width">
        <h1>{{$page->title}}</h1>
        @if($page->lat)
            <div class="pageContainer">
                <div class="description">
                    {!! $page->body !!}
                </div>
                <div id="map4"></div>
            </div>
        @else
            <div class="description">
                {!! $page->body !!}
            </div>
        @endif
    </main>
@endsection

@section('scriptPage')
    <script>
        $(document).ready(function (){
            var page = {!! json_encode($page, JSON_HEX_TAG) !!};
            var app = new Mapp({
                element: '#map4',
                presets: {
                    latlng: {
                        lat: page.lat,
                        lng: page.longitude,
                    },
                    zoom: 15,
                },
                apiKey: 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjVmMDFmMDMxOTE2MmYxMWM4YjFmNjAxZGEzZWM0ZTcyZDI1ZjMxY2ZiZDI0NjM2MzE0OGJjZWI5NzcwN2VlOTM4NjBhZmNlOTc0NTZlMjk2In0.eyJhdWQiOiIxNjMzMCIsImp0aSI6IjVmMDFmMDMxOTE2MmYxMWM4YjFmNjAxZGEzZWM0ZTcyZDI1ZjMxY2ZiZDI0NjM2MzE0OGJjZWI5NzcwN2VlOTM4NjBhZmNlOTc0NTZlMjk2IiwiaWF0IjoxNjk1MjQwOTI3LCJuYmYiOjE2OTUyNDA5MjcsImV4cCI6MTY5NzU3MzcyNywic3ViIjoiIiwic2NvcGVzIjpbImJhc2ljIl19.ggya0Flw4c5RI67geif-boTPM15vM4nIRF1fKflZbHxVHdv6TMhRQkR_cyCOnoL8M-JzsHrVloiHZqb64_laAMNqNMjjWPqcmPFo-AOEqG3v_-8k1bPfxM_6iZEsARwmdVqwByG9KEKleJ8lZR6TKuSWQtDPw_9wTP39bWAw7udKLCw_cDRo_ZOYUSqFXwypDi3YEvQNXP1YaTDvTIQbZRWMgwDEJ1d9F2oymRcWnJyTSiW_KCDeYl7kQr74pGafUAGtgGskB2Weh2MZYJzsdM-9ioX1lBHbnDCdaHY8rLzDeLPu7gFSgK6HQ2CXQlbkrY90a-f2G69GG1iqGsPHjA'
            });
            app.addLayers();
            var marker = app.addMarker({
                latlng: {
                    lat: page.lat,
                    lng: page.longitude,
                },
                zoom: 15,
                draggable: false,
                popup: false
            });
        })
    </script>
@endsection

@section('map')
    <script type="text/javascript" src="https://cdn.map.ir/web-sdk/1.4.2/js/mapp.env.js"></script>
    <script type="text/javascript" src="https://cdn.map.ir/web-sdk/1.4.2/js/mapp.min.js"></script>
@endsection
@section('mapLink')
    <link rel="stylesheet" href="https://cdn.map.ir/web-sdk/1.4.2/css/mapp.min.css">
    <link rel="stylesheet" href="https://cdn.map.ir/web-sdk/1.4.2/css/fa/style.css">
@endsection
