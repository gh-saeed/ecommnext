@extends('home.master')

@section('title' , 'سبد خرید بعدی')
@section('content')
    <main class="allCartIndex width">
        <div class="title">
            <div class="name">
                <i>
                    <svg class="icon">
                        <use xlink:href="#cart"></use>
                    </svg>
                </i>
                سبد خرید بعدی
            </div>
            <a href="/cart" class="next">
                سبد خرید
                <i>
                    <svg class="icon">
                        <use xlink:href="#left"></use>
                    </svg>
                </i>
            </a>
        </div>
        <div class="container1" style="{{count($getCart[0]) == 0 ? 'display:none' : ''}}">
            <div class="right">
                <div class="carts">
                    @foreach($getCart[0] as $item)
                        <div class="item">
                            <div class="topItem">
                                <div class="description">
                                    <div class="title3">{{$item['title']}}</div>
                                    <div class="price">
                                        <div class="name">مبلغ :</div>
                                        <span>{{number_format((($item['price'] - $item['carrier_price']) * $item['count']))}} تومان</span>
                                    </div>
                                    <div class="price">
                                        <div class="name">هزینه ارسال :</div>
                                        <span>{{$item['carrier_price'] >= 1 ? number_format($item['carrier_price']) . ' تومان' : 'رایگان'}}</span>
                                    </div>
                                    <div class="price">
                                        <div class="name">تخمین زمان ارسال :</div>
                                        <span>{{$item['time']}} روز آینده</span>
                                    </div>
                                    <div class="options">
                                        <div class="option">{{$item['color']??'بدون رنگ'}}</div>
                                        <div class="option">{{$item['size']??'بدون سایز'}}</div>
                                    </div>
                                </div>
                                <a href="/product/{{$item['slug']}}" class="pic">
                                    <img src="{{$item['image']}}" alt="{{$item['title']}}">
                                </a>
                            </div>
                            <div class="botItem">
                                <div class="operations">
                                    <div class="operation">
                                        <i>
                                            <svg class="icon">
                                                <use xlink:href="#more"></use>
                                            </svg>
                                        </i>
                                    </div>
                                    <ul>
                                        <li><div class="move" id="{{$item['id']}}">انتقال به سبد اصلی</div></li>
                                        <li><div class="delete" id="{{$item['id']}}">حذف از سبد</div></li>
                                    </ul>
                                    <a href="/{{'@'.$item['user_slug']}}" class="seller">{{$item['user_name']}}</a>
                                </div>
                                <div class="change">
                                    <div class="minus button1">
                                        <i>
                                            <svg class="icon">
                                                <use xlink:href="#minus"></use>
                                            </svg>
                                        </i>
                                    </div>
                                    <div class="count" data-num="{{$item['max']}}">{{$item['count']}}</div>
                                    <div class="plus button1">
                                        <i>
                                            <svg class="icon">
                                                <use xlink:href="#plus"></use>
                                            </svg>
                                        </i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="left">
                <div class="box">
                    <div class="item">
                        <div class="name">مبلغ سبد خرید</div>
                        <div class="body cartP">{{number_format($getCart[2]-$getCart[1])}}</div>
                    </div>
                    <div class="item">
                        <div class="name">هزینه ارسال</div>
                        <div class="body carrierP">{{number_format($getCart[1])}}</div>
                    </div>
                    <div class="item final">
                        <div class="name">هزینه قابل پرداخت</div>
                        <div class="body finalP">{{number_format($getCart[2])}}</div>
                    </div>
                    <form action="/move/all" method="POST">
                        @csrf
                        <button class="move">انتقال همه به سبد اصلی</button>
                    </form>
                </div>
                <div class="allCategoryIndex">
                    <div class="title2">محصولات مرتبط را مشاهده بفرمایید</div>
                    <div dir="rtl" class="swiper mySwiper">
                        <div class="swiper-wrapper">
                            @foreach($cats as $item)
                                <div class="swiper-slide">
                                    <a href="/category/{{$item->slug}}">
                                        <div class="pic">
                                            <img lazy="loading" class="lazyload" src="/img/404Image.png" data-src="{{$item->image}}" alt="{{$item->nameSeo}}">
                                        </div>
                                        <div class="name">{{$item->name}}</div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
            </div>
        </div>
        <section class="allCartIndexEmpty" style="{{count($getCart[0]) >= 1 ? 'display:none' : ''}}">
            <i>
                <svg class="icon">
                    <use xlink:href="#cart"></use>
                </svg>
            </i>
            <p>{{__('messages.empty_cart')}}</p>
        </section>
    </main>
@endsection

@section('linkPage')
    <link rel="stylesheet" href="/css/jquery.toast.min.css"/>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
