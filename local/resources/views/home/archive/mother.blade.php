@extends('home.master')

@section('title' , $category->name)
@section('content')
    <main class="allMotherArchive">
        <div class="titleM width">
            <h1 class="name">{{$category->name}}</h1>
            <section class="address" aria-label="Breadcrumb">
                <a href="/">خانه</a>
                <a href="#">{{$category->name}}</a>
            </section>
        </div>
        <div class="allCategoryIndex width">
            <div dir="rtl" class="swiper mySwiper">
                <div class="swiper-wrapper">
                    @foreach($subCats as $item)
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
        @if(count($betSell) >= 1)
            <div class="allProductList width">
                <div class="title1">پرفروش ترین محصولات</div>
                <div dir="rtl" class="swiper swiperBig">
                    <div class="swiper-wrapper">
                        @foreach($betSell as $item)
                            <div class="swiper-slide">
                                <a href="/product/{{$item->slug}}" name="{{$item->title}}" title="{{$item->title}}">
                                    <article>
                                        <div class="momentPic">
                                            @if($item->image != '[]')
                                                <img class="lazyload" src="/img/404Image.png" data-src="{{json_decode($item->image)[0]}}" alt="{{$item->imageAlt}}">
                                            @endif
                                        </div>
                                        <div class="title2">{{$item->title}}</div>
                                        <div class="price1">{{number_format($item->price)}}</div>
                                        <div class="addCart">
                                            <i>
                                                <svg class="icon">
                                                    <use xlink:href="#cart"></use>
                                                </svg>
                                            </i>
                                            افزودن به سبد خرید
                                        </div>
                                    </article>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
        @if(count($freeCarrier) >= 1)
            <div class="allProductList width">
                <div class="title1">محصولات ارسال رایگان</div>
                <div dir="rtl" class="swiper swiperBig">
                    <div class="swiper-wrapper">
                        @foreach($freeCarrier as $item)
                            <div class="swiper-slide">
                                <a href="/product/{{$item->slug}}" name="{{$item->title}}" title="{{$item->title}}">
                                    <article>
                                        <div class="momentPic">
                                            @if($item->image != '[]')
                                                <img class="lazyload" src="/img/404Image.png" data-src="{{json_decode($item->image)[0]}}" alt="{{$item->imageAlt}}">
                                            @endif
                                        </div>
                                        <div class="title2">{{$item->title}}</div>
                                        <div class="price1">{{number_format($item->price)}}</div>
                                        <div class="addCart">
                                            <i>
                                                <svg class="icon">
                                                    <use xlink:href="#cart"></use>
                                                </svg>
                                            </i>
                                            افزودن به سبد خرید
                                        </div>
                                    </article>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
        <div class="allSellerIndex width">
            <div class="width">
                <div class="title">
                    <div class="name">غرفه‌دار ها</div>
                    <a href="/vendors">
                        <i>
                            <svg class="icon">
                                <use xlink:href="#left3"></use>
                            </svg>
                        </i>
                        مشاهده بیشتر
                    </a>
                </div>
                <div dir="rtl" class="swiper sellerSwiper1 swiper-h">
                    <div class="swiper-wrapper">
                        @foreach($sellers as $item)
                            <div class="swiper-slide">
                                <div class="sellerItem">
                                    <div class="title2">
                                        <a href="/{{'@'.$item->slug}}" class="profile">
                                            <div class="pic">
                                                <img src="{{$item->profile??'/img/user.png'}}" alt="{{$item->name}}">
                                            </div>
                                            <div class="detail">
                                                <div class="name">{{$item->name}}</div>
                                                <div class="city">{{$item->city}}</div>
                                            </div>
                                        </a>
                                    </div>
                                    <div dir="rtl" class="swiper sellerSwiper2 swiper-v">
                                        <div class="swiper-wrapper">
                                            @foreach($item->product()->where('status',1)->take(4)->get() as $val)
                                                <div class="swiper-slide">
                                                    <a href="/product/{{$val->slug}}">
                                                        <div class="pic">
                                                            <img lazy="loading" class="lazyload" src="/img/404Image.png" data-src="{{$val->image != '[]' ? json_decode($val->image)[0] : ''}}" alt="{{$val->title}}">
                                                        </div>
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @if(count($newProduct) >= 1)
            <div class="allProductList width">
                <div class="title1">جدید ترین محصولات</div>
                <div dir="rtl" class="swiper swiperBig">
                    <div class="swiper-wrapper">
                        @foreach($newProduct as $item)
                            <div class="swiper-slide">
                                <a href="/product/{{$item->slug}}" name="{{$item->title}}" title="{{$item->title}}">
                                    <article>
                                        <div class="momentPic">
                                            @if($item->image != '[]')
                                                <img class="lazyload" src="/img/404Image.png" data-src="{{json_decode($item->image)[0]}}" alt="{{$item->imageAlt}}">
                                            @endif
                                        </div>
                                        <div class="title2">{{$item->title}}</div>
                                        <div class="price1">{{number_format($item->price)}}</div>
                                        <div class="addCart">
                                            <i>
                                                <svg class="icon">
                                                    <use xlink:href="#cart"></use>
                                                </svg>
                                            </i>
                                            افزودن به سبد خرید
                                        </div>
                                    </article>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
        <div class="box width">
            <div class="title2">{{$category->name}}</div>
            <div class="body">{!! $category->body !!}</div>
        </div>
    </main>
@endsection

@section('linkPage')
    <link rel="stylesheet" href="/css/swiper.min.css">
    <script src="/js/swiper.min.js"></script>
@endsection

@section('scriptPage')
    <script>
        $(document).ready(function () {
            new Swiper(".sellerSwiper1", {
                spaceBetween: 15,
                breakpoints: {
                    100: {
                        slidesPerView: 1,
                    },
                    1024: {
                        slidesPerView: 3,
                    },
                },
            });
            new Swiper(".swiperBig", {
                spaceBetween: 15,
                breakpoints: {
                    100: {
                        slidesPerView: 2,
                    },
                    1024: {
                        slidesPerView: 5,
                    },
                },
            });
            new Swiper(".sellerSwiper2", {
                spaceBetween: 5,
                breakpoints: {
                    100: {
                        slidesPerView: 2,
                    },
                    1024: {
                        slidesPerView: 3,
                    },
                },
            });
            new Swiper(".mySwiper", {
                spaceBetween: 15,
                breakpoints: {
                    100: {
                        slidesPerView: 3,
                    },
                    1024: {
                        slidesPerView: 10,
                    },
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
            });
        })
    </script>
@endsection
