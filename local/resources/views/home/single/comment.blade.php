<div class="allComment" id="comment">
    <div class="title2">دیدگاه</div>
    <div class="btnComment">
        <div class="body1">شما هم می توانید تجربیات خود را با کاربران دیگر در میان بگذارید.</div>
        @if(auth()->user())
        <div class="showAdd" id="showAdd">
            <i>
                <svg class="icon">
                    <use xlink:href="#comment2"></use>
                </svg>
            </i>
            <button>افزودن نظر</button>
        </div>
        @else
            <a href="/login" class="showAdd" id="showAdd">
                <i>
                    <svg class="icon">
                        <use xlink:href="#user"></use>
                    </svg>
                </i>
                <button>ثبت نام / ورود</button>
            </a>
        @endif
    </div>
    <div class="addComments">
        <div class="addComment">
            <div class="rates">
                <h4>امتیاز دهید* :</h4>
                <div class="rateItem">
                    <div id="rate"></div>
                    <input id="rateData" type="hidden" name="rate" />
                </div>
                <div id="validation-rate"></div>
            </div>
            <div class="sendCommentItem">
                <label for="title">عنوان*</label>
                <input type="text" id="title" placeholder="عنوان را وارد کنید ..." name="title">
                <div id="validation-title"></div>
            </div>
            <div class="sendCommentItem" id="goodContainer">
                <div class="sendCommentItemTitle">
                    <i>
                        <svg class="icon">
                            <use xlink:href="#circle"></use>
                        </svg>
                    </i>
                    <label>نقاط قوت</label>
                </div>
                <label for="good">
                    <input type="text" id="good" placeholder="بعد از نوشتن روی + بزنید" name="good">
                    <i id="goodBtn">
                        <svg class="icon">
                            <use xlink:href="#plus2"></use>
                        </svg>
                    </i>
                </label>
            </div>
            <div class="sendCommentItem" id="badContainer">
                <div class="sendCommentItemTitle">
                    <i>
                        <svg class="icon">
                            <use xlink:href="#circle"></use>
                        </svg>
                    </i>
                    <label>نقاط ضعف</label>
                </div>
                <label>
                    <input type="text" id="bad" placeholder="بعد از نوشتن روی + بزنید" name="bad">
                    <i id="badBtn">
                        <svg class="icon">
                            <use xlink:href="#plus2"></use>
                        </svg>
                    </i>
                </label>
            </div>
            <div class="sendCommentItem">
                <label for="bodyText">توضیحات*</label>
                <textarea name="body" id="bodyText" placeholder="توضیحات را وارد کنید"></textarea>
                <div id="validation-body"></div>
            </div>
            <div class="allCommentButtons">
                <button id="createComment">ارسال</button>
                <button id="cancelComment">انصراف</button>
            </div>
        </div>
    </div>
    <div class="showComments">
        @if(count($comments) >= 1)
            @foreach($comments as $item)
                <div class="getCommentItem">
                    <div class="rightComment">
                        <div class="topRight">
                            <h4>{{$item->user->name}}</h4>
                            <div class="rates">
                                <div class="rateItem">
                                    @if($item->rate >= 1)
                                        <img src="/img/star-on.png" alt="ستاره کامل">
                                    @elseif($item->rate == .5)
                                        <img src="/img/star-half.png" alt="نصف ستاره">
                                    @else
                                        <img src="/img/star-off.png" alt="بدون ستاره">
                                    @endif
                                </div>
                                <div class="rateItem">
                                    @if($item->rate >= 2)
                                        <img src="/img/star-on.png" alt="ستاره کامل">
                                    @elseif($item->rate == 1.5)
                                        <img src="/img/star-half.png" alt="نصف ستاره">
                                    @else
                                        <img src="/img/star-off.png" alt="بدون ستاره">
                                    @endif
                                </div>
                                <div class="rateItem">
                                    @if($item->rate >= 3)
                                        <img src="/img/star-on.png" alt="ستاره کامل">
                                    @elseif($item->rate == 2.5)
                                        <img src="/img/star-half.png" alt="نصف ستاره">
                                    @else
                                        <img src="/img/star-off.png" alt="بدون ستاره">
                                    @endif
                                </div>
                                <div class="rateItem">
                                    @if($item->rate >= 4)
                                        <img src="/img/star-on.png" alt="ستاره کامل">
                                    @elseif($item->rate == 3.5)
                                        <img src="/img/star-half.png" alt="نصف ستاره">
                                    @else
                                        <img src="/img/star-off.png" alt="بدون ستاره">
                                    @endif
                                </div>
                                <div class="rateItem">
                                    @if($item->rate >= 5)
                                        <img src="/img/star-on.png" alt="ستاره کامل">
                                    @elseif($item->rate == 4.5)
                                        <img src="/img/star-half.png" alt="نصف ستاره">
                                    @else
                                        <img src="/img/star-off.png" alt="بدون ستاره">
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="time">{{$item->created_at}}</div>
                    </div>
                    <div class="leftComment">
                        <div class="allCommentTitle">
                            {{$item->title}}
                            @if($type == 0)
                                @if(\App\Models\PayMeta::where('user_id',$item->user->id)->where('status',100)->where('product_id',$post->id)->count())
                                    <span>خریدار</span>
                                @else
                                    <span class="unActive">خریداری نکرده</span>
                                @endif
                            @endif
                        </div>
                        <div class="allCommentBody">
                            <p>{{$item->body}}</p>
                        </div>
                        <div class="getCommentDatas">
                            @if($item->good && $item->good != '[]')
                                <div class="getCommentData">
                                    <h5>نقاط قوت</h5>
                                    <div class="items">
                                        @foreach(json_decode($item->good) as $value)
                                            <div class="item">
                                                <i>
                                                    <svg class="icon">
                                                        <use xlink:href="#circle"></use>
                                                    </svg>
                                                </i>
                                                {{$value}}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            @if($item->bad && $item->bad != '[]')
                                <div class="getCommentData bad">
                                    <h5>نقاط ضعف</h5>
                                    <div class="items">
                                        @foreach(json_decode($item->bad) as $value)
                                            <div class="item">
                                                <i>
                                                    <svg class="icon">
                                                        <use xlink:href="#circle"></use>
                                                    </svg>
                                                </i>
                                                {{$value}}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

