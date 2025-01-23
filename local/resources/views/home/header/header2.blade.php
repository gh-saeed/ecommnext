<header class="allHeaderIndex2">
    <div class="top width">
        <div class="right">
            <div class="logo">
                <a href="/" class="logo">
                    <img src="{{\App\Models\Setting::where('key' , 'logo')->pluck('value')->first()}}" alt="{{\App\Models\Setting::where('key' , 'name')->pluck('value')->first()}}">
                </a>
            </div>
            <div class="search">
                <form action="/search" method="GET" class="searchData">
                    <label for="search1">
                        <input type="text" id="searching" name="search" placeholder="{{__('messages.search_product')}}">
                        <button id="btnSearchData">
                            <svg class="icon">
                                <use xlink:href="#search"></use>
                            </svg>
                        </button>
                        <i style="display: none" class="searchLoad">
                            <svg class="loading">
                                <use xlink:href="#loading"></use>
                            </svg>
                        </i>
                    </label>
                </form>
            </div>
        </div>
        <div class="left">
            <a href="/profile/chat" class="link">
                <i>
                    <svg class="icon">
                        <use xlink:href="#comment3"></use>
                    </svg>
                </i>
                پیام ها
            </a>
            <a href="/login" class="link">
                <i>
                    <svg class="icon">
                        <use xlink:href="#user2"></use>
                    </svg>
                </i>
                حساب شما
            </a>
            <a href="/cart" class="link">
                <i>
                    <svg class="icon">
                        <use xlink:href="#cart2"></use>
                    </svg>
                </i>
                سبد خرید
                <span id="cartCount">0</span>
            </a>
        </div>
    </div>
    <div class="bot width">
        <div class="right">
            <nav>
                <ul class="nav1">
                    @if(auth()->user())
                        @if(auth()->user()->admin == 1)
                            <li>
                                <a href="/admin" class="link">
                                    <i>
                                        <svg class="icon">
                                            <use xlink:href="#dashboard"></use>
                                        </svg>
                                    </i>
                                    پنل مدیریت
                                </a>
                            </li>
                        @endif
                    @endif
                    <li>
                        <div class="link">
                            <i>
                                <svg class="icon">
                                    <use xlink:href="#align"></use>
                                </svg>
                            </i>
                            دسته بندی
                        </div>
                        <div class="linkCats">
                            @foreach($catHeader as $lists)
                                <div class="linkCat">
                                    <a href="/mother-category/{{$lists->slug}}" name="{{$lists->name}}" title="{{$lists->name}}" class="linkCatTitle">
                                        {{$lists->name}}
                                        <i>
                                            <svg class="icon">
                                                <use xlink:href="#left"></use>
                                            </svg>
                                        </i>
                                    </a>
                                    <div class="linkCatLists">
                                        @foreach($lists->cats as $list)
                                            <div class="linkCatList">
                                                <a href="/category/{{$list->slug}}" name="{{$list->name}}" title="{{$list->name}}" class="active">
                                                    {{$list->name}}
                                                    <i>
                                                        <svg class="icon">
                                                            <use xlink:href="#left"></use>
                                                        </svg>
                                                    </i>
                                                </a>
                                                @foreach($list->cats as $val)
                                                    <a href="/category/{{$val->slug}}" name="{{$val->name}}" title="{{$val->name}}">{{$val->name}}</a>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                            @foreach(\App\Models\Link::where('parent_id',0)->where('type',0)->whereHas('children')->get() as $lists)
                                <div class="linkCat">
                                    <a href="{{$lists->slug}}" name="{{$lists->name}}" title="{{$lists->name}}" class="linkCatTitle">
                                        {{$lists->name}}
                                        <i>
                                            <svg class="icon">
                                                <use xlink:href="#left"></use>
                                            </svg>
                                        </i>
                                    </a>
                                    <div class="linkCatLists">
                                        @foreach(\App\Models\Link::where('parent_id',$lists->id)->get() as $list)
                                            <div class="linkCatList">
                                                <a href="{{$list->slug}}" name="{{$list->name}}" title="{{$list->name}}" class="active">
                                                    {{$list->name}}
                                                    <i>
                                                        <svg class="icon">
                                                            <use xlink:href="#left"></use>
                                                        </svg>
                                                    </i>
                                                </a>
                                                @foreach(\App\Models\Link::where('parent_id',$list->id)->get() as $val)
                                                    <a href="{{$val->slug}}" name="{{$val->name}}" title="{{$val->name}}">{{$val->name}}</a>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </li>
                    @foreach($links as $item)
                        <li>
                            <a href="{{$item->slug}}" class="link">
                                {{$item->name}}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>
        </div>
    </div>
    <div class="categoryHeaderResponsive">
        <div class="title">
            <span>دسترسی سریع</span>
            <i id="btnShowMenu">
                <svg class="icon">
                    <use xlink:href="#cancel"></use>
                </svg>
            </i>
        </div>
        <ul class="allCats">
            <li>
                <div class="allCatsTitle">
                    <a href="/login" name="ورود / ثبت نام" title="ورود / ثبت نام">ورود / ثبت نام</a>
                </div>
            </li>
            @foreach($catHeader as $lists)
                <li>
                    <div class="allCatsTitle">
                        <a href="/category/{{$lists->slug}}" name="{{$lists->name}}" title="{{$lists->name}}">{{$lists->name}}</a>
                        <i>
                            <svg class="icon">
                                <use xlink:href="#down"></use>
                            </svg>
                        </i>
                    </div>
                    <ul class="allCatsList">
                        @foreach($lists->cats as $list)
                            <li>
                                <div class="allCatsTitle">
                                    <a href="/category/{{$list->slug}}" name="{{$list->name}}" title="{{$list->name}}">{{$list->name}}</a>
                                </div>
                                <ul>
                                    @foreach($list->cats as $item)
                                        <li>
                                            <div class="allCatsTitle">
                                                <a href="/category/{{$item->slug}}" name="{{$item->name}}" title="{{$item->name}}">{{$item->name}}</a>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
            @if(\App\Models\Link::where('parent_id',0)->where('type',0)->whereHas('children')->count() >= 1)
                @foreach(\App\Models\Link::where('parent_id',0)->where('type',0)->whereHas('children')->get() as $lists1)
                    <li>
                        <div class="allCatsTitle">
                            <a href="{{$lists1->slug}}" name="{{$lists1->name}}" title="{{$lists1->name}}">{{$lists1->name}}</a>
                            <i>
                                <svg class="icon">
                                    <use xlink:href="#down"></use>
                                </svg>
                            </i>
                        </div>
                        <ul class="allCatsList">
                            @foreach(\App\Models\Link::where('parent_id',$lists1->id)->get() as $list)
                                <li>
                                    <div class="allCatsTitle">
                                        <a href="{{$list->slug}}" name="{{$list->name}}" title="{{$list->name}}">{{$list->name}}</a>
                                    </div>
                                    <ul>
                                        @foreach(\App\Models\Link::where('parent_id',$list->id)->get() as $item)
                                            <li>
                                                <div class="allCatsTitle">
                                                    <a href="{{$item->slug}}" name="{{$item->name}}" title="{{$item->name}}">{{$item->name}}</a>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            @endif
            @foreach(\App\Models\Link::where('parent_id',0)->where('type',0)->doesntHave('children')->get() as $lists)
                <li>
                    <div class="allCatsTitle">
                        <a href="{{$lists->slug}}" name="{{$lists->name}}" title="{{$lists->name}}">
                            {{$lists->name}}
                        </a>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</header>

