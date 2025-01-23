<div class="allSellerIndex">
    <div class="width">
        <div class="title">
            <div class="name">
                <i>
                    <svg class="icon">
                        <use xlink:href="#seller2"></use>
                    </svg>
                </i>
                {{$data['title']}}
            </div>
            <a href="/vendors">
                <i>
                    <svg class="icon">
                        <use xlink:href="#left3"></use>
                    </svg>
                </i>
                {{$data['more']}}
            </a>
        </div>
        <div dir="rtl" class="swiper sellerSwiper1 swiper-h">
            <div class="swiper-wrapper">
                @foreach($data['post'] as $item)
                    <div class="swiper-slide">
                        <div class="sellerItem">
                            <div class="title2">
                                <div class="profile">
                                    <div class="pic">
                                        <img src="{{$item->profile??'/img/user.png'}}" alt="{{$item->name}}">
                                    </div>
                                    <div class="detail">
                                        <div class="name">{{$item->name}}</div>
                                    </div>
                                </div>
                                <a class="more" href="/{{'@'.$item->slug}}">
                                    <i>
                                        <svg class="icon">
                                            <use xlink:href="#replyAll"></use>
                                        </svg>
                                    </i>
                                    همه محصولات
                                </a>
                            </div>
                            <div dir="rtl" class="swiper sellerSwiper2 swiper-v">
                                <div class="swiper-wrapper">
                                    @foreach($item->product()->where('status',1)->get() as $val)
                                        <div class="swiper-slide">
                                            <a href="/product/{{$val->slug}}">
                                                <div class="pic">
                                                    <img lazy="loading" class="lazyload" src="/img/404Image.png" data-src="{{$val->image != '[]' ? json_decode($val->image)[0] : ''}}" alt="{{$val->title}}">
                                                </div>
                                                <div class="title3">{{$val->title}}</div>
                                                <div class="price">{{number_format($val->price)}} <span>تومان</span></div>
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
