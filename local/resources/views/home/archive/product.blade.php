@extends('home.master')

@section('title' , $archive->nameSeo)
@section('content')
    <main class="allProductArchive width">
        <section class="address" aria-label="Breadcrumb">
            <i>
                <svg class="icon">
                    <use xlink:href="#location"></use>
                </svg>
            </i>
            <a href="/">خانه</a>
            <a href="#">{{$archive->name}}</a>
        </section>
        <div class="titleBox">
            <div class="name">{{$archive->name}} ({{verta()->format('%d %B')}})</div>
            @if(count($cats) >= 1)
                <ul>
                    @foreach($cats->take(3) as $item)
                        <li><a href="/category/{{$item->slug}}">{{$item->name}}</a></li>
                    @endforeach
                </ul>
            @endif
        </div>
        <div class="productArchive">
            <div class="showFilterContent" style="display:none;">
                مشاهده فیلتر ها
                <i>
                    <svg class="icon">
                        <use xlink:href="#down"></use>
                    </svg>
                </i>
            </div>
            <div class="filterArchive">
                <div class="showFilterContent" style="display:none;">
                    بستن فیلتر ها
                    <i>
                        <svg class="icon">
                            <use xlink:href="#down"></use>
                        </svg>
                    </i>
                </div>
                <div class="filterItems">
                    <div class="filterTitle">
                        <i>
                            <svg class="icon">
                                <use xlink:href="#filter"></use>
                            </svg>
                        </i>
                        <span>ترتیب براساس</span>
                    </div>
                    <ul class="filterCategories productOrder">
                        <li class="0">
                            @if($getshow == 0)
                                <span class="active">جدیدترین</span>
                            @else
                                <span class="unActive">جدیدترین</span>
                            @endif
                        </li>
                        <li class="1">
                            @if($getshow == 1)
                                <span class="active">پربازدیدترین</span>
                            @else
                                <span class="unActive">پربازدیدترین</span>
                            @endif
                        </li>
                        <li class="2">
                            @if($getshow == 2)
                                <span class="active">پرفروشترین</span>
                            @else
                                <span class="unActive">پرفروشترین</span>
                            @endif
                        </li>
                        <li class="3">
                            @if($getshow == 3)
                                <span class="active">محبوب ترین</span>
                            @else
                                <span class="unActive">محبوب ترین</span>
                            @endif
                        </li>
                        <li class="4">
                            @if($getshow == 4)
                                <span class="active">ارزان ترین</span>
                            @else
                                <span class="unActive">ارزان ترین</span>
                            @endif
                        </li>
                        <li class="5">
                            @if($getshow == 5)
                                <span class="active">گران ترین</span>
                            @else
                                <span class="unActive">گران ترین</span>
                            @endif
                        </li>
                    </ul>
                </div>
                <div class="filterItems">
                    <div class="filterTitle">
                        <i>
                            <svg class="icon">
                                <use xlink:href="#filter"></use>
                            </svg>
                        </i>
                        <span>جستجو</span>
                    </div>
                    <div class="filterSearch">
                        <label for="filterSearch">
                            <input id="filterSearch" type="text" name="searchData" value="{{$getsearch}}" placeholder="فیلتر جستجو">
                        </label>
                    </div>
                </div>
                <div class="filterItems">
                    <div class="filterTitle">
                        <i>
                            <svg class="icon">
                                <use xlink:href="#filter"></use>
                            </svg>
                        </i>
                        <span>فیلتر قیمت</span>
                    </div>
                    <div class="priceItems">
                        <div class="nstSlider" data-range_min="{{$minPrice}}" data-range_max="{{$maxPrice}}"
                             data-cur_min="{{$getshowmin}}"    data-cur_max="{{$getshowmax}}">

                            <div class="bar"></div>
                            <div class="leftGrip"></div>
                            <div class="rightGrip"></div>
                        </div>
                        <div class="priceItem">
                            <label for="min_price">از</label>
                            <input type="number" name="min_price" class="min_price"/>
                        </div>
                        <div class="priceItem">
                            <label for="max_price">تا</label>
                            <input type="number" name="max_price" class="max_price"/>
                        </div>
                        <button class="priceFilter">فیلتر قیمت</button>
                    </div>
                </div>
                @if(count($cats) >= 5)
                <div class="filterItems">
                    <div class="filterTitle">
                        <i>
                            <svg class="icon">
                                <use xlink:href="#filter"></use>
                            </svg>
                        </i>
                        <span>دسته بندی ها</span>
                    </div>
                    <div class="filterCategories">
                        @foreach($cats->slice(4,30) as $item)
                            <a href="/category/{{$item->slug}}">
                                <span>{{$item->name}}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif
                @if(count($brands) >= 1)
                    <div class="filterItems">
                        <div class="filterTitle">
                            <i>
                                <svg class="icon">
                                    <use xlink:href="#filter"></use>
                                </svg>
                            </i>
                            <span>برند ها</span>
                        </div>
                        <div class="filterCategories">
                            @foreach($brands as $item)
                                <a href="/brand/{{$item->slug}}" title="{{$item->nameSeo}}"><span>{{$item->name}}</span></a>
                            @endforeach
                        </div>
                    </div>
                @endif
                @if(count($color) >= 1)
                    <div class="filterItems">
                        <div class="filterTitle">
                            <i>
                                <svg class="icon">
                                    <use xlink:href="#filter"></use>
                                </svg>
                            </i>
                            <span>{{__('messages.color_product')}}</span>
                        </div>
                        <div class="filterContainer" id="colors">
                            @foreach($color as $item)
                                <div class="allProductArchiveFiltersItem">
                                    <label for="{{$item}}">
                                        <input id="{{$item}}" name="color" type="checkbox">
                                        {{$item}}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                @if(count($size) >= 1)
                    <div class="filterItems">
                        <div class="filterTitle">
                            <i>
                                <svg class="icon">
                                    <use xlink:href="#filter"></use>
                                </svg>
                            </i>
                            <span>{{__('messages.size_product')}}</span>
                        </div>
                        <div class="filterContainer" id="sizes">
                            @foreach($size as $item)
                                <div class="allProductArchiveFiltersItem">
                                    <label for="{{$item}}">
                                        <input id="{{$item}}" name="size" type="checkbox">
                                        {{$item}}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            <div class="productContainer">
                <div class="productLists"></div>
            </div>
        </div>
        <div class="description">
            <h1 class="title1">{{$archive->name}}</h1>
            <div><p>{!! $archive->body !!}</p></div>
        </div>
    </main>