<script>
    $(document).mouseup(function(e)
    {
        var container2 = $(".searchData");
        if (!container2.is(e.target) && container2.has(e.target).length == 0)
        {
            $('.searchData ul').remove();
        }
    });
    $(document).ready(function (){
        var arz1 = {!! json_encode(__('messages.arz'), JSON_HEX_TAG) !!};
        $('.allHeaderIndex2 .allCats li').on('click' ,function(){
            $($(this).children()[1]).toggle();
        })
        $('.resAlign,.allHeaderIndex2 .categoryHeaderResponsive #btnShowMenu').on('click' ,function(){
            $('.allHeaderIndex2 .categoryHeaderResponsive').toggle();
        })
        var typingTimer;
        var doneTypingInterval = 500;
        var $input = $('.allHeaderIndex2  #searching');
        $input.on('keyup', function () {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(doneTyping, doneTypingInterval);
        });
        $input.on('keydown', function () {
            clearTimeout(typingTimer);
        });
        function doneTyping () {
            $('.allHeaderIndex2  form ul').remove();
            if($(".allHeaderIndex2  input[name='search']").val().length >= 1){
                $('.allHeaderIndex2  .searchLoad').show();
                $('.allHeaderIndex2  #btnSearchData').hide();
                var form = {
                    "_token": "{{ csrf_token() }}",
                    'search' : $(".allHeaderIndex2  input[name='search']").val(),
                };
                $.ajax({
                    url: "/search",
                    type: "post",
                    data: form,
                    success: function (data) {
                        $('.allHeaderIndex2  .searchLoad').hide();
                        $('.allHeaderIndex2  #btnSearchData').show();
                        $('.allHeaderIndex2  form').append(
                            '<ul></ul>'
                        );
                        $.each(data,function(){
                            $('.allHeaderIndex2  form ul').append(
                                '<li>'+
                                '<a href="/product/'+this.slug+'">'+
                                '<div class="pic">'+
                                '<img src="'+JSON.parse(this.image)[0]+'" alt="'+this.title+'">'+
                                '</div>'+
                                '<div class="subject">'+
                                '<h3>'+this.title+'</h3>'+
                                '<h5>'+this.product_id+'</h5>'+
                                '</div>'+
                                '<div class="price">'+makePrice(this.price) + arz1 +' </div>'+
                                '</a>'+
                                '</li>'
                            );
                        })
                    },
                });
            }
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
    })
</script>
