<div class="allBlogIndex width">
    <div dir="rtl" class="swiper blogSwiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <a href="/blog" class="blogTitle">
                    <i>
                        <svg class="icon">
                            <use xlink:href="#newspaper"></use>
                        </svg>
                    </i>
                    <div class="title">{{$data['title']}}</div>
                    <div class="name">{{$data['more']}}</div>
                </a>
            </div>
            @foreach($data['post'] as $item)
                <div class="swiper-slide">
                    <a href="/blog/{{$item->slug}}">
                        <div class="pic">
                            <img lazy="loading" class="lazyload" src="/img/404Image.png" data-src="{{$item->image}}" alt="{{$item->titleSeo}}">
                        </div>
                        <div class="name">{{$item->title}}</div>
                    </a>
                </div>
            @endforeach
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</div>
