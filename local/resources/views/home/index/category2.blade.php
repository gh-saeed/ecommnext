<div class="allCategoryIndex2 width">
    <div dir="rtl" class="swiper category2">
        <div class="swiper-wrapper">
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
