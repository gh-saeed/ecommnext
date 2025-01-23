<section class="allBazarIndex3 width">
    <div class="title">بازارگردی</div>
    <div class="items">
        @foreach($bazar as $item)
            @if(!empty($item->cover))
                <div class="item story" data-story="storyNum{{$item->id}}">
                    @if($item->type)
                        <div class="video-container">
                            <img src="{{$item->cover}}" alt="Poster" class="poster lazyload" data-src="{{$item->cover}}">
                            <video class="video-element lazyload" data-src="{{$item->image}}" loop muted style="display: none">
                                <source data-src="{{$item->image}}" type="video/mp4">
                                مرورگر شما از ویدیو پشتیبانی نمی‌کند.
                            </video>
                        </div>
                    @else
                        <div class="pic">
                            <img lazy="loading" class="lazyload" src="/img/404Image.png" data-src="{{$item->image}}" alt="{{$item->title}}">
                        </div>
                    @endif
                    <div class="title2">{{$item->title}}</div>
                </div>
                <div class="showStory" id="storyNum{{$item->id}}" style="display:none;">
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
            @elseif(!empty($item->name))
                <div class="item">
                    <div>
                        <div>
                            <div class="title2">دسته بندی ویژه</div>
                            <a href="/category/{{$item->slug}}" class="catName">#{{$item->name}}</a>
                            @foreach($item->brands as $val)
                                <a href="/brand/{{$val->slug}}" class="catName">#{{$val->name}}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="ss" style="display:none;"></div>
            @else
                <a href="/product/{{$item->slug}}" class="item">
                    <div class="pic">
                        <img lazy="loading" class="lazyload" src="/img/404Image.png" data-src="{{$item->image != '[]' ? json_decode($item->image)[0] : ''}}" alt="{{$item->title}}">
                        <div class="price">{{number_format($item->price)}}</div>
                    </div>
                    <div class="title2">{{$item->title}}</div>
                </a>
                <div class="ss" style="display:none;"></div>
            @endif
        @endforeach
    </div>
    <div class="body">
        <a href="/discovery">{{$data['more']}}</a>
    </div>
</section>
