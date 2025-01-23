@extends('seller.master')

@section('tab' , 3)
@section('content')
    <div class="allShowPay">
        <div class="topShowPay">
            <div class="title">
                <h1>جزئیات سفارش</h1>
                <span>{{$pays->created_at}}</span>
                <a href="/seller/pay/invoice/{{$pays->property}}" target="_blank">
                    <svg class="icon">
                        <use xlink:href="#pay"></use>
                    </svg>
                    دریافت فاکتور
                </a>
                <a href="/seller/pay/group?pay={{$pays->property}}" target="_blank">
                    <svg class="icon">
                        <use xlink:href="#pay"></use>
                    </svg>
                    چاپ لیبل
                </a>
            </div>
            <div class="detail">
                <div class="topDetail">
                    <div class="items">
                        @if(count($pays->address) >= 1)
                            <div class="item">
                                <h5>نام گیرنده :</h5>
                                <div>{{$pays->address[0]->name}}</div>
                            </div>
                            <div class="item">
                                <h5>شماره تماس :</h5>
                                <div>{{$pays->address[0]->number}}</div>
                            </div>
                            <div class="item">
                                <h5>کد پستی :</h5>
                                <div>{{$pays->address[0]->post}}</div>
                            </div>
                        @else
                            <div class="item">
                                <h5>نام گیرنده :</h5>
                                <div>{{$pays->user->name}}</div>
                            </div>
                            <div class="item">
                                <h5>شماره تماس :</h5>
                                <div>{{$pays->user->number}}</div>
                            </div>
                        @endif
                        <div class="item">
                            <h5>شماره سفارش :</h5>
                            <div>{{$pays->property}}</div>
                        </div>
                        <div class="item">
                            <h5>وضعیت پرداخت :</h5>
                            @if($pays->status == 100)
                                <div style="color: green">پرداخت شده</div>
                            @else
                                <div style="color: red">پرداخت نشده</div>
                            @endif
                        </div>
                    </div>
                    <div class="items">
                        <div class="item">
                            <h5>مبلغ فاکتور :</h5>
                            <div>{{ number_format($pays->price - $pays->myPayMeta()->where('cancel', 1)->sum(DB::raw('price + carrier_price'))) }} تومان</div>
                        </div>
                        <div class="item">
                            <h5>مالیات :</h5>
                            <div>%{{$pays->tax}}</div>
                        </div>
                        <div class="item">
                            <h5>نوع پرداخت :</h5>
                            <div>
                                @if($pays->method == 1)
                                    کیف پول
                                @else
                                    درگاه پرداخت
                                @endif
                            </div>
                        </div>
                    </div>
                    @if(count($pays->address) >= 1)
                        <div class="items">
                            <div class="item">
                                <h5>آدرس :</h5>
                                <div>
                                    {{$pays->address[0]->state}}
                                    - {{$pays->address[0]->city}}
                                    - {{$pays->address[0]->address}}
                                    پلاک :
                                    {{$pays->address[0]->plaque}}
                                    واحد :
                                    {{$pays->address[0]->unit}}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="allShowPayContainer">
            <div class="items">
                <div class="titleProducts">
                    <div class="title">محصولاتی که سفارش داده شده</div>
                </div>
                @foreach($pays->myPayMeta as $item)
                    <div class="item">
                        @if($item->product)
                            <a href="/product/{{$item->product->slug}}" class="cartDetailPic">
                                <img src="{{$item->product->image != '[]' ?json_decode($item->product->image)[0]:''}}" alt="{{$item->product->title}}">
                            </a>
                        @endif
                        <div class="cartDetailInfo">
                            @if($item->product)
                                <a href="/product/{{$item->product->slug}}" class="cartDetailInfoItem">
                                    <h3>
                                        {{$item->product->title}}
                                        @if($item->cancel)
                                            <span class="cancel">(لغو شده)</span>
                                        @endif
                                    </h3>
                                </a>
                            @endif
                            @if($item->color)
                                <div class="cartDetailInfoItem">
                                    <span>رنگ :</span>
                                    <span>{{$item->color}}</span>
                                </div>
                            @endif
                            @if($item->size)
                                <div class="cartDetailInfoItem">
                                    <span>سایز :</span>
                                    <span>{{$item->size}}</span>
                                </div>
                            @endif
                            @if($item->guarantee_name)
                                <div class="cartDetailInfoItem">
                                    <span>گارانتی :</span>
                                    <span>{{$item->guarantee_name}}</span>
                                </div>
                            @endif
                            <div class="cartDetailInfoItem">
                                <span>تعداد :</span>
                                <span>{{$item->count}}</span>
                            </div>
                            <div class="cartDetailInfoItem">
                                <span>زمان تحویل احتمالی :</span>
                                <span>{{$item->time}}</span>
                            </div>
                            <div class="cartDetailInfoItem">
                                <span>مبلغ محصول :</span>
                                <span>{{number_format($item->price)}} تومان</span>
                            </div>
                            <div class="cartDetailInfoItem">
                                <span>هزینه ارسال :</span>
                                <span>{{number_format($item->carrier_price)}} تومان</span>
                            </div>
                            <div class="cartDetailInfoItem">
                                <span>حامل :</span>
                                <span>{{$item->carrier_name}}</span>
                            </div>
                            @if($item->cancel == 0)
                                <div class="cartDetailInfoItem">
                                    <span>کد رهگیری :</span>
                                    <input type="text" value="{{$item->track}}" name="track" placeholder="کد رهگیری">
                                </div>
                                <div class="cartDetailInfoItem">
                                    <span>وضعیت تحویل :</span>
                                    <select name="deliver">
                                        <option value="0" {{$item->deliver == 0 ?'selected':''}}>دریافت سفارش</option>
                                        <option value="1" {{$item->deliver == 1 ?'selected':''}}>در انتظار بررسی</option>
                                        <option value="2" {{$item->deliver == 2 ?'selected':''}}>بسته بندی شده</option>
                                        <option value="3" {{$item->deliver == 3 ?'selected':''}}>تحویل پیک</option>
                                    </select>
                                </div>
                                <button id="{{$item->id}}">ثبت اطلاعات</button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('scripts3')
    <script src="/js/jquery.toast.min.js"></script>
    <link rel="stylesheet" href="/css/jquery.toast.min.css"/>
    <script>
        $(document).ready(function(){
            var pays = {!! $pays->toJson() !!};
            $(".cartDetailInfo button").click(function() {
                var deliver=$($(this)[0]['parentElement']).find("select[name='deliver']").val();
                var track=$($(this)[0]['parentElement']).find("input[name='track']").val();
                var form = {
                    "_token": "{{ csrf_token() }}",
                    deliver:deliver,
                    track:track,
                    payId:$(this).attr('id'),
                };
                $.ajax({
                    url: "/seller/pay/"+pays.property,
                    type: "put",
                    data: form,
                    success: function () {
                        $.toast({
                            text: "سفارش ویرایش شد", // Text that is to be shown in the toast
                            heading: 'موفقیت آمیز', // Optional heading to be shown on the toast
                            icon: 'success', // Type of toast icon
                            showHideTransition: 'fade', // fade, slide or plain
                            allowToastClose: true, // Boolean value true or false
                            hideAfter: 3000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                            stack: 5, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
                            position: 'bottom-left', // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values
                            textAlign: 'left',  // Text alignment i.e. left, right or center
                            loader: true,  // Whether to show loader or not. True by default
                            loaderBg: '#9EC600',  // Background color of the toast loader
                        });
                        window.location.reload();
                    },
                });
            });
        })
    </script>
@endsection
