<section class="allBigIndex" style="background-image: url({{$data['background']}})">
    <div class="section width">
        <div class="content">
            <div class="title1">{{$data['title']}}</div>
            <p>{{$data['description']}}</p>
            <a href="{{$data['slug']}}">{{$data['more']}}</a>
        </div>
        <div class="swiper swiperBig">
            <div class="swiper-wrapper">
                @foreach($data['post'] as $item)
                    <div class="swiper-slide">
                        <a href="/product/{{$item->slug}}">
                            <img lazy="loading" class="lazyload" src="/img/404Image.png" data-src="{{$item->image != '[]' ? json_decode($item->image)[0] : ''}}" alt="{{$item->title}}">
                            <div class="cost">غرفه‌دار : {{$item->user?$item->user->name:'-'}}</div>
                            <div class="overlay">
                                <div class="title2">{{$item->title}}</div>
                                <p>{{$item->nody}}</p>
                                <div class="price">{{number_format($item->price)}} <span>تومان</span></div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
