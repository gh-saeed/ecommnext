<div class="allCategoryIndex width">
    <div dir="rtl" class="swiper catSwiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="item">
                    <i>
                        <svg class="icon">
                            <use xlink:href="#cats2"></use>
                        </svg>
                    </i>
                    <div class="name">دسته بندی ها</div>
                </div>
            </div>
            @foreach($data['post'] as $item)
                <div class="swiper-slide">
                    <a href="/category/{{$item->slug}}">
                        <div class="pic">
                            <img lazy="loading" class="lazyload" src="/img/404Image.png" data-src="{{$item->image}}" alt="{{$item->name}}">
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
