@extends('home.master')

@section('title' , 'لیست غرفه‌دارها')
@section('content')
    <div class="allShopsArchive width">
        <div class="tops">
            <h1>لیست غرفه‌دارهای <span>{{\App\Models\Setting::where('key', 'name')->value('value')}}</span></h1>
            <label for="name1">
                <input type="text" id="name1" name="name" placeholder="جستجو نام غرفه ها...">
            </label>
        </div>
        <div class="productContainer">
            <ul></ul>
        </div>
    </div>
@endsection

@section('scriptPage')
    <script>
        var pageN = {!! json_encode(request()->page>=2?request()->page:1, JSON_HEX_TAG) !!};
        let wait = 0;
        let page1 = pageN;
        let done = 0;
        function getField(){
            var searchData = $(".allShopsArchive .tops input[name='name']").val();
            window.history.pushState("", "", '?search='+searchData+'&page='+page1);
            return [searchData,page1];
        }
        function makeHtml(data1){
            $.each(data1, function () {
                $('.allShopsArchive ul').append(
                    `<li>
                            <a href="/@${this.slug}">
                                <figure class="pic">
                                    <img src="${this.profile?this.profile:'/img/user.png'}" alt="${this.name}">
                                </figure>
                                <div class="titles">
                                    <h3>${this.name}</h3>
                                    <div class="stars">
                                        5 / ${this.comments_avg_rate >= 1 ? Math.round(this.comments_avg_rate) : 5}
                                        <div class="rateItem">
                                            <img src="/img/star-on.png" alt="امتیاز">
                                        </div>
                                    </div>
                                </div>
                                <div class="options">
                                    <div class="type">
                                        <div class="name">شهر</div>
                                        <div class="body">${this.city}</div>
                                    </div>
                                    <div class="time">
                                        <div class="name">میزان فعالیت</div>
                                        <div class="body">${this.document_success.created_at.replace('قبل','')}</div>
                                    </div>
                                </div>
                            </a>
                        </li>`
                );
            })
        }
        $(window).scroll(function() {
            if($(window).scrollTop() + $(window).height() + 500 >= $(document).height() && wait == 0 && done == 0) {
                wait = 1;
                ++page1;
                getData();
            }
            function getData(){
                $('.load1').show();
                var field = getField();
                var form = {
                    "_token": "{{ csrf_token() }}",
                    search:field[0],
                    page:field[1],
                };
                $.ajax({
                    url: '/change/vendors',
                    type: "post",
                    data: form,
                    success: function (data) {
                        makeHtml(data.data)
                        if(data.data.length == 0){
                            done = 1;
                            --page1;
                            getField()
                        }
                        setTimeout(function () {
                            wait = 0;
                        },1000)
                        let lazy = lazyload();
                        $("img.lazyload").lazyload();
                        $('.load1').hide();
                    }
                })
            }
        });
        $(document).ready(function () {
            var typingTimer;
            var doneTypingInterval = 500;
            var $input = $(".allShopsArchive .tops input[name='name']");
            $input.on('keyup', function () {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(doneTyping, doneTypingInterval);
            });
            $input.on('keydown', function () {
                clearTimeout(typingTimer);
            });
            getData();
            function doneTyping () {
                $('.allShopsArchive ul li').remove();
                getData();
            }
            function getData(){
                $('.load1').show();
                var field = getField();
                var form = {
                    "_token": "{{ csrf_token() }}",
                    search:field[0],
                    page:field[1],
                };
                $.ajax({
                    url: '/change/vendors',
                    type: "post",
                    data: form,
                    success: function (data) {
                        makeHtml(data.data)
                        if(data.length == 0){
                            done = 1;
                        }
                        setTimeout(function () {
                            wait = 0;
                        },1000)
                        let lazy = lazyload();
                        $("img.lazyload").lazyload();
                        $('.load1').hide();
                    }
                })
            }
        })
    </script>
@endsection
