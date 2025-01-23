@extends('home.master')

@section('title',$products->title)
@section('content')
    <main class="allProductSingle2 width">
        <div class="address" aria-label="Breadcrumb">
            <i>
                <svg class="icon">
                    <use xlink:href="#location"></use>
                </svg>
            </i>
            <a href="/">خانه</a>
            @if(count($products['category']) >= 1)
                @foreach ($products['category']->slice(0,1) as $address)
                    <a href="/category/{{$address->slug}}">{{$address->name}}</a>
                @endforeach
            @endif
            <a>{{$products->title}}</a>
        </div>
        <div class="containers">
            <div class="container1">
                <div class="top">
                    <div class="right">
                        <div class="gallery">
                            <div class="options">
                                <div class="option like" id="likeBtn" title="علاقه مندی">
                                    <i>
                                        @if($like == '')
                                            <svg class="icon">
                                                <use xlink:href="#unlike"></use>
                                            </svg>
                                        @else
                                            <svg class="icon">
                                                <use xlink:href="#like"></use>
                                            </svg>
                                        @endif
                                    </i>
                                    <div class="num">{{\App\Models\Like::where('product_id',$products->id)->count()}}</div>
                                </div>
                                <div class="option report" title="گزارش">
                                    <i>
                                        <svg class="icon">
                                            <use xlink:href="#warning"></use>
                                        </svg>
                                    </i>
                                    <div class="num">{{\App\Models\Report::where('reportable_id',$products->id)->where('status',1)->where('reportable_type','App\\Models\\Product')->count()}}</div>
                                </div>
                                <div class="option chart" title="لیست تغییرات قیمت">
                                    <i>
                                        <svg class="icon">
                                            <use xlink:href="#chart"></use>
                                        </svg>
                                    </i>
                                </div>
                                <div class="option share" title="اشتراک گذاری">
                                    <i>
                                        <svg class="icon">
                                            <use xlink:href="#share"></use>
                                        </svg>
                                    </i>
                                </div>
                            </div>
                            <div class="showImage">
                                <img class="zoom lazyload" lazy="loading" src="/img/404Image.png" data-src="{{$images[0]}}" alt="{{$products->title}}"/>
                            </div>
                            <div class="imageSlider">
                                <div class="slider-image owl-carousel owl-theme">
                                    @foreach($images as $item)
                                        <figure>
                                            <img class="lazyload" lazy="loading" src="/img/404Image.png" data-src="{{$item}}" alt="{{$products->title}}">
                                        </figure>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="left">
                        <div class="details">
                            <div class="title">
                                <h1>{{$products->title}}</h1>
                            </div>
                            <div class="boxes">
                                <div class="box">
                                    <i>
                                        <svg class="icon">
                                            <use xlink:href="#location"></use>
                                        </svg>
                                    </i>
                                    <div class="name">ارسال از {{$seller->city}}</div>
                                </div>
                                <div class="box">
                                    <i>
                                        <svg class="icon">
                                            <use xlink:href="#car"></use>
                                        </svg>
                                    </i>
                                    <div class="name">ارسال از {{$products->time}} روز دیگر</div>
                                </div>
                            </div>
                            @if($products->colors && $products['colors'] != '[]')
                                <div class="choice">
                                    <div class="title1">رنگ ها</div>
                                    <ul class="colors">
                                        @foreach (json_decode($products['colors']) as $item)
                                            <li data-empty="{{$item->count?'exist':'empty'}}" data-price="{{$item->price}}">{{$item->name}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if($products->size && $products['size'] != '[]')
                                <div class="choice">
                                    <div class="title1">سایز ها</div>
                                    <ul class="sizes">
                                        @foreach (json_decode($products['size']) as $item)
                                            <li data-empty="{{$item->count?'exist':'empty'}}" data-price="{{$item->price}}">{{$item->name}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                        <div class="options">
                            <div class="option">
                                <div class="pic">
                                    <img src="/img/original.png" alt="تضمین بازگشت وجه">
                                </div>
                                <div class="body">تضمین بازگشت فوری وجه</div>
                            </div>
                            <div class="option">
                                <div class="pic">
                                    <img src="/img/chat.svg" alt="ارتباط مستقیم با غرفه‌دارها">
                                </div>
                                <div class="body">ارتباط مستقیم با غرفه‌دارها</div>
                            </div>
                            <div class="option">
                                <div class="pic">
                                    <img src="/img/support.svg" alt="پشتیبانی آنلاین و تلفنی">
                                </div>
                                <div class="body">پشتیبانی به صورت آنلاین و تلفنی</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="details">
                    <div class="body">
                        <div class="title bodyT">
                            درباره محصول
                            <i>
                                <svg class="icon">
                                    <use xlink:href="#down"></use>
                                </svg>
                            </i>
                        </div>
                        <p>{{$products->body}}</p>
                    </div>
                    <div class="ability">
                        <div class="title bodyT">
                            ویژگی ها
                            <i>
                                <svg class="icon">
                                    <use xlink:href="#down"></use>
                                </svg>
                            </i>
                        </div>
                        <ul>
                            @foreach(json_decode($products->ability) as $item)
                                <li>
                                    <div class="title2">{{++$loop->index}} : </div>
                                    <div class="body2">{{$item->name}}</div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="comment1">
                        @include('home.single.comment' , ['post' => $products , 'comments' => $comments,'type'=>0])
                    </div>
                </div>
            </div>
            <div>
                <div class="container2">
                    <div class="seller">
                        <div class="title">
                            <i>
                                <svg class="icon">
                                    <use xlink:href="#shop"></use>
                                </svg>
                            </i>
                            غرفه‌دار
                        </div>
                        <a href="/{{'@'.$seller->slug}}" target="_blank" class="profile">
                            <div class="pic">
                                <img src="{{$seller->profile??'/img/user.png'}}" alt="{{$seller->name}}">
                            </div>
                            <div class="detail">
                                <div class="name">{{$seller->name}}</div>
                                <div class="city">از {{$seller->city}}</div>
                            </div>
                        </a>
                        <div class="social">
                            <div class="chat">
                                <i>
                                    <svg class="icon">
                                        <use xlink:href="#chat2"></use>
                                    </svg>
                                </i>
                                گفت‌وگو
                            </div>
                            <div class="info">
                                <i>
                                    <svg class="icon">
                                        <use xlink:href="#info2"></use>
                                    </svg>
                                </i>
                                اطلاعات بیشتر
                            </div>
                        </div>
                        <div class="showAll">
                            وضعیت غرفه‌دار :
                            <span class="{{$onlineCheck?'active':''}}">{{$onlineCheck?'آنلاین':'آفلاین'}}</span>
                        </div>
                    </div>
                    <div class="boxPrice">
                        <ul>
                            <li>
                                <div class="name">قیمت محصول</div>
                                <div class="price">{{number_format($products->price)}} <span>تومان</span></div>
                            </li>
                            @if($products->colors && $products['colors'] != '[]')
                                <li>
                                    <div class="name">هزینه رنگ</div>
                                    <div class="price"><div id="colorPrice0">0</div> <span>تومان</span></div>
                                </li>
                            @endif
                            @if($products->size && $products['size'] != '[]')
                                <li>
                                    <div class="name">هزینه سایز</div>
                                    <div class="price"><div id="sizePrice0">0</div> <span>تومان</span></div>
                                </li>
                            @endif
                            <li>
                                <div class="name">هزینه ارسال ({{$products->carriers()->value('name')}})</div>
                                @if($carrierPrice>=1)
                                    <div class="price"><div>{{number_format($carrierPrice)}}</div> <span>تومان</span></div>
                                @else
                                    <div class="price">رایگان</div>
                                @endif
                            </li>
                            <li class="final">
                                <div class="name">هزینه قابل پرداخت</div>
                                <div class="price"><div id="fPrice">{{number_format($carrierPrice+$products->price)}}</div> <span>تومان</span></div>
                            </li>
                        </ul>
                        <div class="addCart">
                            <i>
                                <svg class="icon">
                                    <use xlink:href="#cart"></use>
                                </svg>
                            </i>
                            <div class="name">افزودن به سبد خرید</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if(count($products['category']) >= 1)
            <div class="searches">
                <div class="title">دسته بندی های مرتبط</div>
                <ul>
                    @foreach ($products['category'] as $address)
                        <li><a href="/category/{{$address->slug}}">{{$address->name}}</a></li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(count($related) >= 1)
            <div class="related">
                <div class="title">محصولات مرتبط</div>
                <div class="items">
                    @foreach($related as $item)
                        <div class="item">
                            <a href="/product/{{$item->slug}}">
                                <div class="pic">
                                    <img lazy="loading" class="lazyload" src="/img/404Image.png" data-src="{{$item->image != '[]' ? json_decode($item->image)[0] : ''}}" alt="">
                                </div>
                                <div class="title2">{{$item->title}}</div>
                                <div class="seller">{{$item->user?$item->user->name:'-'}}</div>
                                <div class="price">
                                    <div class="price1">{{number_format($item->price)}}</div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        <div class="addRes">
            <div class="top">
                <div class="final prices">
                    <div class="price"><div id="fPrice">{{number_format($carrierPrice+$products->price)}}</div> <span>تومان</span></div>
                </div>
                <div class="carrier prices">
                    <div class="name">{{$products->carriers()->value('name')}} :</div>
                    <div class="price"><div>{{number_format($carrierPrice)}}</div> <span>تومان</span></div>
                </div>
            </div>
            <div class="bot">
                <div class="addCart">
                    <i>
                        <svg class="icon">
                            <use xlink:href="#cart"></use>
                        </svg>
                    </i>
                    <div class="name">افزودن به سبد خرید</div>
                </div>
                <div class="info">
                    <i>
                        <svg class="icon">
                            <use xlink:href="#shop"></use>
                        </svg>
                    </i>
                </div>
                <div class="chat">
                    <i>
                        <svg class="icon">
                            <use xlink:href="#chat2"></use>
                        </svg>
                    </i>
                </div>
            </div>
        </div>
        <div class="sellerInfo" style="display:none;">
            <div class="data">
                <div class="title">
                    <div class="name">غرفه‌دار</div>
                    <div class="location">
                        <i>
                            <svg class="icon">
                                <use xlink:href="#location"></use>
                            </svg>
                        </i>
                        {{$seller->city}}
                    </div>
                </div>
                <div class="profile">
                    <div class="pic">
                        <img src="{{$seller->profile??'/img/user.png'}}" alt="{{$seller->name}}">
                    </div>
                    <div class="name">{{$seller->name}}</div>
                    <p>{{$seller->body}}</p>
                </div>
                <div class="options">
                    <div class="option">
                        <div class="body2">{{$seller->documentSuccess?str_replace('قبل','',$seller->documentSuccess->created_at):'به تازگی'}}</div>
                        <div class="title2">فعالیت</div>
                    </div>
                    <div class="option">
                        <div class="body2">{{\App\Models\Product::where('user_id',$seller->id)->where('status',1)->count()}}</div>
                        <div class="title2">محصول</div>
                    </div>
                    <div class="option">
                        <div class="body2">{{$sellerPays}}</div>
                        <div class="title2">فروش</div>
                    </div>
                </div>
                <label for="chat1" class="chatSend1">
                    <input type="text" name="chat" id="chat1" placeholder="با غرفه‌دار گفتگو کن">
                    <i>
                        <svg class="icon">
                            <use xlink:href="#send"></use>
                        </svg>
                    </i>
                </label>
                <p class="time">غرفه‌دار هم اکنون <span class="{{$onlineCheck?'active':''}}">{{$onlineCheck?'آنلاین':'آفلاین'}}</span> میباشد.</p>
                <div class="buttons">
                    <a target="_blank" href="/vendor/{{$seller->slug}}">صفحه اختصاصی</a>
                    <a target="_blank" href="/{{'@'.$seller->slug}}">تجربیات</a>
                </div>
            </div>
        </div>
        <div class="allTicket" style="display:none;">
            <div class="chatContent" id="chatContent3">
                <div class="header">
                    <div class="profile">
                        <div class="pic">
                            <img src="{{$seller->profile??'/img/user.png'}}" alt="{{$seller->name}}">
                        </div>
                        <div class="name">{{$seller->name}}</div>
                    </div>
                    <div class="leftHeader">
                        <i class="cancelChat">
                            <svg class="icon">
                                <use xlink:href="#cancel"></use>
                            </svg>
                        </i>
                    </div>
                </div>
                <div class="body" style="background-image: url('/img/backChat.svg')">
                    <p class="close11">
                        با اتمام گفتگو میتوانید با زدن
                        <span class="closeChats">بستن گفتگو</span>
                        اقدام به قطع گفتگو کنید
                    </p>
                    <div class="messages opp">
                        <div class="text">سلام چطور میتونیم کمکتون کنیم؟</div>
                        <div class="time">{{verta()->format('H:i')}}</div>
                    </div>
                </div>
                @if(auth()->user())
                    <div class="send">
                        <input type="text" name="body" placeholder="پیغام خود را بنویسید">
                        <button>ارسال</button>
                    </div>
                @else
                    <a href="/login" class="loginChat">وارد حساب خود شوید (کلیک کنید)</a>
                @endif
            </div>
        </div>
        <div class="allChangeList" style="display: none">
            <div class="changeList">
                <div class="title2">لیست تغییرات قیمت</div>
                <canvas id="changePrice"></canvas>
            </div>
        </div>
        @include('home.single.report',['name'=>$products->title,'id'=>$products->id,'type'=>0])
        @include('home.single.share',['slug'=>url('/projectID/'.$products->id)])
    </main>
@endsection

@section('scriptPage')
    <link rel="stylesheet" href="/css/owl.carousel.min.css"/>
    <link rel="stylesheet" href="/css/jquery.raty.css"/>
    <link rel="stylesheet" href="/css/jquery.toast.min.css"/>
    <script src="/js/jquery.toast.min.js"></script>
    <script src="/js/jquery.raty.js"></script>
    <script src="/js/owl.carousel.min.js"></script>
    <script src="/js/sweetalert.min.js"></script>
    <script src="/js/chart.js"></script>
    <script>
        $(document).mouseup(function(e)
        {
            var container = $(".sellerInfo");
            var container2 = $(".allTicket");
            var container3 = $(".allCounseling");
            var container4 = $(".showAllShare");
            var container5 = $(".allChangeList");
            if (container.is(e.target) && container.has(e.target).length == 0)
            {
                $('.sellerInfo').hide();
            }
            if (container2.is(e.target) && container2.has(e.target).length == 0)
            {
                $('.allTicket').hide();
            }
            if (container3.is(e.target) && container3.has(e.target).length == 0)
            {
                $('.allCounseling').hide();
            }
            if (container4.is(e.target) && container4.has(e.target).length == 0)
            {
                $('.showAllShare').hide();
            }
            if (container5.is(e.target) && container4.has(e.target).length == 0)
            {
                $('.allChangeList').hide();
            }
        });
        $(document).ready(function () {
            $(".allProductSingle2 .colors li[data-empty='exist']:first").attr("class", 'active');
            $(".allProductSingle2 .sizes li[data-empty='exist']:first").attr("class", 'active');
            var userId = {!! json_encode(auth()->user()?auth()->user()->id:0, JSON_HEX_TAG) !!};
            var seller1 = {!! json_encode($seller, JSON_HEX_TAG) !!};
            var products = {!! json_encode($products, JSON_HEX_TAG) !!};
            var carrierPrice = {!! json_encode($carrierPrice, JSON_HEX_TAG) !!};
            var changes = {!! json_encode($changes, JSON_HEX_TAG) !!};
            var parent = 0;
            var check = 0;
            var guarantee = 0;
            let cp = 0;
            let sp = 0;
            $('.slider-related').owlCarousel({
                loop:false,
                rtl:true,
                margin:10,
                nav:true,
                lazyLoad: true,
                touchDrag: true,
                dots:false,
                responsive:{
                    0:{
                        items:2,
                    },
                    800:{
                        items:3,
                        loop:false
                    }
                }
            })
            $('.allProductSingle2 .bodyT').on('click' , function(){
                $($(this)[0]['parentElement']).find('ul,p').toggle();
            })
            $('.allProductSingle2 .share').on('click' , function(){
                $('.showAllShare').show();
            })
            $('.allProductSingle2 .chart').on('click' , function(){
                $('.allChangeList').show();
            })
            $(".allProductSingle2 .colors li[data-empty='exist']").click(function (){
                $(".allProductSingle2 .colors li[data-empty='exist']").attr('class','');
                $(this).attr('class','active');
                getPrice();
            })
            $(".allProductSingle2 .sizes li[data-empty='exist']").click(function (){
                $(".allProductSingle2 .sizes li[data-empty='exist']").attr('class','');
                $(this).attr('class','active');
                getPrice();
            })
            $(".allProductSingle2 .report,.allCounseling .closeCounseling").click(function (){
                $('.allCounseling').toggle();
            })
            $(".allTicket .leftHeader .cancelChat,.allProductSingle2 .chat").click(function (){
                $('.allTicket').toggle();
            })
            $(".sellerInfo .buttons button,.allProductSingle2 .info").click(function (){
                $('.sellerInfo').toggle();
            })
            $(".allProductSingle2 .details .body button").click(function (){
                $(this).remove();
                $(".allProductSingle2 .details .body p").css({'-webkit-line-clamp':'100'})
            })
            $('.slider-image').owlCarousel({
                loop:false,
                rtl:true,
                nav:true,
                responsive:{
                    0:{
                        items:1,
                        margin:0,
                    },
                    800:{
                        items:4,
                        margin:10,
                    }
                }
            })
            $(document).on('click','.allProductSingle2 .boxPrice .addCart,.allProductSingle2 .addRes .addCart',function (){
                let cpg = $(".allProductSingle2 .colors .active").length >= 1 ? $(".allProductSingle2 .colors .active").text() : ''
                let spg = $(".allProductSingle2 .sizes .active").length >= 1 ? $(".allProductSingle2 .sizes .active").text() : ''
                var addButtonText = $(this).find('.name').text();
                $(this).find('.name').text('صبر کنید');
                var form = {
                    "_token": "{{ csrf_token() }}",
                    "color": cpg,
                    "size": spg,
                    "guarantee": guarantee,
                    "product": products.id,
                };

                $.ajax({
                    url: "/add-cart",
                    type: "post",
                    data: form,
                    success: function (data) {
                        $('.allProductSingle2 .addCart').find('.name').text(addButtonText);
                        if (typeof data[0] === "string") {
                            $.toast({
                                text: 'حداکثر تعداد در سبد خرید شما قرار دارد', // Text that is to be shown in the toast
                                heading: 'ناموفق', // Optional heading to be shown on the toast
                                icon: 'error', // Type of toast icon
                                showHideTransition: 'fade', // fade, slide or plain
                                allowToastClose: true, // Boolean value true or false
                                hideAfter: 3000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                                stack: 5, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
                                position: 'bottom-left', // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values
                                textAlign: 'left',  // Text alignment i.e. left, right or center
                                loader: true,  // Whether to show loader or not. True by default
                                loaderBg: '#c60000',  // Background color of the toast loader
                            });
                        }else{
                            Swal.fire({
                                title: 'محصول به سبد خرید اضافه شد',
                                text: false,
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonText: 'بستن',
                                footer: '<a style="color: red" href="/cart">رفتن به سبد خرید</a>',
                                confirmButtonColor: '#30d633',
                                reverseButtons: true
                            })
                            $('.link #cartCount').text(parseInt(data[3]));
                        }
                    },
                    error: function (xhr) {
                        $('.allProductSingle2 .addCart').find('.name').text(addButtonText);
                        $.toast({
                            text: 'امکان افزودن محصول وجود ندارد', // Text that is to be shown in the toast
                            heading: 'ناموفق', // Optional heading to be shown on the toast
                            icon: 'error', // Type of toast icon
                            showHideTransition: 'fade', // fade, slide or plain
                            allowToastClose: true, // Boolean value true or false
                            hideAfter: 3000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                            stack: 5, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
                            position: 'bottom-left', // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values
                            textAlign: 'left',
                            loader: true,
                            loaderBg: '#c60000',
                        });
                    }
                });
            });
            $(".sellerInfo .chatSend1 i").click(function (){
                $(".sellerInfo").hide();
                $(".allTicket").show();
                $(".allTicket #chatContent3 .send button").text('صبر کنید');
                let formData = new FormData();
                formData.append('_token', "{{ csrf_token() }}");
                formData.append('type', 0);
                formData.append('title', 'چت آنلاین');
                formData.append('body', $(".sellerInfo .chatSend1 input[name='chat']").val());
                formData.append('parent_id', parent);
                formData.append('customer_id', seller1?seller1:userId);
                formData.append('faq', 1);
                formData.append('status', 1);
                $.ajax({
                    url: "/send-ticket",
                    type: "post",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        if(parent == 0){parent = data.id;}
                        $('.allTicket #chatContent3 .body').animate({ scrollTop: $('.allTicket #chatContent3 .body').height() + 20000 }, 1000);
                        $('.allTicket #chatContent3 .body').append(
                            $(`<div class="messages me new">
                            <div class="text">${data.body}</div>
                            <div class="time">${data.created_at}</div>
                        </div>`)
                        );
                        $(".allTicket #chatContent3 .send input[name='body']").val('');
                        $(".allTicket #chatContent3 .send button").text('ارسال');
                        $(".allTicket #chatContent3 .close11").show();
                        check = 0;
                    },
                    error: function (xhr) {
                        $.toast({
                            heading: 'مشکلی پیش امده', // Optional heading to be shown on the toast
                            icon: 'error', // Type of toast icon
                            showHideTransition: 'fade', // fade, slide or plain
                            allowToastClose: true, // Boolean value true or false
                            hideAfter: 3000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                            stack: 5, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
                            position: 'bottom-left', // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values
                            textAlign: 'left',
                            loader: true,
                            loaderBg: '#c60000',
                        });
                        $(".allTicket #chatContent3 .send button").text('ارسال پیام');
                    }
                });
            })
            $(".allTicket #chatContent3 .send button").click(function (){
                $(".allTicket #chatContent3 .send button").text('صبر کنید');
                let formData = new FormData();
                formData.append('_token', "{{ csrf_token() }}");
                formData.append('type', 0);
                formData.append('title', 'چت آنلاین');
                formData.append('body', $(".allTicket #chatContent3 .send input[name='body']").val());
                formData.append('parent_id', parent);
                formData.append('customer_id', seller1?seller1:userId);
                formData.append('faq', 1);
                formData.append('status', 1);
                $.ajax({
                    url: "/send-ticket",
                    type: "post",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        if(parent == 0){parent = data.id;}
                        $('.allTicket #chatContent3 .body').animate({ scrollTop: $('.allTicket #chatContent3 .body').height() + 20000 }, 1000);
                        $('.allTicket #chatContent3 .body').append(
                            $(`<div class="messages me new">
                            <div class="text">${data.body}</div>
                            <div class="time">${data.created_at}</div>
                        </div>`)
                        );
                        $(".allTicket #chatContent3 .send input[name='body']").val('');
                        $(".allTicket #chatContent3 .send button").text('ارسال');
                        $(".allTicket #chatContent3 .close11").show();
                        check = 0;
                    },
                    error: function (xhr) {
                        $.toast({
                            heading: 'مشکلی پیش امده', // Optional heading to be shown on the toast
                            icon: 'error', // Type of toast icon
                            showHideTransition: 'fade', // fade, slide or plain
                            allowToastClose: true, // Boolean value true or false
                            hideAfter: 3000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                            stack: 5, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
                            position: 'bottom-left', // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values
                            textAlign: 'left',
                            loader: true,
                            loaderBg: '#c60000',
                        });
                        $(".allTicket #chatContent3 .send button").text('ارسال پیام');
                    }
                });
            })
            $(".allTicket #chatContent3 .closeChats").click(function (){
                $(".allTicket #chatContent3 .closeChats").text('صبر کنید');
                let formData = new FormData();
                formData.append('_token', "{{ csrf_token() }}");
                formData.append('parent_id', parent);
                $.ajax({
                    url: "/close-chat",
                    type: "post",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        parent = 0;
                        $('.allTicket #chatContent3 .body .new').remove();
                        $(".allTicket #chatContent3 .send input[name='body']").val('');
                        $(".allTicket #chatContent3 .closeChats").text('بستن گفتگو');
                        $(".allTicket #chatContent3 .close11").hide();
                        check = 0;
                    },
                    error: function (xhr) {
                        $.toast({
                            heading: 'مشکلی پیش امده', // Optional heading to be shown on the toast
                            icon: 'error', // Type of toast icon
                            showHideTransition: 'fade', // fade, slide or plain
                            allowToastClose: true, // Boolean value true or false
                            hideAfter: 3000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                            stack: 5, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
                            position: 'bottom-left', // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values
                            textAlign: 'left',
                            loader: true,
                            loaderBg: '#c60000',
                        });
                        $(".allTicket #chatContent3 .closeChats").text('بستن گفتگو');
                    }
                });
            })
            $('#likeBtn').click(function (){
                var form = {
                    "_token": "{{ csrf_token() }}",
                    "product": products.id,
                };

                $.ajax({
                    url: "/like",
                    type: "post",
                    data: form,
                    success: function (data) {
                        if(data == 'success'){
                            $.toast({
                                text: 'علاقه مندی اضافه شد', // Text that is to be shown in the toast
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
                            $('#likeBtn svg').remove();
                            $('#likeBtn .num').text(parseInt($('#likeBtn .num').text())+1);
                            $('#likeBtn i').append(
                                $('<svg class="icon"><use xlink:href="#like"></use></svg>')
                            );
                        }
                        if(data == 'noUser'){
                            $.toast({
                                text: log_first, // Text that is to be shown in the toast
                                heading: need_login2, // Optional heading to be shown on the toast
                                icon: 'error', // Type of toast icon
                                showHideTransition: 'fade', // fade, slide or plain
                                allowToastClose: true, // Boolean value true or false
                                hideAfter: 3000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                                stack: 5, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
                                position: 'bottom-left', // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values
                                textAlign: 'left',
                                loader: true,
                                loaderBg: '#c60000',
                            });
                        }
                        if(data == 'delete'){
                            $.toast({
                                text: 'علاقه مندی حذف شد', // Text that is to be shown in the toast
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
                            $('#likeBtn svg').remove();
                            $('#likeBtn .num').text(parseInt($('#likeBtn .num').text())-1);
                            $('#likeBtn i').append(
                                $('<svg class="icon"><use xlink:href="#unlike"></use></svg>')
                            );
                        }
                    },
                });
            });
            getMessage();
            getPrice();
            setInterval(getMessage,20000);
            function getMessage(){
                if(userId >= 1 && check == 0){
                    var form = {
                        "_token": "{{ csrf_token() }}",
                        'parent':parent,
                        'seller':seller1.id,
                    };
                    $.ajax({
                        url: "/get-online-ticket",
                        type: "post",
                        data: form,
                        success: function (data) {
                            $('.allTicket #chatContent3 .body .new').remove();
                            if(data.length >= 1){
                                if(parent == 0 && data[0].parent_id == 0){
                                    parent = data[0].id;
                                }
                            }else{
                                parent = 0;
                                check = 1;
                            }
                            $.each(data,function (){
                                $('.allTicket #chatContent3 .body').append(
                                    $(`<div class="messages ${userId==this.user_id?'me':''} new">
                            <div class="text">${this.body}</div>
                            <div class="time">${this.created_at}</div>
                        </div>`)
                                );
                                $(".allTicket #chatContent3 .close11").show();
                            })
                            $('.allTicket #chatContent3 .body').animate({ scrollTop: $('.allTicket #chatContent3 .body').height() + 20000 }, 1000);
                        },
                        error: function (xhr) {
                            $(".allTicket #chatContent3 .send button").text('ارسال پیام');
                        }
                    });
                }
            }
            function getPrice(){
                if(products.colors != '' && products.colors != null && products.colors != '[]'){
                    let cpc = $(".allProductSingle2 .colors .active");
                    if(cpc.length >= 1){
                        cp = cpc.attr('data-price') ? cpc.attr('data-price') : 0;
                    }else{
                        $(".boxPrice .addCart").remove();
                    }
                }
                if(products.size != '' && products.size != null && products.size != '[]'){
                    let spc = $(".allProductSingle2 .sizes .active");
                    if(spc.length >= 1){
                        sp = spc.attr('data-price') ? spc.attr('data-price') : 0;
                    }else{
                        $(".boxPrice .addCart").remove();
                    }
                }
                if(products.count <= 0){
                    $(".boxPrice .addCart").remove();
                    $('.allProductSingle2 .boxPrice').append(
                        $(`<div class="empty">
                                    <i>
                                        <svg class="icon">
                                            <use xlink:href="#cart"></use>
                                        </svg>
                                    </i>
                                    <div class="name">ناموجود</div>
                                </div>`));
                }
                $(".allProductSingle2 #colorPrice0").text(makePrice(cp));
                $(".allProductSingle2 #sizePrice0").text(makePrice(sp));
                let fp = parseInt(carrierPrice) + parseInt(products.price) + parseInt(cp) + parseInt(sp);
                $(".allProductSingle2 #fPrice").text(makePrice(fp));
            }
            function makePrice(price){
                price += '';
                x = price.split('.');
                let x1 = x[0];
                let x2 = x.length > 1 ? '.' + x[1] : '';
                let rgx = /(\d+)(\d{3})/;
                while (rgx.test(x1)) {
                    x1 = x1.replace(rgx, '$1' + ',' + '$2');
                }
                let fPrice = x1 + x2;
                return (price>=1 ? fPrice : 0);
            }
            var form = {
                "_token": "{{ csrf_token() }}",
                "productId": products.id,
                "type": 0,
            };
            $.ajax({
                url: "/view",
                type: "post",
                data: form,
            });
            let priceChanges = $.map(changes, function(obj) {
                return obj.price;
            });
            let times = $.map(changes, function(obj) {
                return obj.created_at;
            });
            const data = {
                labels: times,
                datasets: [{
                    label: 'تغییرات قیمت',
                    backgroundColor: 'rgb(0, 255, 0)',
                    borderColor: 'rgb(0, 255, 0)',
                    data: priceChanges,
                }]
            };
            const config = {
                type: 'line',
                data: data,
                options: {
                    plugins: {
                        legend: {
                            position: 'bottom',
                            align: 'center',
                            labels: {
                                font: {
                                    size: 14,
                                    family: 'vazir'
                                },
                            },
                        },
                    },
                }
            };
            const myChart = new Chart(
                document.getElementById('changePrice'),
                config
            );
        })
    </script>
@endsection

@section('linkPage')
    <meta name="og:image" content="{{json_decode($products->image)[0]}}">
    <meta name="product_image" content="{{json_decode($products->image)[0]}}">
    <meta name="product_id" content="{{$products->product_id}}">
    <meta name="product_old_price" content="{{$products->offPrice}}">
    <meta name="product_name" content="{{$products->title}}">
    <meta name="product_title" content="{{$products->title}}">
    <meta name="product_off" content="{{$products->off>=1?$products->off:0}}">
    <meta name="product_available" content="{{$products->count}}">
    <meta http-equiv="content-language" content="fa">
    <meta name="date" content="{{$products->updated_at}}" />
    <meta name="subject" content="{{$products->body}}">
    @if($products->user)
        <meta name="author" content="{{$products->user->name}}">
        <meta name="creator" content="{{$products->user->name}}">
    @endif
    @if($products->colors)
        @if($products['colors'] != '[]')
            @if($products->size)
                @if($products['size'] != '[]')
                    <meta name="product_price" content="{{$products->price + json_decode($products['colors'],true)[0]['price'] + json_decode($products['size'],true)[0]['price']}}">
                @else
                    <meta name="product_price" content="{{$products->price + json_decode($products['colors'],true)[0]['price']}}">
                @endif
            @else
                <meta name="product_price" content="{{$products->price + json_decode($products['colors'],true)[0]['price']}}">
            @endif
        @elseif($products->size)
            @if($products['size'] != '[]')
                <meta name="product_price" content="{{$products->price + json_decode($products['size'],true)[0]['price']}}">
            @else
                <meta name="product_price" content="{{$products->price}}">
            @endif
        @else
            <meta name="product_price" content="{{$products->price}}">
        @endif
    @elseif($products->size)
        @if($products['size'] != '[]')
            <meta name="product_price" content="{{$products->price + json_decode($products['size'],true)[0]['price']}}">
        @else
            <meta name="product_price" content="{{$products->price}}">
        @endif
    @else
        <meta name="product_price" content="{{$products->price}}">
    @endif
    @if($products->count == 0)
        <meta name="availability" content="outofstock">
    @else
        <meta name="availability" content="instock">
    @endif
@endsection
