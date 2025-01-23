<div class="momentProduct width">
    <div class="rightMoment">
        <div class="rightMomentTitle">{{$data['title']}}</div>
        <div dir="rtl" class="swiper momentSwiper">
            <div class="swiper-wrapper">
                @foreach($data['post'] as $item)
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
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
    <div class="leftMoment">
        <div class="title1">
            <svg class="icon">
                <use xlink:href="#clock"></use>
            </svg>
            محصولات فروش ویژه
        </div>
        <div class="slider-moment2 owl-carousel owl-theme">
            @foreach ($moment as $item)
                <div>
                    <a href="/product/{{$item->slug}}" name="{{$item->title}}" title="{{$item->title}}">
                        <article>
                            <div class="timer"></div>
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
