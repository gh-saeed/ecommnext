@extends('home.master')

@section('title' , __('messages.dashboard'))
@section('content')
    <div class="allProfileIndex width">
        @include('home.profile.list' , ['tab' => 20])
        <div class="allCheckoutIndex">
            <div class="allChargeIndex">
                <div class="chargePrice">
                    <form action="/charge/shop" method="get">
                        @csrf
                        <input type="hidden" name="gateway" value="{{\App\Models\Setting::where('key' , 'choicePay')->pluck('value')->first()}}">
                        <div class="chargeField">
                            <div class="suggest">
                                <div class="title1">مبالغ پیشنهادی</div>
                                <div class="boxes">
                                    <div class="box" data-num="10000">10,000 تومان</div>
                                    <div class="box" data-num="100000">100,000 تومان</div>
                                    <div class="box" data-num="1000000">1,000,000 تومان</div>
                                    <div class="box" data-num="10000000">10,000,000 تومان</div>
                                </div>
                            </div>
                            <div class="top">
                                <label class="right1" for="price">مبلغ افزایش موجودی (تومان)</label>
                                <input id="price" onkeypress="return /[0-9-.]/i.test(event.key)" class="number1" type="text" placeholder="10000" min="{{\App\Models\Setting::where('key' , 'minCharge')->pluck('value')->first()}}" name="price">
                                <p>حداقل میزان شارژ حساب {{number_format(\App\Models\Setting::where('key' , 'minCharge')->pluck('value')->first())}} تومان است.</p>
                            </div>
                            <div class="finalPrice">
                                <div class="title2">مبلغ قابل پرداخت :</div>
                                <div class="price">0 تومان</div>
                            </div>
                        </div>
                        <div class="bot">
                            <div class="gateItems">
                                @if(\App\Models\Setting::where('key' , 'statusSadad')->pluck('value')->first())
                                    <label class="gateItem" id="5">
                                        <img src="/img/sadad.png" alt="method">
                                    </label>
                                @endif
                                @if(\App\Models\Setting::where('key' , 'statusBeh')->pluck('value')->first())
                                    <label class="gateItem" id="4">
                                        <img src="/img/behpardakht.png" alt="method">
                                    </label>
                                @endif
                                @if(\App\Models\Setting::where('key' , 'idpayStatus')->pluck('value')->first())
                                    <label class="gateItem" id="3">
                                        <img src="/img/idpay.png" alt="method">
                                    </label>
                                @endif
                                @if(\App\Models\Setting::where('key' , 'nextpayStatus')->pluck('value')->first())
                                    <label class="gateItem" id="2">
                                        <img src="/img/nextpay.png" alt="method">
                                    </label>
                                @endif
                                @if(\App\Models\Setting::where('key' , 'zarinpalStatus')->pluck('value')->first())
                                    <label class="gateItem active" id="0">
                                        <img src="/img/zarinpal.svg" alt="method">
                                    </label>
                                @endif
                                @if(\App\Models\Setting::where('key' , 'zibalStatus')->pluck('value')->first())
                                    <label class="gateItem" id="1">
                                        <img src="/img/zibal.png" alt="method">
                                    </label>
                                @endif
                                @if(\App\Models\Setting::where('key' , 'statusAsan')->pluck('value')->first())
                                    <label class="gateItem" id="6">
                                        <img src="/img/asanPardakht.jpg" alt="method">
                                    </label>
                                @endif
                                @if(\App\Models\Setting::where('key' , 'statusPasargad')->pluck('value')->first())
                                    <label class="gateItem" id="7">
                                        <img src="/img/pasargad.png" alt="method">
                                    </label>
                                @endif
                                @if(\App\Models\Setting::where('key' , 'statusSaman')->pluck('value')->first())
                                    <label class="gateItem" id="8">
                                        <img src="/img/saman.jpg" alt="method">
                                    </label>
                                @endif
                            </div>
                            <button>افزایش حساب</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="table">
                <div class="table1">
                    <table>
                        <tr>
                            <th>{{__('messages.order_property')}}</th>
                            <th>{{__('messages.price1')}}</th>
                            <th>{{__('messages.charge_type')}}</th>
                            <th>{{__('messages.order_status')}}</th>
                            <th>{{__('messages.order_created')}}</th>
                        </tr>
                        @foreach($wallets as $item)
                            <tr>
                                <td>
                                    <span>{{$item->property}}</span>
                                </td>
                                <td>
                                    <span>{{number_format($item->price)}} {{__('messages.arz')}} </span>
                                </td>
                                <td>
                                    @if($item->type == 0)
                                        <span class="active">{{__('messages.increase_charge')}}</span>
                                    @else
                                        <span class="unActive">{{__('messages.decrease_charge')}}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($item->status == 0)
                                        <span class="unActive">{{__('messages.order_status6')}}</span>
                                    @else
                                        <span class="active">{{__('messages.order_status2')}}</span>
                                    @endif
                                </td>
                                <td>
                                    <span>{{$item->created_at}}</span>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                {{ $wallets->links('admin.paginate') }}
            </div>
        </div>
    </div>
@endsection

@section('scriptPage')
    <script>
        $(document).ready(function(){
            $("form input[name='price']").val('');
            $('.boxes .box').on('click' , function(){
                $("form input[name='price']").val($(this).attr('data-num'));
                $(".chargeField .price").text(makePrice($("form input[name='price']").val()) + ' تومان');
            })
            $("form input[name='price']").on('keyup' , function(){
                $(".chargeField .price").text(makePrice($(this).val()) + ' تومان');
            })
            $('.gateItems .gateItem').on('click' , function(){
                $.each($('.gateItems .gateItem'),function(){
                    $(this).attr('class' , 'gateItem');
                })
                $(this).attr('class','gateItem active');
                $("form input[name='gateway']").val($(this).attr('id'));
            });
            function makePrice(price){
                price += '';
                x = price.split('.');
                x1 = x[0];
                x2 = x.length > 1 ? '.' + x[1] : '';
                var rgx = /(\d+)(\d{3})/;
                while (rgx.test(x1)) {
                    x1 = x1.replace(rgx, '$1' + ',' + '$2');
                }
                return x1 + x2;
            }
        })
    </script>
@endsection
