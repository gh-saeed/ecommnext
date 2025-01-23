<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="/js/jquery-3.6.1.min.js"></script>
    @if(\App\Models\Setting::where('key' , 'font')->pluck('value')->first() == 0)
        <link rel="stylesheet" href="/css/font-iransans.css" type="text/css"/>
    @elseif(\App\Models\Setting::where('key' , 'font')->pluck('value')->first() == 1)
        <link rel="stylesheet" href="/css/font-vazir.css" type="text/css"/>
    @else
        <link rel="stylesheet" href="/css/font-sahel.css" type="text/css"/>
    @endif
    <link rel="stylesheet" href="/css/home.css" type="text/css"/>
    <title>فاکتور</title>
</head>
<body>
<div class="allInvoicePay">
    <div class="allTitle" style="display: grid;grid-template-columns: auto 1fr auto;grid-gap: 1rem;align-items: center">
        <div class="right" style="font-size: 1.3rem;font-weight: 500;">صورتحساب فروش</div>
        <div class="center" style="height: 5px;background: #eee"></div>
        <div class="left">
            <div class="leftTop" style="display:grid;grid-template-columns: auto auto;grid-gap: .5rem;justify-content: center;align-items: center;font-size: .8rem;font-weight: 300;color:#000;">
                {{$title }}
                <img style="height: 3rem;width: 3rem;object-fit: contain" src="{{$logo}}" alt="{{$title}}">
            </div>
            <h4 style="text-align: center;font-size: .9rem;font-weight: 300;margin: .5rem 0;">{{ $pays->property }}</h4>
            <h5 style="text-align: center;font-size: .7rem;font-weight: 300;color: #777">{{ $pays->created_at }}</h5>
        </div>
    </div>
    <button class="print-button">پرینت</button>
    <div class="page">
        <h1 style="text-align: center;">
            صورت حساب الکترونیکی
            فروش
        </h1>
        <table class="header-table" style="width: 100%">
            <tr>
                <td style="width: 1.8cm; height: 2.5cm;vertical-align: center; padding: 0 0 4px">
                    <div class="header-item-wrapper">
                        <div style="display: grid;justify-content: center;align-items: center;width: 100%;">خریدار</div>
                    </div>
                </td>
                <td style="height: 2.5cm;vertical-align: center; padding: 0 4px 4px" colspan="2">
                    <div class="bordered header-item-data">
                        <table class="centered" style="height: 100%">
                            <tr>
                                @if(count($pays->address) >= 1)
                                    <td>
                                        <span class="label">خریدار:</span> {{$pays->address[0]->name}}
                                    </td>
                                    <td style="width: 6.7cm">
                                        <span class="label">شماره تماس :</span>
                                        <span>{{$pays->address[0]->number}}</span>
                                    </td>
                                    <td colspan="2">
                                        <span class="label">کد پستی:</span> {{$pays->address[0]->post}}
                                    </td>
                                @else
                                    <td>
                                        <span class="label">خریدار:</span> {{$pays->user->name}}
                                    </td>
                                    <td style="width: 6.7cm">
                                        <span class="label">شماره تماس:</span>
                                        <span>{{$pays->user->number}}</span>
                                    </td>
                                @endif
                            </tr>
                            @if(count($pays->address) >= 1)
                                <tr>
                                    <td colspan="4">
                                        <span class="label">نشانی:</span>
                                        {{$pays->address[0]->state}}
                                        - {{$pays->address[0]->city}}
                                        - {{$pays->address[0]->address}}
                                        - {{$pays->address[0]->plaque}}
                                        @if($pays->address[0]->unit)
                                            - {{$pays->address[0]->unit}}
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </td>
            </tr>
        </table>
        <table class="content-table">
            <thead>
            <tr>
                <th style="width: 1cm">ردیف</th>
                <th colspan="5" style="width: 30%">شرح کالا یا خدمت</th>
                <th style="width: 2cm">غرفه دار</th>
                <th style="width: 1cm">تعداد</th>
                <th style="width: 2.3cm">حامل</th>
                <th style="width: 2.3cm">هزینه ارسال (تومان)</th>
                <th style="width: 2.3cm">مبلغ واحد (تومان)</th>
                <th style="width: 2.3cm">مقدار تخفیف (درصد)</th>
                <th style="width: 2.5cm"> جمع کل پس از تخفیف و مالیات و عوارض (تومان)</th>
            </tr>
            </thead>
            @foreach($pays->myPayMeta()->where('cancel',0)->get() as $item)
                <tr>
                    <td style="width: 1cm">{{ $loop->iteration + 1 }}</td>
                    <td style="width: 30%" colspan="5">
                        @if($item->product)
                            <div class="title">
                                {{$item->product->title}}
                                @if($item->color)
                                    <span>| {{$item->color}}</span>
                                @endif
                                @if($item->size)
                                    <span>| {{$item->size}}</span>
                                @endif
                                @if($item->guarantee_name)
                                    <span>| {{$item->guarantee_name}}</span>
                                @endif
                            </div>
                            <div class="serials">{{ $item->product->product_id }}</div>
                        @endif
                    </td>
                    <td style="width: 2cm">
                        @if($item->product)
                            @if($item->product->user)
                                {{$item->product->user->name}}
                           @endif
                        @endif
                    </td>
                    <td style="width: 1cm"><span class="ltr">{{ $item->count }}</span></td>
                    <td><span class="ltr">{{ $item->carrier_name }}</span></td>
                    <td><span class="ltr">{{ number_format($item->carrier_price) }}</span></td>
                    <td><span class="ltr">{{ number_format(($item->price)/$item->count) }}</span></td>
                    <td><span class="ltr">{{ $item->discount_off??'-' }}</span></td>
                    <td><span class="ltr">{{ number_format($item->price+$item->carrier_price) }}</span></td>

                </tr>
            @endforeach
            <tfoot>
            <tr>
                <td colspan="7">
                <td class="font-small" colspan="4">جمع کل پس از کسر تخفیف با احتساب مالیات و عوارض (تومان):</td>
                <td class="font-small" colspan="1">%</td>

                <td><span class="ltr">
                                    {{ number_format($pays->myPayMeta()->where('cancel', 0)->sum(DB::raw('price + carrier_price'))) }}
                                </span></td>
            </tr>
            <tr style="background: #fff">
                <td colspan="13" style="height: 2.5cm;vertical-align: top">
                    <div class="flex">
                        <div class="flex-grow">روش‌های پرداخت:</div>

                        <div class="flex-grow" style="width: 1.8cm"></div>
                    </div>
                    <div class="flex">
                        <div class="flex-grow">اعتباری : {{ number_format($pays->myPayMeta()->where('cancel', 0)->sum(DB::raw('price + carrier_price'))) }}</div>
                        <div class="flex-grow"></div>
                    </div>
                </td>
            </tr>
            </tfoot>
        </table>
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
        max-width: 29.7cm;
        -webkit-print-color-adjust: exact;
    }

    body {
        padding: 0.5cm
    }

    * {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }

    table {
        width: 100%;
        table-layout: fixed;
        border-spacing: 0;
    }

    .header-table {
        table-layout: fixed;
        border-spacing: 0;
    }

    .header-table td {
        padding: 0;
        vertical-align: top;
    }

    body {
        font-weight: 300;
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
        font-weight: 500;
        background-color: #0fabc6;
        color: #fff;
        border: 1px solid #0fabc6;
    }

    .page {
        background: white;
        page-break-after: always;
    }

    .flex {
        display: flex;
    }

    .flex > * {
        float: left;
    }

    .flex-grow {
        flex-grow: 10000000;
    }

    .barcode {
        text-align: center;
        margin: 12px 0 0 0;
        height: 30px;
    }

    .barcode span {
        font-size: 35pt;
    }

    .portait {
        transform: rotate(-90deg) translate(0, 40%);
        text-align: center;
    }

    .header-item-wrapper {
        border: 1px solid #000;
        width: 100%;
        height: 100%;
        background: #eee;
        display: flex;
        align-content: center;
    }

    thead, tfoot {
        background: #eee;
    }

    .header-item-data {
        height: 100%;
        width: 100%;
    }

    .bordered {
        border: 1px solid #000;
        padding: 0.12cm;
    }

    .header-table table {
        width: 100%;
        vertical-align: middle;
    }

    .content-table {
        border-collapse: collapse;
    }

    .content-table td, th {
        border: 1px solid #000;
        text-align: center;
        padding: 0.1cm;
        font-weight: 300;
    }

    table.centered td {
        vertical-align: middle;
    }

    .serials {
        direction: ltr;
        text-align: left;
    }

    .title {
        text-align: right;
    }

    .grow {
        width: 100%;
        height: 100%;
    }

    .font-small {
        font-size: 8pt;
    }

    .font-medium {
        font-size: 10pt;
    }

    .font-big {
        font-size: 15pt;
    }

    .label {
        font-weight: bold;
        padding: 0 0 0 2px;
    }

    @page {
        size: A4 landscape;
        margin: 0;
        margin-bottom: 0.5cm;
        margin-top: 0.5cm;
    }

    .ltr {
        direction: ltr;
        display: block;
    }

    @media print {
        .print-button {
            display: none;
            visibility: hidden;
        }
    }
</style>
