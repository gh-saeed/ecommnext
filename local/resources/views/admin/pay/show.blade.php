@extends('admin.master')

@section('tab' , 7)
@section('content')
    <div class="allShowPay">
        <div class="topShowPay">
            <div class="title">
                <h1>جزئیات سفارش</h1>
                <span>{{$pays->created_at}}</span>
                <a href="/admin/pay/invoice/{{$pays->id}}" target="_blank">
                    <svg class="icon">
                        <use xlink:href="#pay"></use>
                    </svg>
                    دریافت فاکتور
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
                            <h5>درگاه پرداختی :</h5>
                            @if($pays->gate == 0)
                                <div>زرینپال</div>
                            @elseif($pays->gate == 1)
                                <div>زیبال</div>
                            @elseif($pays->gate == 2)
                                <div>نکست پی</div>
                            @elseif($pays->gate == 3)
                                <div>نکست پی</div>
                            @elseif($pays->gate == 4)
                                <div>آیدی پی</div>
                            @elseif($pays->gate == 5)
                                <div>به پرداخت ملت</div>
                            @elseif($pays->gate == 6)
                                <div>سداد ملی</div>
                            @elseif($pays->gate == 7)
                                <div>آسان پرداخت</div>
                            @elseif($pays->gate == 8)
                                <div>پاسارگاد</div>
                            @endif
                        </div>
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
                            <div>{{ number_format($pays->price - $pays->payMeta()->where('cancel', 1)->sum(DB::raw('price + carrier_price'))) }} تومان</div>
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
                <div class="botDetail">
                    <div class="items">
                        <div class="item">
                            <h5>مبلغ پرداخت :</h5>
                            <input type="text" placeholder="مبلغ" name="price" value="{{$pays->price}}">
                        </div>
                        <div class="item">
                            <h5>وضعیت پرداخت :</h5>
                            <select name="status">
                                <option value="100">پرداخت شده</option>
                                <option value="0">پرداخت نشده</option>
                                <option value="1">لغو شده</option>
                                <option value="2">مرجوعی</option>
                            </select>
                        </div>
                        <button>ثبت</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="allShowPayContainer">
            <div class="topContainer">
                <div class="cashBacks">
                    <div class="cash1">
                        @if($pays->back == 1)
                            <button class="active">کش بک به کیف پول سایت</button>
                        @else
                            <button>کش بک به کیف پول سایت</button>
                        @endif
                    </div>
                    <div class="cash2">
                        @if($pays->back == 2)
                            <button class="active">کش بک به حساب دستی</button>
                        @else
                            <button>کش بک به حساب دستی</button>
                        @endif
                    </div>
                </div>
            </div>
            <div class="items">
                <div class="titleProducts">
                    <div class="title">محصولاتی که سفارش داده شده</div>
                    <button>افزودن محصول</button>
                </div>
                @foreach($pays->payMeta as $item)
                    <div class="item">
                        @if($item->product)
                            <a href="/product/{{$item->product->slug}}" class="cartDetailPic">
                                <img src="{{json_decode($item->product->image)[0]}}" alt="{{$item->product->title}}">
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
                                <div class="cartDetailInfoItem">
                                    <span>غرفه :</span>
                                    <span>{{$item->product->user->name}}</span>
                                </div>
                            @endif
                            @if($item->color)
                                <div class="cartDetailInfoItem">
                                    <span>رنگ :</span>
                                    <input type="text" value="{{$item->color}}" name="color" placeholder="رنگ">
                                </div>
                            @endif
                            @if($item->size)
                                <div class="cartDetailInfoItem">
                                    <span>سایز :</span>
                                    <input type="text" value="{{$item->size}}" name="size" placeholder="سایز">
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
                                <input type="text" value="{{$item->count}}" name="count" placeholder="تعداد">
                            </div>
                            <div class="cartDetailInfoItem">
                                <span>زمان تحویل احتمالی :</span>
                                <input type="text" value="{{$item->time}}" name="time" placeholder="زمان تحویل احتمالی">
                            </div>
                            <div class="cartDetailInfoItem">
                                <span>مبلغ محصول :</span>
                                <input type="text" value="{{$item->price}}" name="price" placeholder="مبلغ">
                            </div>
                            <div class="cartDetailInfoItem">
                                <span>هزینه ارسال :</span>
                                <input type="text" value="{{$item->carrier_price}}" name="carrier_price" placeholder="هزینه ارسال">
                            </div>
                            <div class="cartDetailInfoItem">
                                <span>حامل :</span>
                                <input type="text" value="{{$item->carrier_name}}" name="carrier_name" placeholder="حامل">
                            </div>
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
                                    <option value="4" {{$item->deliver == 4 ?'selected':''}}>تحویل مشتری</option>
                                </select>
                            </div>
                            <div class="cartDetailInfoItem">
                                <span>وضعیت انصراف :</span>
                                <select name="cancel">
                                    <option value="0" {{$item->cancel == 0 ?'selected':''}}>لغو نشده</option>
                                    <option value="1" {{$item->cancel == 1 ?'selected':''}}>لغو شده</option>
                                </select>
                            </div>
                            <div class="cartDetailInfoItem">
                                <span>وضعیت پرداخت :</span>
                                <select name="status">
                                    <option value="0" {{$item->status == 0 ?'selected':''}}>پرداخت نشده</option>
                                    <option value="100" {{$item->status == 100 ?'selected':''}}>پرداخت شده</option>
                                </select>
                            </div>
                            <div class="buttons">
                                <button class="done" id="{{$item->id}}">ثبت اطلاعات</button>
                                @if(\App\Models\Checkout::where('pay_id',$item->id)->where('status','!=',1)->first())
                                    <button class="checkout" id="{{$item->id}}">تسویه با غرفه دار</button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="addProducts" style="display:none;">
            <form method="post" action="/admin/add-pay/{{$pays->id}}" class="showProducts">
                @csrf
                <div class="item">
                    <h4>محصول</h4>
                    <select name="productM">
                        @foreach($products as $item)
                            <option value="{{$item->id}}">{{$item->title}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="item">
                    <h4>رنگ</h4>
                    <input type="text" placeholder="رنگ" name="colorM">
                </div>
                <div class="item">
                    <h4>سایز</h4>
                    <input type="text" placeholder="سایز" name="sizeM">
                </div>
                <div class="item">
                    <h4>تعداد</h4>
                    <input type="text" placeholder="تعداد" name="countM">
                </div>
                <div class="item">
                    <h4>گارانتی</h4>
                    <input type="text" placeholder="گارانتی" name="guaranteeM">
                </div>
                <div class="item">
                    <h4>مبلغ کل</h4>
                    <input type="text" placeholder="مبلغ" name="priceM">
                </div>
                <div class="buttons">
                    <button>ارسال</button>
                    <button class="btnCan">انصراف</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts3')
    <script>
        $(document).ready(function(){
            var pays = {!! $pays->toJson() !!};
            $(".item select[name='status']").val(pays.status);
            $(".botDetail button").click(function() {
                var status=$(".botDetail .item select[name='status']").val();
                var price=$(".botDetail .item input[name='price']").val();
                var form = {
                    "_token": "{{ csrf_token() }}",
                    status:status,
                    price:price,
                    update:1,
                };
                $.ajax({
                    url: "/admin/pay/"+pays.id,
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
                    },
                });
            });
            $(".cash1 button").on('click',function() {
                var form = {
                    "_token": "{{ csrf_token() }}",
                    back:1,
                    update:4,
                };
                $.ajax({
                    url: "/admin/pay/"+pays.id,
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
            $(".cash2 button").on('click',function() {
                var form = {
                    "_token": "{{ csrf_token() }}",
                    back:2,
                    update:4,
                };
                $.ajax({
                    url: "/admin/pay/"+pays.id,
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
            $(".cartDetailInfo .done").click(function() {
                var count=$($(this)[0]['parentElement']['parentElement']).find("input[name='count']").val();
                var time=$($(this)[0]['parentElement']['parentElement']).find("input[name='time']").val();
                var price=$($(this)[0]['parentElement']['parentElement']).find("input[name='price']").val();
                var carrier_price=$($(this)[0]['parentElement']['parentElement']).find("input[name='carrier_price']").val();
                var carrier_name=$($(this)[0]['parentElement']['parentElement']).find("input[name='carrier_name']").val();
                var track=$($(this)[0]['parentElement']['parentElement']).find("input[name='track']").val();
                var deliver=$($(this)[0]['parentElement']['parentElement']).find("select[name='deliver']").val();
                var cancel=$($(this)[0]['parentElement']['parentElement']).find("select[name='cancel']").val();
                var status=$($(this)[0]['parentElement']['parentElement']).find("select[name='status']").val();
                var form = {
                    "_token": "{{ csrf_token() }}",
                    count:count,
                    time:time,
                    price:price,
                    carrier_price:carrier_price,
                    carrier_name:carrier_name,
                    track:track,
                    deliver:deliver,
                    cancel:cancel,
                    status:status,
                    update:2,
                    payId:$(this).attr('id'),
                };
                $.ajax({
                    url: "/admin/pay/"+pays.id,
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
            $(".cartDetailInfo .checkout").click(function() {
                var form = {
                    "_token": "{{ csrf_token() }}",
                    update:3,
                    payId:$(this).attr('id'),
                };
                $.ajax({
                    url: "/admin/pay/"+pays.id,
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
            $(".titleProducts button").click(function(e) {
                $('.addProducts').toggle();
            })
            $(".addProducts .btnCan").click(function(e) {
                e.preventDefault();
                $('.addProducts').toggle();
            })
        })
    </script>
@endsection

@section('map')
    <script src="/js/jquery.toast.min.js"></script>
@endsection

@section('mapLink')
    <link rel="stylesheet" href="/css/jquery.toast.min.css"/>
@endsection
