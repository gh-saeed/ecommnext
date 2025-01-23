<div class="allBlogIndex2 width">
    <div class="title">
        <div class="name">{{$item['title']}}</div>
    </div>
    <div dir="rtl" class="swiper blogSwiper2">
        <div class="swiper-wrapper">
            @foreach($data['post'] as $item)
                <div class="swiper-slide">
                    <a href="/blog/{{$item->slug}}">
                        <div class="pic">
                            <img lazy="loading" class="lazyload" src="/img/404Image.png" data-src="{{$item->image}}" alt="{{$item->titleSeo}}">
                            <span>{{$item->user->name}}</span>
                        </div>
                        <div class="name">{{$item->title}}</div>
                        <div class="user">
                            <i>
                                <svg class="icon">
                                    <use xlink:href="#clock"></use>
                                </svg>
                            </i>
                            {{$item->created_at}}
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</div>
