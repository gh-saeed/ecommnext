<div class="allProductList width">
    <div class="title1">{{$data['title']}}</div>
    <div dir="rtl" class="swiper listSwiper">
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