@endsection
@section('scriptPage')
    <script src="/js/jquery.toast.min.js"></script>
    <script>
        $(document).mouseup(function(e)
        {
            var container = $(".operations ul");
            if (container.is(e.target) == false && container.has(e.target).length == 0)
            {
                $('.operations ul').hide();
            }
        });
        $(document).ready(function () {
            new Swiper(".mySwiper", {
                breakpoints: {
                    640: {
                        slidesPerView: 1,
                    },
                    1024: {
                        slidesPerView: 2,
                        spaceBetween: 10,
                    },
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
            });
            $('.carts .item .operation').on('click',function(){
                $($(this)[0]['parentElement']).find('ul').toggle();
            })
            $(document).on('click','.container1 .plus',function(){
                var $countInput = $(this.previousElementSibling);
                var currentVal = parseInt($countInput.text());
                if($countInput.attr('data-num') > currentVal){
                    if (!isNaN(currentVal)) {
                        $countInput.text(currentVal + 1);
                        var counts = [];
                        $.each($(".container1 .item .count") , function(){
                            counts.push($(this).text());
                        })

                        var form = {
                            "_token": "{{ csrf_token() }}",
                            "count": JSON.stringify(counts),
                        };
                        $.ajax({
                            url: "/change-cart",
                            type: "post",
                            data: form,
                            success: function (data) {
                                if (typeof data[0] === "string") {
                                    $countInput.text(currentVal);
                                    $.toast({
                                        text: data, // Text that is to be shown in the toast
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
                                }else{
                                    $(".finalP").text(makePrice(data[2]));
                                    $(".carrierP").text(makePrice(data[1]));
                                    $(".cartP").text(makePrice(data[2] - data[1]));
                                    getData(data[0]);
                                }
                            },
                        });
                    }
                }
            });
            $(document).on('click','.container1 .minus',function(){
                var $countInput = $(this.nextElementSibling);
                var currentVal = parseInt($countInput.text());
                if (!isNaN(currentVal) && currentVal >= 2) {
                    $countInput.text(currentVal - 1);
                    var counts = [];
                    $.each($(".container1 .item .count") , function(){
                        counts.push($(this).text());
                    })

                    var form = {
                        "_token": "{{ csrf_token() }}",
                        "count": JSON.stringify(counts),
                    };
                    $.ajax({
                        url: "/change-cart",
                        type: "post",
                        data: form,
                        success: function (data) {
                            if (typeof data[0] === "string") {
                                $countInput.text(currentVal);
                                $.toast({
                                    text: data, // Text that is to be shown in the toast
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
                            }else{
                                $(".finalP").text(makePrice(data[2]));
                                $(".carrierP").text(makePrice(data[1]));
                                $(".cartP").text(makePrice(data[2] - data[1]));
                                getData(data[0]);
                            }
                        },
                    });
                }
            });
            $(document).on('click','.container1 .delete',function(){
                var form = {
                    "_token": "{{ csrf_token() }}",
                    "cart": $(this).attr('id'),
                };
                $.ajax({
                    url: "/delete-cart",
                    type: "delete",
                    data: form,
                    success: function (data) {
                        $(".finalP").text(makePrice(data[2]));
                        $(".carrierP").text(makePrice(data[1]));
                        $(".cartP").text(makePrice(data[2] - data[1]));
                        getData(data[0]);
                    },
                });
            });
            $(document).on('click','.container1 .move',function(){
                var form = {
                    "_token": "{{ csrf_token() }}",
                    "cart": $(this).attr('id'),
                    "type": 0,
                };
                $.ajax({
                    url: "/move-cart",
                    type: "post",
                    data: form,
                    success: function (data) {
                        $(".finalP").text(makePrice(data[2]));
                        $(".carrierP").text(makePrice(data[1]));
                        $(".cartP").text(makePrice(data[2] - data[1]));
                        getData(data[0]);
                    },
                });
            });
            function getData(data){
                $(".container1 .carts .item").remove();
                $.each(data, function () {
                    $('.carts').append(
                        $(`<div class="item">
                            <div class="topItem">
                                <div class="description">
                                    <div class="title3">${this.title}</div>
                                    <div class="price">
                                        <div class="name">مبلغ :</div>
                                        <span>${makePrice(((this.price - this.carrier_price) * this.count))} تومان</span>
                                    </div>
                                    <div class="price">
                                        <div class="name">هزینه ارسال :</div>
                                        <span>${this.carrier_price >= 1 ? makePrice(this.carrier_price) + ' تومان' : 'رایگان'}</span>
                                    </div>
                                    <div class="price">
                                        <div class="name">تخمین زمان ارسال :</div>
                                        <span>${this.time} روز آینده</span>
                                    </div>
                                    <div class="options">
                                        <div class="option">${this.color?this.color:'بدون رنگ'}</div>
                                        <div class="option">${this.size?this.size:'بدون سایز'}</div>
                                    </div>
                                </div>
                                <a href="/product/${this.slug}" class="pic">
                                    <img src="${this.image}" alt="${this.title}">
                                </a>
                            </div>
                            <div class="botItem">
                                <div class="operations">
                                    <div class="operation">
                                        <i>
                                            <svg class="icon">
                                                <use xlink:href="#more"></use>
                                            </svg>
                                        </i>
                                    </div>
                                    <ul>
                                        <li><div class="move" id="${this.id}">انتقال به سبد بعدی</div></li>
                                        <li><div class="delete" id="${this.id}">حذف از سبد</div></li>
                                    </ul>
                                    <a href="/${'@'+this.user_slug}" class="seller">${this.user_name}</a>
                                </div>
                                <div class="change">
                                    <div class="minus button1">
                                        <i>
                                            <svg class="icon">
                                                <use xlink:href="#minus"></use>
                                            </svg>
                                        </i>
                                    </div>
                                    <div class="count" data-num="${this.max}">${this.count}</div>
                                    <div class="plus button1">
                                        <i>
                                            <svg class="icon">
                                                <use xlink:href="#plus"></use>
                                            </svg>
                                        </i>
                                    </div>
                                </div>
                            </div>
                        </div>`)
                    );
                })
                let lazy = lazyload();
                $("img.lazyload").lazyload();
            }
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

