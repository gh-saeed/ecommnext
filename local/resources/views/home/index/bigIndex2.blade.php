<div class="allBigIndex2">
    <div class="swiper swiperBig2">
        <div class="swiper-wrapper">
            @foreach(json_decode($data['ads1']) as $item)
                <div class="swiper-slide adsItem">
                    <a href="{{$item->address}}">
                        <img lazy="loading" width="1500" height="400" src="{{$item->image}}" alt="{{$item->address}}">
                    </a>
                </div>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
    </div>
</div>
