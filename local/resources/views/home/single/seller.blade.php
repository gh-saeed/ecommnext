@extends('home.master')

@section('title',$user->name)
@section('content')
    <main class="allSellerSingle width">
        <div class="top">
            <div class="detail">
                <div class="profile">
                    <div class="pic">
                        <img src="{{$user->profile??'/img/user.png'}}" alt="{{$user->name}}">
                    </div>
                    <div class="detail2">
                        <div class="name">
                            {{$user->name}}
                            @if($user->isOnline())
                                <span class="active">آنلاین</span>
                            @else
                                <span>آفلاین</span>
                            @endif
                        </div>
                        <div class="city">{{$user->city}}</div>
                    </div>
                </div>
                <div class="options">
                    <div class="share" title="اشتراک گذاری">
                        <i>
                            <svg class="icon">
                                <use xlink:href="#share"></use>
                            </svg>
                        </i>
                        اشتراک گذاری
                    </div>
                    <div class="report" title="گزارش">
                        <i>
                            <svg class="icon">
                                <use xlink:href="#warning"></use>
                            </svg>
                        </i>
                        گزارش
                    </div>
                    <div class="chat">
                        <i>
                            <svg class="icon">
                                <use xlink:href="#chat"></use>
                            </svg>
                        </i>
                        گفت و گو
                    </div>
                </div>
            </div>
            <div class="more">
                <div class="tabs">
                    <div class="tab" data-num="home1">
                        خانه
                    </div>
                    <div class="tab active" data-num="product1">
                        محصولات
                        <div class="num numP">0</div>
                    </div>
                    <div class="tab" data-num="comment1">
                        تجربه مشتریان
                        <div class="num">{{count($comments)}}</div>
                    </div>
                </div>
                <div class="options">
                    <div class="option">
                        <div class="body2">{{$user->documentSuccess?str_replace('قبل','',$user->documentSuccess->created_at):'به تازگی'}}</div>
                        <div class="title2">فعالیت</div>
                    </div>
                    <div class="option">
                        <div class="body2">{{$user->product()->where('status',1)->count()}}</div>
                        <div class="title2">محصول</div>
                    </div>
                    <div class="option">
                        <div class="body2">{{$sellerPays}}</div>
                        <div class="title2">فروش</div>
                    </div>
                    <div class="option">
                        <div class="body2">{{$productRate >= 1 ? $productRate : 5}}</div>
                        <div class="title2">امتیاز</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="homes home1 container1" style="display:none;">
            <div class="about">
                <div class="title">درباره غرفه دار</div>
                <p>{{$user->body}}</p>
            </div>
            <div class="myCategory">
                <div class="title">دسته بندی ها</div>
                <ul>
                    @foreach($sellerCategory as $item)
                        <li>
                            <a href="/category/{{$item->slug}}" title="{{$item->nameSeo}}">
                                <div class="pic">
                                    <img lazy="loading" class="lazyload" src="/img/404Image.png" data-src="{{$item->image}}" alt="{{$item->nameSeo}}">
                                </div>
                                <div class="name">{{$item->name}}</div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="allProductArchive product1 container1">
            <div class="productArchive">
                <div class="showFilterContent" style="display: none">
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
                    @if(count($cats) >= 1)
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
                                @foreach($cats as $item)
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
        </div>
        <div class="comment1 container1" style="display:none;">
            @include('home.single.comment' , ['post' => $user , 'comments' => $comments , 'type' => 1])
        </div>
        <div class="allTicket" style="display:none;">
            <div class="chatContent" id="chatContent3">
                <div class="header">
                    <div class="profile">
                        <div class="pic">
                            <img src="{{$user->profile??'/img/user.png'}}" alt="{{$user->name}}">
                        </div>
                        <div class="name">{{$user->name}}</div>
                    </div>
                    <div class="leftHeader">
                        <i class="cancelChat">
                            <svg class="icon">
                                <use xlink:href="#cancel"></use>
                            </svg>
                        </i>
                    </div>
                </div>
                <div class="body" style="background-image: url('/img/backChat.svg')">
                    <p class="close11">
                        با اتمام گفتگو میتوانید با زدن
                        <span class="closeChats">بستن گفتگو</span>
                        اقدام به قطع گفتگو کنید
                    </p>
                    <div class="messages opp">
                        <div class="text">سلام چطور میتونیم کمکتون کنیم؟</div>
                        <div class="time">{{verta()->format('H:i')}}</div>
                    </div>
                </div>
                @if(auth()->user())
                    <div class="send">
                        <input type="text" name="body" placeholder="پیغام خود را بنویسید">
                        <button>ارسال</button>
                    </div>
                @else
                    <a href="/login" class="loginChat">وارد حساب خود شوید (کلیک کنید)</a>
                @endif
            </div>
        </div>
        @include('home.single.share',['slug'=>url('/@'.$user->slug)])
        @include('home.single.report',['name'=>$user->name,'id'=>$user->id,'type'=>1])
    </main>
