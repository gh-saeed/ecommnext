@extends('home.master')

@section('title' , 'بازارگردی')
@section('content')
    <section class="allBazarArchive width">
        <div class="title">
            <div class="title2">بازارگردی</div>
        </div>
        <div class="discover">
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
                                        <video loop autoplay muted>
                                            <source src="{{$item->image}}" type="video/mp4">
                                        </video>
                                    @else
                                        <img lazy="loading" class="lazyload" src="/img/404Image.png" data-src="{{$item->image}}" alt="{{$item->title}}">
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
        </div>
        <div class="load1" style="display: none">صبر کنید...</div>
    </section>
@endsection

@section('scriptPage')
    <script>
        let wait = 0;
        let page1 = 1;
        let done = 0;
        $(window).scroll(function() {
            if($(window).scrollTop() + $(window).height() + 500 >= $(document).height() && wait == 0 && done == 0) {
                wait = 1;
                ++page1;
                getData();
            }
            function getData(){
                $('.load1').show();
                $.ajax({
                    url: '/change/discovery?page='+page1,
                    type: "get",
                    success: function (data) {
                        $.each(data,function (){
                            if(this.cover){
                                $('#gallery').append(
                                    $(`<div class="item story" data-story="storyNum${this.id}">
                                        ${(this.type ? `<video muted loop autoplay><source src="${this.image}" type="video/mp4"></video>`: `<img lazy="loading" class="lazyload" src="/img/404Image.png" data-src="${this.image}" alt="${this.title}">`)}
                                        <div class="title2">${this.title}</div>
                                    </div>
                                    <div class="showStory" id="storyNum${this.id}" style="display:none;">
                                        <div class="show1">
                                            <div class="titleS">
                                                <div class="profile">
                                                    <div class="pic">
                                                        <img src="${this.user.profile?this.user.profile:'/img/user.png'}" alt="${this.user.name}">
                                                    </div>
                                                    <div class="detail">
                                                        <div class="name">${this.user.name}</div>
                                                        <div class="city">از ${this.user.city} (${this.updated_at})</div>
                                                    </div>
                                                </div>
                                                <i>
                                                    <svg class="icon">
                                                        <use xlink:href="#cancel"></use>
                                                    </svg>
                                                </i>
                                            </div>
                                            <div class="body">
                                                ${(this.type ? `<video muted loop autoplay><source src="${this.image}" type="video/mp4"></video>`: `<img lazy="loading" class="lazyload" src="/img/404Image.png" data-src="${this.image}" alt="${this.title}">`)}
                                            </div>
                                            <a href="/${'@'+this.user.slug}" class="send">مشاهده غرفه دار</a>
                                        </div>
                                    </div>`
                                    )
                                )
                            };
                            if(this.name){
                                let brand1 = '';
                                $.each(this.brands,function (){
                                    brand1 += `<a href="/brand/${this.slug}" class="catName">#${this.name}</a>`
                                })
                                $('.items').append(
                                    $(`<div class="item">
                                        <div>
                                            <div>
                                                <div class="title2">دسته بندی ویژه</div>
                                                <a href="/category/${this.slug}" class="catName">#${this.name}</a>
                                                ${brand1}
                                        </div>
                                    </div>
                                </div><div class="ss" style="display:none;"></div>`
                                    )
                                )
                            }
                            if(this.price){
                                $('.items').append(
                                    $(`<a href="/product/${this.slug}" class="item">
                                        <div class="pic">
                                            <img lazy="loading" class="lazyload" src="/img/404Image.png" data-src="${this.image != '[]' ? JSON.parse(this.image)[0] : ''}" alt="${this.title}">
                                            <div class="price">${makePrice(this.price)}</div>
                                        </div>
                                        <div class="title2">${this.title}</div>
                                    </a><div class="ss" style="display:none;"></div>`)
                                )
                            }
                        })
                        if(data.length == 0){
                            done = 1;
                        }
                        setTimeout(function () {
                            wait = 0;
                        },1000)
                        $('.video-container').each(function() {
                            var container = $(this);
                            var video = container.find('.video-element');
                            var poster = container.find('.poster');

                            video.on('canplaythrough', function() {
                                setTimeout(function (){
                                    poster.hide();
                                    video.show();
                                    video[0].play();
                                },3000)
                            });

                            function lazyLoadVideo(video) {
                                var videoSrc = video.find('source').data('src');
                                video.find('source').attr('src', videoSrc);
                                video[0].load();
                            }

                            lazyLoadVideo(video);
                        });
                        let lazy = lazyload();
                        $("img.lazyload").lazyload();
                        $('.load1').hide();
                    }
                })
            }
            function makePrice(price){
                price += '';
                x = price.split('.');
                x1 = x[0];
                x2 = x.length > 1 ? '.' + x[1] : '';
                var rgx = /(\d+)(\d{3})/;
                while (rgx.test(x1)) {
                    x1 = x1.replace(rgx, '$1' + ',' + '$2');
                }
                return x1 + x2;
            }
        });
        $(document).mouseup(function(e)
        {
            var container = $(".showStory");
            if (container.is(e.target) && container.has(e.target).length == 0)
            {
                $('.showStory').hide();
            }
        });
        $(document).ready(function () {
            $(document).on('click',".allBazarArchive .showStory .titleS i",function (){
                $(".showStory").hide();
            })
            $(document).on('click',".allBazarArchive .story",function (){
                $(".showStory").hide();
                $($(this)[0]['parentElement']).find("#"+$(this).attr('data-story')).show();
            })
        })
    </script>
@endsection
