@extends('home.master')

@section('title',$user->name)
@section('content')
    <main class="allIndex">
        <h1 class="hiddenSeo">{{$user->name}}</h1>
        <h2 class="hiddenSeo">{{$user->body}}</h2>
        @if(count($widget))
            @foreach($widget as $item)
                @if($item['name'] == 'استوری')
                    <div class="myWidget">
                        @include('home.index.storyIndex' , ['data' => $item])
                    </div>
                @elseif($item['name'] == 'استوری2')
                    <div class="myWidget">
                        @include('home.index.storyIndex2' , ['data' => $item])
                    </div>
                @elseif($item['name'] == 'بلاگ2')
                    <div class="myWidget">
                        @include('home.index.blogIndex2' , ['data' => $item])
                    </div>
                @elseif($item['name'] == 'تبلیغ ساده')
                    <div class="myWidget">
                        @include('home.index.adIndex' , ['data' => $item])
                    </div>
                @elseif($item['name'] == 'تبلیغ بزرگ')
                    <div class="myWidget">
                        @include('home.index.bigIndex2' , ['data' => $item])
                    </div>
                @elseif($item['name'] == 'تک غرفه')
                    <div class="myWidget">
                        @include('home.index.sellerDetail' , ['data' => $item])
                    </div>
                @elseif($item['name'] == 'لیست غرفه')
                    <div class="myWidget">
                        @include('home.index.sellerIndex' , ['data' => $item])
                    </div>
                @elseif($item['name'] == 'لیست غرفه')
                    <div class="myWidget">
                        @include('home.index.sellerIndex' , ['data' => $item])
                    </div>
                @elseif($item['name'] == 'تک غرفه')
                    <div class="myWidget">
                        @include('home.index.sellerDetail' , ['data' => $item])
                    </div>
                @elseif($item['name'] == 'بازارگردی')
                    <div class="myWidget">
                        @include('home.index.bazarIndex2' , ['data' => $item])
                    </div>
                @elseif($item['name'] == 'معرفی سایت')
                    <div class="myWidget">
                        @include('home.index.bigIndex' , ['data' => $item])
                    </div>
                @elseif($item['name'] == 'دسته بندی')
                    <div class="myWidget">
                        @include('home.index.category' , ['data' => $item])
                    </div>
                @elseif($item['name'] == 'دسته بندی2')
                    <div class="myWidget">
                        @include('home.index.category2' , ['data' => $item])
                    </div>
                @elseif($item['name'] == 'لحظه ای')
                    <div class="myWidget">
                        @include('home.index.momentProduct' , ['data' => $item,'moment' => $moment])
                    </div>
                @elseif($item['name'] == 'محصولات اسلایدری')
                    <div class="myWidget">
                        @include('home.index.productList' , ['data' => $item])
                    </div>
                @elseif($item['name'] == 'بلاگ')
                    <div class="myWidget">
                        @include('home.index.blogIndex' , ['data' => $item])
                    </div>
                @endif
            @endforeach
        @else
            <div class="emptyWidget">
                <i>
                    <svg class="icon">
                        <use xlink:href="#home2"></use>
                    </svg>
                </i>
                <p>صفحه اختصاصی طراحی نشده :(</p>
                <a href="/{{'@'.$user->slug}}">مشاهده اطلاعات غرفه دار</a>
            </div>
        @endif
    </main>
@endsection

@section('linkPage')
    <link rel="stylesheet" href="/css/swiper.min.css">
    <script src="/js/swiper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js" async></script>
@endsection

@section('scriptPage')
    <script src="/js/owl.carousel.min.js"></script>
    <link rel="stylesheet" href="/css/owl.carousel.min.css"/>
    <script src="/js/jquery.cookie.js"></script>
    <script>
        $(document).mouseup(function(e)
        {
            var container = $(".showStory");
            if (container.is(e.target) && container.has(e.target).length == 0)
            {
                $('.showStory').hide();
                $(".allStoryIndex2 .swiper-wrapper").css({'transform': 'translate3d(0px,0,0)','z-index': '0'})
            }
        });
        $(document).ready(function () {
            $('.AllPopUpIndex').click(function(){
                this.remove();
                $.cookie('popUp' , 1);
            })
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
            const obj = document.querySelector("#gallery");
            if(obj){
                const time = 10000;

                function animStart() {
                    if (obj.classList.contains("active") == false) {
                        obj.classList.add("active");
                        setTimeout(() => {
                            animEnd();
                        }, time);
                    }
                }

                function animEnd() {
                    obj.classList.remove("active");
                    obj.offsetWidth;
                }

                document.addEventListener("scroll", function () {
                    animStart();
                });
                window.addEventListener("resize", animStart);
                animStart();
            }
            $(".showStory .titleS i").click(function (){
                $(".showStory").hide();
                $(".allStoryIndex2 .swiper-wrapper,.allStoryIndex .swiper-wrapper").css({'transform': 'translate3d(0px,0,0)','z-index': '0'})
            })
            $(".allBazarIndex2 .story,.allBazarIndex3 .story,.allStoryIndex .story,.allStoryIndex2 .story").click(function (){
                $(".showStory").hide();
                $($(this)[0]['parentElement']).find("#"+$(this).attr('data-story')).show();
                $(".allStoryIndex2 .swiper-wrapper,.allStoryIndex .swiper-wrapper").css({'transform': 'unset','z-index': '200'})
            })
            $('.slider-moment2').owlCarousel({
                loop:true,
                rtl:true,
                lazyLoad: true,
                touchDrag: false,
                mouseDrag: false,
                pullDrag: false,
                items:1,
                autoplay:true,
                dots:false,
                autoplayTimeout:10000,
            })
            new Swiper(".detailSwiper", {
                initialSlide: 1,
                effect: "coverflow",
                grabCursor: true,
                centeredSlides: true,
                slidesPerView: "auto",
                coverflowEffect: {
                    rotate: 0,
                    stretch: 0,
                    depth: 300,
                    modifier: 1,
                    slideShadows: true,
                },
            });
            new Swiper(".sellerSwiper1", {
                breakpoints: {
                    100: {
                        slidesPerView: 1,
                    },
                    1024: {
                        slidesPerView: 2,
                        spaceBetween: 20,
                    },
                },
            });
            new Swiper(".swiperBig2", {
                slidesPerView: 1,
                pagination: {
                    el: ".swiper-pagination",
                },
                autoplay: {
                    delay: 1500,
                    pauseOnMouseEnter: true,
                },
            });
            new Swiper(".storySwiper", {
                spaceBetween: 10,
                breakpoints: {
                    100: {
                        slidesPerView: 2,
                    },
                    1024: {
                        slidesPerView: 6,
                    },
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
            });
            new Swiper(".momentSwiper", {
                spaceBetween: 10,
                breakpoints: {
                    100: {
                        slidesPerView: 2,
                    },
                    1024: {
                        slidesPerView: 4,
                    },
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
            });
            new Swiper(".listSwiper", {
                spaceBetween: 10,
                breakpoints: {
                    100: {
                        slidesPerView: 2,
                    },
                    1024: {
                        slidesPerView: 5,
                    },
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
            });
            new Swiper(".storySwiper2", {
                spaceBetween: 15,
                breakpoints: {
                    100: {
                        slidesPerView: 2.3,
                    },
                    1024: {
                        slidesPerView: 6,
                    },
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
            });
            new Swiper(".sellerSwiper2", {
                spaceBetween: 10,
                breakpoints: {
                    100: {
                        slidesPerView: 2,
                    },
                    1024: {
                        slidesPerView: 3,
                    },
                },
            });
            new Swiper(".blogSwiper", {
                spaceBetween: 10,
                breakpoints: {
                    100: {
                        slidesPerView: 2,
                    },
                    1024: {
                        slidesPerView: 4,
                    },
                    1700: {
                        slidesPerView: 5,
                    },
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
            });
            new Swiper(".blogSwiper2", {
                spaceBetween: 15,
                breakpoints: {
                    100: {
                        slidesPerView: 1.5,
                    },
                    1024: {
                        slidesPerView: 4,
                    },
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
            });
            new Swiper(".mySwiper", {
                breakpoints: {
                    100: {
                        slidesPerView: 2,
                    },
                    1024: {
                        slidesPerView: 10,
                    },
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
            });
            new Swiper(".catSwiper", {
                spaceBetween: 10,
                breakpoints: {
                    100: {
                        slidesPerView: 2,
                    },
                    1024: {
                        slidesPerView: 10,
                    },
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
            });
            new Swiper(".category2", {
                spaceBetween: 1,
                breakpoints: {
                    100: {
                        slidesPerView: 2,
                    },
                    1024: {
                        slidesPerView: 8,
                    },
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
            });
            new Swiper(".swiperBig", {
                effect: "cube",
                grabCursor: true,
                loop: true,
                speed: 1000,
                cubeEffect: {
                    shadow: false,
                    slideShadows: true,
                    shadowOffset: 10,
                    shadowScale: 0.94,
                },
                autoplay: {
                    delay: 1500,
                    pauseOnMouseEnter: true,
                },
            });
        })
    </script>
@endsection