@endsection

@section('scriptPage')
    <script src="/js/jquery-ui.min.js"></script>
    <script src="/js/jquery.nstSlider.min.js"></script>
    <link rel="stylesheet" href="/css/jquery.nstSlider.min.css"/>
    <link rel="stylesheet" href="/css/jquery-ui.min.css"/>
    <script>
        $(document).ready(function(){
            if(window.innerWidth <= 800) {
                $('.filterArchive').hide();
                $('.showFilterContent').show();
            }else{
                $('.filterArchive').show();
                $('.showFilterContent').hide();
            }
            let filtered = 0;
            var urlpages = {!! json_encode($urlpages, JSON_HEX_TAG) !!};
            var show = {!! json_encode($getshow, JSON_HEX_TAG) !!};
            $('.nstSlider').nstSlider({
                "left_grip_selector": ".leftGrip",
                "right_grip_selector": ".rightGrip",
                "value_bar_selector": ".bar",
                "value_changed_callback": function(cause, leftValue, rightValue) {
                    $(this).parent().find('.min_price').val(leftValue);
                    $(this).parent().find('.max_price').val(rightValue);
                }
            });
            $('.showFilterContent').click(function(){
                $('.filterArchive').toggle();
            })
            var typingTimer;
            var $input = $("input[name='searchData']");
            $input.on('keyup', function () {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(doneTyping, 1000);
            });
            $input.on('keydown', function () {
                clearTimeout(typingTimer);
            });
            function doneTyping () {
                getUrl();
            }
            $(document).on('keypress',function(e) {
                if(e.which == 13) {
                    getUrl();
                }
            });
            $("#colors input[name='color']").on('change',function (){
                getUrl();
            })
            $(".priceItems .priceFilter").click(function (){
                getUrl();
            })
            $("#sizes input[name='size']").on('change',function (){
                getUrl();
            })
            $(".productOrder li").on('click',function (){
                show = $(this).attr('class');
                $(".productOrder li .active").attr('class' , 'unActive')
                $(this).children('span').attr('class' , 'active');
                getUrl();
            })
            getUrl();
            function getUrl(){
                $(".allPaginateHome").remove();
                var field = getField();
                $(".productLists").children(".productList").remove();
                $.ajax({
                    url: urlpages+'?min='+field[1]+'&max='+field[0]+'&show='+field[3]+'&search='+field[2]+'&allSize='+field[5]+'&allColor='+field[4],
                    type: "get",
                    success: function (data) {
                        $('.allLoading').hide();
                        getData(data.data);
                        $('.left .top span').text(data.total);
                        $('.productContainer').append(
                            $(
                                (data.last_page >= 2 ?
                                    '<div class="allPaginateHome">'+
                                    '<div class="pages"></div>'+
                                    '</div>'
                                    : '')
                            )
                        );
                        getLink(data.links);
                    },
                });
                $(document).on('click', '.allPaginateHome .pages div', function(){
                    $(".productLists").children(".productList").remove();
                    $(".allPaginateHome").remove();
                    window.history.pushState("", "", $(this).attr('name'));
                    $.ajax({
                        url: $(this).attr('name'),
                        type: "get",
                        success: function (data) {
                            getData(data.data)
                            $('.productContainer').append(
                                $(
                                    (data.last_page >= 2 ?
                                        '<div class="allPaginateHome">'+
                                        '<div class="pages"></div>'+
                                        '</div>'
                                        : '')
                                )
                            );
                            getLink(data.links);
                        }
                    })
                });
                function getData(data){
                    $.each(data, function () {
                        $('.productLists').append(
                            $(
                                '<div class="productList">'+
                                '<a href="/product/'+this.slug+'" title="'+this.title+'" name="'+this.title+'">'+
                                '<article>'+
                                (this.image != '[]' ? '<figure class="pic"><img class="zoom lazyload" lazy="loading" src="/img/404Image.png" data-src="'+JSON.parse(this.image)[0]+'" alt="'+this.title+'"></figure>': '')+
                                '<div class="title2">'+this.title+'</div>'+
                                '<div class="seller">'+this.user.name+'</div>'+
                                '<div class="price">'+
                                (this.off ? '<s>'+makePrice(this.offPrice)+'</s>': '')+
                                '<div class="price1">'+makePrice(this.price)+'</div></div>'+
                                (this.count >= 1 ? '<div class="addCart"><i><svg class="icon"><use xlink:href="#cart"></use></svg></i>افزودن به سبد خرید </div>': '<div class="addCart empty"><i><svg class="icon"><use xlink:href="#cart"></use></svg></i>ناموجود </div>')+
                                '</article>'+
                                '</a>'+
                                '</div>'
                            )
                        );
                    })
                    let lazy = lazyload();
                    $("img.lazyload").lazyload();
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
                function getLink(links){
                    $.each(links , function() {
                        if (this.label == 'قبلی' && this.url != null){
                            $('.allPaginateHome .pages').append(
                                '<div class="' + this.active + '" id="' + this.label + '" name="'+this.url+'"><svg class="icon"><use xlink:href="#right"></use></svg></div>'
                            )
                        }
                        if (this.label == 'بعدی' && this.url != null){
                            $('.allPaginateHome .pages').append(
                                '<div class="' + this.active + '" id="' + this.label + '" name="'+this.url+'"><svg class="icon"><use xlink:href="#left"></use></svg></div>'
                            );
                        }
                        if (this.label != 'بعدی' && this.label != 'قبلی' && this.url != null){
                            $('.allPaginateHome .pages').append(
                                '<div class="' + this.active + '" id="' + this.label + '" name="'+this.url+'">'+this.label+'</div>'
                            );
                        }
                    })
                }
                function getField(){
                    var max = $(".priceItem input[name='max_price']").val();
                    var min = $(".priceItem input[name='min_price']").val();
                    var searchData = $("input[name='searchData']").val();
                    var colors1 = [];
                    var sizes1 = [];
                    $.each($("#colors input[name='color']") , function (){
                        if(this.checked){
                            colors1.push(this.id);
                        }
                    });
                    $.each($("#sizes input[name='size']") , function (){
                        if(this.checked){
                            sizes1.push(this.id);
                        }
                    });
                    var colors = colors1.length >= 1?colors1.join():'';
                    var sizes = sizes1.length >= 1?sizes1.join():'';
                    if(filtered){
                        window.history.pushState("", "", '?min='+min+'&max='+max+'&show='+show+'&search='+searchData+'&allSize='+sizes+'&allColor='+colors);
                    }
                    filtered = 1;
                    return [max,min,searchData,show,colors,sizes];
                }
            }
        })
    </script>
@endsection
