@extends('seller.master')

@section('tab' , 9)
@section('content')
    <div class="allCheckoutIndex">
        <div class="chargeWidgets">
            <div class="WidgetItem">
                <div class="WidgetIcon">
                    <svg class="icon">
                        <use xlink:href="#successPay"></use>
                    </svg>
                </div>
                <div class="WidgetSubject">
                    <h4>مبلغ قابل تسویه</h4>
                    <h5>{{number_format(auth()->user()->myCheckout())}} تومان</h5>
                </div>
            </div>
            <div class="WidgetItem">
                <div class="WidgetIcon">
                    <svg class="icon">
                        <use xlink:href="#failPay"></use>
                    </svg>
                </div>
                <div class="WidgetSubject">
                    <h4>مبلغ بلوکه شده</h4>
                    <h5>{{number_format($blockMoney)}} تومان </h5>
                </div>
            </div>
            <div class="WidgetItem">
                <div class="WidgetIcon">
                    <svg class="icon">
                        <use xlink:href="#successPay"></use>
                    </svg>
                </div>
                <div class="WidgetSubject">
                    <h4>مبلغ تسویه شده</h4>
                    <h5>{{number_format($done)}} تومان</h5>
                </div>
            </div>
            <div class="WidgetItem">
                <div class="WidgetIcon">
                    <svg class="icon">
                        <use xlink:href="#failPay"></use>
                    </svg>
                </div>
                <div class="WidgetSubject">
                    <h4>تعداد سفارش بلوکه شده</h4>
                    <h5>{{number_format($blockPay)}} تومان </h5>
                </div>
            </div>
        </div>
        <div class="allChargeIndex" style="margin-bottom: 1rem">
            @if (\Session::has('success'))
                <div class="success">
                    {!! \Session::get('success') !!}
                </div>
            @endif
            @if (\Session::has('error'))
                <div class="error">
                    {!! \Session::get('error') !!}
                </div>
            @endif
            @if(\App\Models\Checkout::where('user_id',auth()->id())->where('type',0)->where('status',0)->first())
                <div class="error">یک درخواست در حال بررسی وجود داره</div>
            @else
                <div class="chargePrice">
                    <form action="/seller/checkout" method="post">
                        @csrf
                        <div class="chargeField">
                            <div class="top">
                                <label class="right1" for="price">مبلغ دلخواه (تومان)</label>
                                <input id="price" onkeypress="return /[0-9-.]/i.test(event.key)" class="number1" type="text" placeholder="10000" min="0" max="{{auth()->user()->myCheckout()}}" name="price">
                                @error('price')
                                <div class="alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="top" style="padding-top: 1rem;">
                                <label class="right1" for="card">شماره کارت</label>
                                <input id="card" onkeypress="return /[0-9-.]/i.test(event.key)" type="text" placeholder="شماره کارت" min="0" max="16" name="card">
                                @error('card')
                                <div class="alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="top" style="padding-top: 1rem;">
                                <label class="right1" for="shaba">شماره شبا</label>
                                <input id="shaba" onkeypress="return /[0-9-.]/i.test(event.key)" type="text" placeholder="بدون IR" min="0" max="24" name="shaba">
                                @error('shaba')
                                <div class="alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="top" style="padding-top: 1rem;">
                                <label class="right1" for="name">نام کامل صاحب کارت</label>
                                <input id="name" style="text-align: right" type="text" placeholder="نام کامل" name="name">
                                @error('name')
                                <div class="alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="finalPrice">
                                <div class="price">0 تومان</div>
                                <button>ثبت درخواست</button>
                            </div>
                        </div>
                        <div class="bot"></div>
                    </form>
                </div>
            @endif
        </div>
        <div class="table">
            <div class="filters">
                <form method="GET" action="/profile/checkout" class="right">
                    <div class="title1">فیلتر ها :</div>
                    <div class="filter">
                        <input type="text" name="title" value="{{$title}}" placeholder="مبلغ را وارد کنید">
                    </div>
                    <div class="filter">
                        <select name="status">
                            <option value="" selected>وضعیت</option>
                            <option value="1">تایید شده</option>
                            <option value="2">رد شده</option>
                        </select>
                    </div>
                    <button>اعمال فیلتر</button>
                </form>
            </div>
            <div class="table1">
                <table>
                    <tr>
                        <th>شماره درخواست</th>
                        <th>مبلغ</th>
                        <th>نام صاحب کارت</th>
                        <th>وضعیت پرداخت</th>
                        <th>زمان ثبت</th>
                    </tr>
                    @foreach($checkouts as $item)
                        <tr>
                            <td>
                                <span>{{$item->property}}</span>
                            </td>
                            <td>
                                <span>{{number_format($item->price)}} تومان </span>
                            </td>
                            <td>
                                <span>{{$item->name}}</span>
                            </td>
                            <td>
                                @if($item->status == 0)
                                    <span class="unActive">در حال بررسی</span>
                                @elseif($item->status == 1)
                                    <span class="active">تایید شده</span>
                                @else
                                    <span class="unActive">رد شده</span>
                                @endif
                            </td>
                            <td>
                                <span>{{$item->created_at}}</span>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            {{ $checkouts->links('admin.paginate') }}
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).mouseup(function(e)
        {
            var container = $("table tr .buttons");
            if (!container.is(e.target) && container.has(e.target).length == 0)
            {
                $('table tr .buttons .items').hide();
            }
        });
        $(document).ready(function(){
            var status = {!! json_encode($status, JSON_HEX_TAG) !!};
            $(".allTopTableItem select[name='status']").val(status);
            $("form input[name='price']").val('');
            $(".number1").keydown(function () {
                if ($(this).val() <= parseInt($(this).attr('max'))){
                    $(this).attr("old", $(this).val());
                }
            });
            $(".number1").keyup(function () {
                if (parseInt($(this).val()) <= parseInt($(this).attr('max')))
                    $(".chargeField .price").text(makePrice($(this).val()) + ' تومان');
                else{
                    $(this).val($(this).attr("old"));
                    $(".chargeField .price").text(makePrice($(this).attr("old")) + ' تومان');
                }
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
