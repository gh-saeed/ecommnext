<div class="allStoryIndex2 width">
    <div class="title2">{{$data['title']}}</div>
    <div dir="rtl" class="swiper storySwiper2">
        <div class="swiper-wrapper">
            @foreach($data['post'] as $item)
                <div class="swiper-slide">
                    <div class="story" data-story="storyNums{{$item->id}}">
                        @if($item->type)
                            <div class="video-container">
                                <img src="{{$item->cover}}" alt="Poster" class="poster lazyload" data-src="{{$item->cover}}">
                                <video class="video-element lazyload" loop muted data-src="{{$item->image}}" style="display: none">
                                    <source data-src="{{$item->image}}" type="video/mp4">
                                    مرورگر شما از ویدیو پشتیبانی نمی‌کند.
                                </video>
                            </div>
                        @else
                            <div class="pic">
                                <img lazy="loading" class="lazyload" src="/img/404Image.png" data-src="{{$item->image}}" alt="{{$item->title}}">
                            </div>
                        @endif
                        <i class="videoI">
                            <svg class="icon">
                                <use xlink:href="#play"></use>
                            </svg>
                        </i>
                    </div>
                    <div class="showStory" id="storyNums{{$item->id}}" style="display:none;">
                        <div class="show1">
                            <div class="titleS">
                                <div class="profile">
                                    <div class="pic">
                                        <img src="{{$item->user->profile??'/img/user.png'}}" alt="{{$item->user->name}}">
                                    </div>
                                    <div class="detail">
                                        <div class="name">{{$item->user->name}}</div>
                                        <div class="city">از {{$item->user->city}} ({{$item->updated_at}})</div>
                                    </div>
                                </div>
                                <i>
                                    <svg class="icon">
                                        <use xlink:href="#cancel"></use>
                                    </svg>
                                </i>
                            </div>
                            <div class="body">
                                @if($item->type)
                                    <div class="video-container">
                                        <img src="{{$item->cover}}" alt="Poster" class="poster lazyload" data-src="{{$item->cover}}">
                                        <video class="video-element lazyload" loop muted data-src="{{$item->image}}" style="display:none;">
                                            <source data-src="{{$item->image}}" type="video/mp4">
                                            مرورگر شما از ویدیو پشتیبانی نمی‌کند.
                                        </video>
                                    </div>
                                @else
                                    <div class="pic">
                                        <img lazy="loading" class="lazyload" src="/img/404Image.png" data-src="{{$item->image}}" alt="{{$item->title}}">
                                    </div>
                                @endif
                            </div>
                            <a href="/{{'@'.$item->user->slug}}" class="send">مشاهده غرفه دار</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</div>
