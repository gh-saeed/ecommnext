@if($data['post'])
    <div class="allSellerDetail">
        <div class="width">
            <div class="right">
                <div class="top">
                    <div class="pic">
                        <img src="{{$data['post']['profile']??'/img/user.png'}}" alt="{{$data['post']['name']}}">
                    </div>
                    <div class="names">
                        <div class="name">{{$data['post']['name']}}</div>
                        <div class="count">{{count($data['post']['product'])}} محصول</div>
                    </div>
                </div>
                <p>{{$data['post']['body']}}</p>
                <div class="options">
                    <div class="option">
                        <i>
                            <svg class="icon">
                                <use xlink:href="#product"></use>
                            </svg>
                        </i>
                        <div class="title2">محصولات</div>
                        <div class="count">{{count($data['post']['product'])}} محصول</div>
                    </div>
                    <div class="option">
                        <i>
                            <svg class="icon">
                                <use xlink:href="#star"></use>
                            </svg>
                        </i>
                        <div class="title2">امتیاز</div>
                        <div class="count">{{\App\Models\Comment::where('type',1)->where('product_id',$data['post']['id'])->where('status',1)->avg('rate')??'5'}} / 5</div>
                    </div>
                    <div class="option">
                        <i>
                            <svg class="icon">
                                <use xlink:href="#clock"></use>
                            </svg>
                        </i>
                        <div class="title2">میزان فعالیت</div>
                        <div class="count">{{str_replace('قبل','',$data['post']['documentSuccess']['created_at'])}}</div>
                    </div>
                    <a href="/{{'@'.$data['post']['slug']}}" class="option">
                        <i>
                            <svg class="icon">
                                <use xlink:href="#more"></use>
                            </svg>
                        </i>
                        <div class="title2">مشاهده</div>
                        <div class="count">همه محصولات</div>
                    </a>
                </div>
            </div>
            <div class="left">
                <div class="swiper detailSwiper" dir="rtl">
                    <div class="swiper-wrapper">
                        @foreach(\App\Models\Product::where('user_id',$data['post']['id'])->take(5)->get() as $item)
                            <div class="swiper-slide">
                                <a href="/product/{{$item->slug}}">
                                    <div class="pic">
                                        <img lazy="loading" class="lazyload" src="/img/404Image.png" data-src="{{$item->image != '[]' ? json_decode($item->image)[0] : ''}}" alt="{{$item->title}}">
                                    </div>
                                    <div class="title3">{{$item->title}}</div>
                                    <div class="price">{{number_format($item->price)}} <span>تومان</span></div>
                                    <div class="addCart">
                                        <i>
                                            <svg class="icon">
                                                <use xlink:href="#cart"></use>
                                            </svg>
                                        </i>
                                        افزودن به سبد خرید
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
