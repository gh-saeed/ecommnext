<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="/js/jquery-3.6.1.min.js"></script>
    <link rel="stylesheet" href="/css/admin.css"/>
    <title>فاکتور</title>
</head>
<body>
    <div class="allInvoicePay">
        <button class="print-button">پرینت</button>
        <div class="pages">
            @foreach($pays as $pay)
            <div class="page">
                <div class="top">
                    <div class="right">
                        <div class="item">
                            <h4>گیرنده :</h4>
                            <div class="text">
                                <h5>{{$pay->address()->pluck('name')->first()}}</h5>
                            </div>
                        </div>
                        <div class="item">
                            <h4>آدرس :</h4>
                            <div class="text">
                                <h5>
                                    {{$pay->address()->pluck('state')->first()}}
                                    -
                                    {{$pay->address()->pluck('city')->first()}}
                                    -
                                    {{$pay->address()->pluck('address')->first()}}
                                    پلاک :
                                    {{$pay->address()->pluck('plaque')->first()}}
                                    واحد :
                                    {{$pay->address()->pluck('unit')->first()}}
                                </h5>
                            </div>
                        </div>
                        <div class="item">
                            <h4>کد پستی :</h4>
                            <div class="text">
                                <h5>{{$pay->address()->pluck('post')->first()}}</h5>
                            </div>
                        </div>
                        <div class="item">
                            <h4>شماره تماس :</h4>
                            <div class="text">
                                <h5>{{$pay->address()->pluck('number')->first()}}</h5>
                            </div>
                        </div>
                        <div class="item">
                            <h4>تاریخ سفارش :</h4>
                            <div class="text">
                                <h5>{{$pay->created_at}}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="left">
                        <div class="logo">
                            <img src="{{\App\Models\Setting::where('key' , 'logo')->pluck('value')->first()}}"
                                 alt="{{\App\Models\Setting::where('key' , 'name')->pluck('value')->first()}}">
                        </div>
                        <div class="item">
                            <h4>فرستنده :</h4>
                            <div class="text">
                                <h5>{{\App\Models\Setting::where('key' , 'name')->pluck('value')->first()}}</h5>
                            </div>
                        </div>
                        <div class="item">
                            <h4>آدرس :</h4>
                            <div class="text">
                                <h5>{{\App\Models\Setting::where('key' , 'address')->pluck('value')->first()}}</h5>
                            </div>
                        </div>
                        <div class="item">
                            <h4>آدرس سایت :</h4>
                            <div class="text">
                                <h5>{{url('')}}</h5>
                            </div>
                        </div>
                        <div class="item">
                            <h4>شماره تماس :</h4>
                            <div class="text">
                                <h5>{{\App\Models\Setting::where('key' , 'number')->pluck('value')->first()}}</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bottom">
                    شماره سفارش :
                    <span>{{$pay->property}}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</body>
</html>
<script>
    $(document).ready(function(){
        $('.print-button').click(function() {
            window.print();
        });
    })
</script>

<style>
    html, body {
        padding: 0;
        margin: 0 auto;
        font-family: 'irsans', irsans, sans-serif;
        -webkit-print-color-adjust: exact;
    }

    body {
        padding: 0.5cm
    }

    * {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }

    body {
        direction: rtl;
    }

    .print-button {
        cursor: pointer;
        -webkit-box-shadow: none;
        box-shadow: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        display: -webkit-inline-box;
        display: -ms-inline-flexbox;
        display: inline-flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        border-radius: 5px;
        background: none;
        -webkit-transition: all .3s ease-in-out;
        transition: all .3s ease-in-out;
        position: relative;

        outline: none;
        text-align: center;

        padding: 8px 16px;
        font-size: 12px;
        font-size: .857rem;
        line-height: 1.833;
        font-weight: 700;
        background-color: #0fabc6;
        color: #fff;
        border: 2px solid #0fabc6;
    }

    .pages{
        display: flex;
        flex-wrap: wrap;
        gap: .5rem;
        margin-top: 1rem;
    }
    .page {
        page-break-after: always;
        border: 2px solid #555;
        background: white;
        overflow: hidden;
        width: calc(50% - 1rem);
    }
    .page .top {
        display: grid;
        grid-template-columns: 1fr 1fr;
        grid-gap: 1rem;
    }
    .page .top .right{
        display: grid;
        align-items: center;
        align-content: center;
    }
    .page .top .left{
        border-right: 2px solid #555;
    }
    .page .top .left .logo{
        padding: 1rem;
        display: grid;
        justify-content: center;
        border-bottom: 2px solid #555;
    }
    .page .top .left .logo img{
        object-fit: contain;
        height: 4rem;
    }
    .page .bottom {
        padding: 1rem;
        border-top: 2px solid #555;
        text-align: center;
        font-size: .9rem;
        font-weight: 500;
    }
    .page .bottom span{
        font-weight: 300;
    }
    .page .item {
        display: grid;
        grid-template-columns: auto 1fr;
        justify-content: right;
        align-items: center;
        grid-gap: .5rem;
        padding: .5rem;
    }
    .page .items {
        display: grid;
        grid-template-columns: repeat(2,1fr);
        grid-gap: 2rem;
    }
    .page .item h4,h5{
        font-size: .8rem;
        font-weight: 700;
        color: #000;
        position: relative;
    }
    h5{
        color: #444;
    }
    @page {
        size: A4 landscape;
        margin: 0;
        margin-bottom: 0.5cm;
        margin-top: 0.5cm;
    }

    @media print {
        .print-button {
            display: none;
            visibility: hidden;
        }
    }
</style>