<script>
    $(document).ready(function(){
        var post = {!! $post->toJson() !!};
        var type1 = {!! json_encode($type, JSON_HEX_TAG) !!};
        $('.addComments').hide();
        var rate = '';
        $('#rate').raty({
            half: true,
            target: '#rateData',
            click: function(score, evt) {
                rate=score;
            }
        });
        $('#showAdd,.comment .bot').click(function(){
            $('.addComments').toggle();
            $('.btnComment').toggle();
            $('.showComments').toggle();
        })
        $('#cancelComment').click(function(){
            $('.addComments').toggle();
            $('.btnComment').toggle();
            $('.showComments').toggle();
        })
        $('#goodBtn').click(function(){
            if($("#good").val() != ''){
                $('#goodContainer').append(
                    $('<span>'+$("#good").val()+'<i id="#deleteDatas"><svg class="icon"><use xlink:href="#cancel"></use></svg></i></span>')
                        .on('click' , 'i',function(ss){
                            ss.currentTarget.parentElement.remove();
                        })
                );
                $('#good').val('');
            }
        })
        var keycode = 0;
        $('#good').keypress(function(event){
            if($("#good").val() != ''){
                keycode = (event.keyCode ? event.keyCode : event.which);
                if(keycode == '13') {
                    $('#goodContainer').append(
                        $('<span>' + $("#good").val() + '<i id="#deleteDatas"><svg class="icon"><use xlink:href="#cancel"></use></svg></i></span>')
                            .on('click', 'i', function (ss) {
                                ss.currentTarget.parentElement.remove();
                            })
                    );
                    $('#good').val('');
                }
            }
        })
        $('#bad').keypress(function(event){
            if($("#bad").val() != ''){
                keycode = (event.keyCode ? event.keyCode : event.which);
                if(keycode == '13') {
                    $('#badContainer').append(
                        $('<span>' + $("#bad").val() + '<i id="#deleteDatas"><svg class="icon"><use xlink:href="#cancel"></use></svg></i></span>')
                            .on('click', 'i', function (ss) {
                                ss.currentTarget.parentElement.remove();
                            })
                    );
                    $('#bad').val('');
                }
            }
        })
        $('#badBtn').click(function(){
            if($("#bad").val() != ''){
                $('#badContainer').append(
                    $('<span>'+$("#bad").val()+'<i id="#deleteDatas"><svg class="icon"><use xlink:href="#cancel"></use></svg></i></span>')
                        .on('click' , 'i',function(ss){
                            ss.currentTarget.parentElement.remove();
                        })
                );
                $('#bad').val('');
            }
        })
        $('.allCommentButtons #createComment').click(function (){
            if($('.allCommentButtons #createComment').text() != 'صبر کنید ...'){
                $('.allCommentButtons #createComment').text('صبر کنید ...');
                var bads = [];
                var goods = [];
                var title = $("input[name='title']").val();
                var body = $("textarea[name='body']").val();
                $.each($('#badContainer span') , function (){
                    bads.push(this.textContent);
                })
                $.each($('#goodContainer span') , function (){
                    goods.push(this.textContent);
                })

                var form = {
                    "_token": "{{ csrf_token() }}",
                    "_method": "post",
                    title:title,
                    type:type1,
                    product:post.id,
                    body:body,
                    rate:rate,
                    good:JSON.stringify(goods),
                    bad:JSON.stringify(bads),
                };

                $.ajax({
                    url: "/send-comment",
                    type: "post",
                    data: form,
                    success: function (data) {
                        if($('.allCommentButtons #createComment').text('ارسال'));
                        if(data == 'noUser'){
                            $.toast({
                                text: "ابتدا عضو شوید", // Text that is to be shown in the toast
                                heading: 'عضو شوید', // Optional heading to be shown on the toast
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
                        }else{
                            $.toast({
                                text: "دیدگاه بعد از تایید منتشر خواهد شد", // Text that is to be shown in the toast
                                heading: 'موفقیت آمیز', // Optional heading to be shown on the toast
                                icon: 'success', // Type of toast icon
                                showHideTransition: 'fade', // fade, slide or plain
                                allowToastClose: true, // Boolean value true or false
                                hideAfter: 3000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                                stack: 5, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
                                position: 'bottom-left', // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values
                                textAlign: 'left',  // Text alignment i.e. left, right or center
                                loader: true,  // Whether to show loader or not. True by default
                                loaderBg: '#9EC600',  // Background color of the toast loader
                            });
                            $('.addComments').toggle();
                            $('.btnComment').toggle();
                            $('.showComments').toggle();
                        }
                    },
                    error: function (xhr) {
                        if($('.allCommentButtons #createComment').text('ارسال'));
                        $.toast({
                            text: "فیلد های ستاره دار را پر کنید", // Text that is to be shown in the toast
                            heading: 'دقت کنید', // Optional heading to be shown on the toast
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
                        $.each(xhr.responseJSON.errors, function(key,value) {
                            $('#validation-' + key).append('<div class="alert alert-danger">'+value+'</div');
                        });
                    }
                });
            }
        })
    })
</script>