@endsection

@section('scriptPage')
    <link rel="stylesheet" href="/css/jquery.raty.css"/>
    <link rel="stylesheet" href="/css/jquery.toast.min.css"/>
    <script src="/js/jquery.raty.js"></script>
    <script src="/js/jquery-ui.min.js"></script>
    <script src="/js/jquery.nstSlider.min.js"></script>
    <script src="/js/jquery.toast.min.js"></script>
    <script>
        $(document).mouseup(function(e)
        {
            let container3 = $(".allCounseling");
            let container4 = $(".showAllShare");
            if (container3.is(e.target) && container3.has(e.target).length == 0)
            {
                $('.allCounseling').hide();
            }
            if (container4.is(e.target) && container4.has(e.target).length == 0)
            {
                $('.showAllShare').hide();
            }
        });
        $(document).ready(function(){
            let userId = {!! json_encode(auth()->user()?auth()->user()->id:0, JSON_HEX_TAG) !!};
            let seller1 = {!! json_encode($user, JSON_HEX_TAG) !!};
            let check = 0;
            var parent = 0;
            let filter = 0;
            if(window.innerWidth <= 800) {
                $('.filterArchive').hide();
                $('.showFilterContent').show();
            }else{
                $('.filterArchive').show();
                $('.showFilterContent').hide();
            }
            $('.allSellerSingle .share').on('click' , function(){
                $('.showAllShare').show();
            })
            $(".allSellerSingle .report,.allCounseling .closeCounseling").click(function (){
                $('.allCounseling').toggle();
            })
            let urlpages = {!! json_encode($urlpages, JSON_HEX_TAG) !!};
            let show = {!! json_encode($getshow, JSON_HEX_TAG) !!};
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
            $(".allTicket .leftHeader .cancelChat,.allSellerSingle .top .chat").click(function (){
                $('.allTicket').toggle();
            })
            $('.tabs .tab').click(function(){
                $('.allSellerSingle .tabs .tab').attr('class','tab');
                $(this).attr('class','tab active');
                $('.allSellerSingle .container1').hide();
                $('.allSellerSingle .'+$(this).attr('data-num')).show();
            })
            let typingTimer;
            let $input = $("input[name='searchData']");
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
            $(".allTicket #chatContent3 .send button").click(function (){
                $(".allTicket #chatContent3 .send button").text('صبر کنید');
                let formData = new FormData();
                formData.append('_token', "{{ csrf_token() }}");
                formData.append('type', 0);
                formData.append('title', 'چت آنلاین');
                formData.append('body', $(".allTicket #chatContent3 .send input[name='body']").val());
                formData.append('parent_id', parent);
                formData.append('customer_id', seller1?seller1:userId);
                formData.append('faq', 1);
                formData.append('status', 1);
                $.ajax({
                    url: "/send-ticket",
                    type: "post",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        if(parent == 0){parent = data.id;}
                        $('.allTicket #chatContent3 .body').animate({ scrollTop: $('.allTicket #chatContent3 .body').height() + 20000 }, 1000);
                        $('.allTicket #chatContent3 .body').append(
                            $(`<div class="messages me new">
                            <div class="text">${data.body}</div>
                            <div class="time">${data.created_at}</div>
                        </div>`)
                        );
                        $(".allTicket #chatContent3 .send input[name='body']").val('');
                        $(".allTicket #chatContent3 .send button").text('ارسال');
                        $(".allTicket #chatContent3 .close11").show();
                        check = 0;
                    },
                    error: function (xhr) {
                        $.toast({
                            heading: 'مشکلی پیش امده', // Optional heading to be shown on the toast
                            icon: 'error', // Type of toast icon
                            showHideTransition: 'fade', // fade, slide or plain
                            allowToastClose: true, // Boolean value true or false
                            hideAfter: 3000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                            stack: 5, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
                            position: 'bottom-left', // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values
                            textAlign: 'left',
                            loader: true,
                            loaderBg: '#c60000',
                        });
                        $(".allTicket #chatContent3 .send button").text('ارسال پیام');
                    }
                });
            })
            $(".allTicket #chatContent3 .closeChats").click(function (){
                $(".allTicket #chatContent3 .closeChats").text('صبر کنید');
                let formData = new FormData();
                formData.append('_token', "{{ csrf_token() }}");
                formData.append('parent_id', parent);
                $.ajax({
                    url: "/close-chat",
                    type: "post",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        parent = 0;
                        $('.allTicket #chatContent3 .body .new').remove();
                        $(".allTicket #chatContent3 .send input[name='body']").val('');
                        $(".allTicket #chatContent3 .closeChats").text('بستن گفتگو');
                        $(".allTicket #chatContent3 .close11").hide();
                        check = 0;
                    },
                    error: function (xhr) {
                        $.toast({
                            heading: 'مشکلی پیش امده', // Optional heading to be shown on the toast
                            icon: 'error', // Type of toast icon
                            showHideTransition: 'fade', // fade, slide or plain
                            allowToastClose: true, // Boolean value true or false
                            hideAfter: 3000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                            stack: 5, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
                            position: 'bottom-left', // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values
                            textAlign: 'left',
                            loader: true,
                            loaderBg: '#c60000',
                        });
                        $(".allTicket #chatContent3 .closeChats").text('بستن گفتگو');
                    }
                });
            })
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
                let field = getField();
                $(".productLists").children(".productList").remove();
                $.ajax({
                    url: urlpages+'?min='+field[1]+'&max='+field[0]+'&show='+field[3]+'&search='+field[2]+'&allSize='+field[5]+'&allColor='+field[4],
                    type: "get",
                    success: function (data) {
                        $('.allLoading').hide();
                        getData(data.data);
                        $('.more .numP').text(data.total);
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
                    let rgx = /(\d+)(\d{3})/;
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
                    let max = $(".priceItem input[name='max_price']").val();
                    let min = $(".priceItem input[name='min_price']").val();
                    let searchData = $("input[name='searchData']").val();
                    let colors1 = [];
                    let sizes1 = [];
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
                    let colors = colors1.length >= 1?colors1.join():'';
                    let sizes = sizes1.length >= 1?sizes1.join():'';
                    if(filter){
                        window.history.pushState("", "", '?min='+min+'&max='+max+'&show='+show+'&search='+searchData+'&allSize='+sizes+'&allColor='+colors);
                    }
                    filter = 1;
                    return [max,min,searchData,show,colors,sizes];
                }
            }
            getMessage1();
            setInterval(getMessage1,20000);
            function getMessage1(){
                if(userId >= 1 && check == 0){
                    let form = {
                        "_token": "{{ csrf_token() }}",
                        'parent':parent,
                        'seller':seller1.id,
                    };
                    $.ajax({
                        url: "/get-online-ticket",
                        type: "post",
                        data: form,
                        success: function (data) {
                            $('.allTicket #chatContent3 .body .new').remove();
                            if(data.length >= 1){
                                if(parent == 0 && data[0].parent_id == 0){
                                    parent = data[0].id;
                                }
                            }else{
                                parent = 0;
                                check = 1;
                            }
                            $.each(data,function (){
                                $('.allTicket #chatContent3 .body').append(
                                    $(`<div class="messages ${userId==this.user_id?'me':''} new">
                            <div class="text">${this.body}</div>
                            <div class="time">${this.created_at}</div>
                        </div>`)
                                );
                                $(".allTicket #chatContent3 .close11").show();
                            })
                            $('.allTicket #chatContent3 .body').animate({ scrollTop: $('.allTicket #chatContent3 .body').height() + 20000 }, 1000);
                        },
                        error: function (xhr) {
                            $(".allTicket #chatContent3 .send button").text('ارسال پیام');
                        }
                    });
                }
            }
        })
    </script>
@endsection

@section('linkPage')
    <link rel="stylesheet" href="/css/jquery.nstSlider.min.css"/>
    <link rel="stylesheet" href="/css/jquery-ui.min.css"/>
@endsection
