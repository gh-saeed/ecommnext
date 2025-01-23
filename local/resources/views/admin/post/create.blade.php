@extends('admin.master')

@section('tab',1)
@section('content')
    <div class="allCreatePost">
        <div class="allCreatePost">
            <div class="allPostPanelTop">
                <h1>افزودن محصول</h1>
                <div class="allPostTitle">
                    <a href="/admin">داشبورد</a>
                    <span>/</span>
                    <a href="/admin/product">همه محصول ها</a>
                    <span>/</span>
                    <a href="/admin/product/create">افزودن محصول</a>
                </div>
            </div>
            <div class="getDigikala type1">
                <label>دریافت سریع از</label>
                <select name="typeG">
                    <option value="1" selected>دیجیکالا</option>
{{--                    <option value="2">آمازون</option>--}}
                </select>
                <input type="text" name="digikala" placeholder="برای دیجیکالا کد محصول و بقیه کل لینک قرار دهید : مثال 123456">
                <button>دریافت محصول</button>
            </div>
            <div class="showData">
                <button class="active" data-for="infoProduct">اطلاعات محصول*</button>
                <button data-for="calcProduct">اطلاعات حسابداری و قیمت*</button>
            </div>
            <div id="infoProduct" class="allCreatePostData">
                <div class="allCreatePostSubject">
                    <div class="allCreatePostItem">
                        <label>عنوان* :</label>
                        <input type="text" name="title" value="{{ old('title', $posts?$posts->title:'') }}" placeholder="عنوان را وارد کنید">
                        <div id="validation-title"></div>
                    </div>
                    <div class="allCreatePostItem">
                        <label>تعداد برای فروش* :</label>
                        <input type="text" name="count" value="{{ old('count', $posts?$posts->count:'') }}" placeholder="تعداد را وارد کنید">
                        <div id="validation-count"></div>
                    </div>
                    <div class="allCreatePostItem">
                        <label>زمان آماده سازی* :</label>
                        <input type="text" name="prepare" value="{{ old('prepare', $posts?$posts->prepare:'') }}" placeholder="مثال : 2">
                    </div>
                    <div class="allCreatePostItem">
                        <label>تخمین زمان تحویل* :</label>
                        <input type="text" name="time" value="{{ old('time', $posts?$posts->time:'') }}" placeholder="مثال : 2">
                    </div>
                    <div class="allCreatePostItem">
                        <label>توضیحات :</label>
                        <textarea name="body" class="body">{{$posts?$posts->body:''}}</textarea>
                    </div>
                    <div class="addImageButton">برای افزودن تصویر کلیک کنید</div>
                    <div class="sendGallery">
                        <div class="getImageItem">
                            <span id="imageTooltip">تصاویر خود را وارد کنید</span>
                        </div>
                    </div>
                    <div class="abilityPost">
                        <div class="abilityTitle">
                            <label>ویژگی‌های محصول</label>
                            <i id="addAbility">
                                <svg class="icon">
                                    <use xlink:href="#add"></use>
                                </svg>
                            </i>
                        </div>
                        <table class="abilityTable" id="abilities">
                            <tr>
                                <th>ویژگی‌های محصول</th>
                                <th>حذف</th>
                            </tr>
                        </table>
                    </div>
                    <div class="abilityPost">
                        <div class="abilityTitle">
                            <label class="tv1">ویدئو محصول</label>
                            <i id="addVideo">
                                <svg class="icon">
                                    <use xlink:href="#add"></use>
                                </svg>
                            </i>
                        </div>
                        <table class="abilityTable" id="videos">
                            <tr>
                                <th>آدرس ویدئو</th>
                                <th>حذف</th>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="allCreatePostDetails">
                    <div class="allCreatePostDetail">
                        <div class="allCreatePostDetailItemsTitle">
                            جزییات
                        </div>
                        <div class="allCreatePostDetailItems">
                            <div class="allCreatePostDetailItem">
                                <label>وزن :</label>
                                <input type="text" name="weight" value="{{ old('weight', $posts?$posts->weight:'') }}" placeholder="وزن را وارد کنید">
                            </div>
                            <div class="allCreatePostDetailItem">
                                <label>پیوند(slug) :</label>
                                <input type="text" name="slug" value="{{ old('slug', $posts?$posts->slug:'') }}" placeholder="پیوند را وارد کنید">
                            </div>
                            <div class="allCreatePostDetailItem">
                                <label>وضعیت* :</label>
                                <select name="status" id="status" value="{{ old('status', $posts?$posts->status:'') }}">
                                    <option value="0">پیشنویس</option>
                                    <option value="1">منتشر شده</option>
                                </select>
                                <div id="validation-status"></div>
                            </div>
                        </div>
                    </div>
                    <div class="allCreatePostDetail">
                        <div class="allCreatePostDetailItemsTitle">
                            اطلاعات بیشتر
                        </div>
                        <div class="allCreatePostDetailItems">
                            <div class="allCreatePostDetailItem">
                                <label>امتیاز :</label>
                                <input type="text" name="score" value="{{ old('score', $posts?$posts->score:'') }}" placeholder="امتیاز را وارد کنید">
                                <div id="validation-score"></div>
                            </div>
                            <div class="allCreatePostDetailItem">
                                <label for="s1d" class="allCreatePostDetailItemData">
                                    در ویترین آرشیو
                                    <input id="s1d" type="checkbox" name="showcase" class="switch" >
                                </label>
                                <label for="s2d" class="allCreatePostDetailItemData type1">
                                    اصل
                                    <input id="s2d" name="original" type="checkbox" class="switch" >
                                </label>
                                <label for="s3d" class="allCreatePostDetailItemData type1">
                                    کارکرده
                                    <input id="s3d" type="checkbox" name="used" class="switch">
                                </label>
                                <label for="s5d" class="allCreatePostDetailItemData type1">
                                    استعلام موجودی اجباری
                                    <input id="s5d" type="checkbox" class="switch" name="inquiry">
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="allCreatePostDetail">
                        <div class="allCreatePostDetailItemsTitle">
                            تاکسونامی
                        </div>
                        <div class="allCreatePostDetailItems">
                            <div class="allCreatePostDetailItem">
                                <label>غرفه دار :</label>
                                <select class="users-multiple" name="user_id">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="allCreatePostDetailItem">
                                <label>دسته بندی :</label>
                                <select class="cats-multiple" name="cats" multiple="multiple">
                                    @foreach ($cats as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="allCreatePostDetailItem">
                                <label>برند :</label>
                                <select class="brands-multiple" name="brands" multiple="multiple">
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="allCreatePostDetailItem">
                                <label>گارانتی :</label>
                                <select class="guarantee-multiple" name="guarantees" multiple="multiple">
                                    @foreach ($guarantees as $guarantee)
                                        <option value="{{ $guarantee->id }}">{{ $guarantee->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="allCreatePostDetailItem">
                                <label>برچسب :</label>
                                <select class="tag-multiple" name="tags" multiple="multiple">
                                    @foreach ($tags as $tag)
                                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="allCreatePostDetailItem">
                                <label>حامل :</label>
                                <select class="carrier-multiple" name="carriers">
                                    @foreach ($carriers as $carrier)
                                        <option value="{{ $carrier->id }}">{{ $carrier->name . ' - ' . number_format($carrier->price) . ' تومان ' }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="calcProduct" class="allCreatePostData" style="display: none">
                <div class="allCreatePostSubject">
                    <div class="allCreatePostItem">
                        <label>درصد تخفیف(50) :</label>
                        <input type="text" name="off" value="{{$posts?$posts->off:''}}" placeholder="تخفیف را وارد کنید">
                    </div>
                    <div class="allCreatePostItem">
                        <label>قیمت فروش به کاربر* :</label>
                        <input type="text" name="price" value="{{$posts?$posts->price:''}}" placeholder="قیمت را وارد کنید">
                        <div id="validation-price"></div>
                    </div>
                </div>
            </div>
            <button class="button" name="createPost" type="submit">ارسال اطلاعات</button>
        </div>
        <div class="filemanager">
            @include('admin.filemanager')
        </div>
    </div>
@endsection

@section('scripts3')
    <script>
        $(document).ready(function(){
            var posts = {!! json_encode($posts, JSON_HEX_TAG) !!};
            $('.filemanager').hide();
            $('.addImageButton').click(function(){
                $('.filemanager').show();
            });
            $(".showData button").click(function (){
                $(".showData button").attr('class' , '');
                $(this).attr('class' , 'active');
                $(".allCreatePost .allCreatePostData").hide();
                $(".allCreatePost " + '#' + $(this).attr('data-for')).show();
            })
            if(posts){
                if(posts.used == 1){
                    $("input[name='used']").prop("checked", true );
                }
                if(posts.original == 1){
                    $("input[name='original']").prop("checked", true );
                }
                if(posts.showcase == 1){
                    $("input[name='showcase']").prop("checked", true );
                }
                if(posts.inquiry == 1){
                    $("input[name='inquiry']").prop("checked", true );
                }
                $("select[name='status']").val(posts.status);
                $("select[name='user_id']").val(posts.user_id);
                if(posts.image){
                    $.each(JSON.parse(posts.image),function(){
                        $('#imageTooltip').hide();
                        $('.getImageItem').append(
                            $('<div class="getImagePic"><i><svg class="deleteImg"><use xlink:href="#trash"></use></svg></i><img src="'+this+'"></div>')
                                .on('click' , '.deleteImg',function(ss){
                                    ss.currentTarget.parentElement.parentElement.remove();
                                })
                        );
                    });
                }
                var cats = [];
                var brands = [];
                var tags = [];
                var guarantee = [];
                var time = [];
                if(posts.category){
                    $.each(posts.category,function(){
                        cats.push(this.id);
                    });
                    $('.cats-multiple').val(cats);
                }
                if(posts.brand){
                    $.each(posts.brand,function(){
                        brands.push(this.id);
                    });
                    $('.brands-multiple').val(brands);
                }
                if(posts.guarantee){
                    $.each(posts.guarantee,function(){
                        guarantee.push(this.id);
                    });
                    $('.guarantee-multiple').val(guarantee);
                }
                if(posts.tag){
                    $.each(posts.tag,function(){
                        tags.push(this.id);
                    });
                    $('.tag-multiple').val(tags);
                }
                if(posts.ability) {
                    if(JSON.parse(posts.ability)) {
                        $.each(JSON.parse(posts.ability),function(){
                            $('#abilities').append(
                                $('<tr><td><input type="text" name="name" value="'+this.name+'" placeholder="ویژگی‌ را وارد کنید"></td><td><i id="deleteAbility"><svg class="icon"><use xlink:href="#trash"></use></svg></i></td></tr>')
                                    .on('click' , '#deleteAbility',function(ss){
                                        ss.currentTarget.parentElement.parentElement.remove();
                                    })
                            );
                        })
                    }
                }
                if(posts.video) {
                    $.each(posts.video,function(){
                        $('#videos').append(
                            $('<tr><td><input type="text" name="url" value="'+this.url+'" placeholder="آدرس را وارد کنید"></td><td><i id="deleteVideo"><svg class="icon"><use xlink:href="#trash"></use></svg></i></td></tr>')
                                .on('click' , '#deleteVideo',function(ss){
                                    ss.currentTarget.parentElement.parentElement.remove();
                                })
                        );
                    })
                }
            }
            $('.brands-multiple').select2({
                placeholder: 'برند را انتخاب کنید ...',
                "language": {
                    "noResults": function(){
                        return "موردی پیدا نشد";
                    }
                },
            });
            $('.cats-multiple').select2({
                placeholder: 'دسته بندی را انتخاب کنید ...',
                "language": {
                    "noResults": function(){
                        return "موردی پیدا نشد";
                    }
                },
            });
            $('.guarantee-multiple').select2({
                placeholder: 'گارانتی را انتخاب کنید ...',
                "language": {
                    "noResults": function(){
                        return "موردی پیدا نشد";
                    }
                },
            });
            $('.carrier-multiple').select2({
                placeholder: 'حامل را انتخاب کنید ...',
                "language": {
                    "noResults": function(){
                        return "موردی پیدا نشد";
                    }
                },
            });
            $('.tag-multiple').select2({
                placeholder: 'برچسب را انتخاب کنید ...',
                "language": {
                    "noResults": function(){
                        return "موردی پیدا نشد";
                    }
                },
            });
            $('.users-multiple').select2({
                placeholder: 'غرفه دار را انتخاب کنید ...',
                "language": {
                    "noResults": function(){
                        return "موردی پیدا نشد";
                    }
                },
            });
            $("select[name='brands']").change(function() {
                var d=$("select[name='brands'] :selected").map(function(){
                    return $(this).val();
                });
            });
            $(".getDigikala button").click(function(event){
                $(this).text('منتظر بمانید');
                var digikala = $(".getDigikala input[name='digikala']").val();
                var typeG = $(".getDigikala select[name='typeG']").val();
                var form = {
                    "_token": "{{ csrf_token() }}",
                    digikala:digikala,
                    type:typeG,
                };

                $.ajax({
                    url: "/admin/product/get-data",
                    type: "post",
                    data: form,
                    success: function (data) {
                        $(".getDigikala button").text('دریافت محصول');
                        $.toast({
                            text: "محصول دریافت شد", // Text that is to be shown in the toast
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
                        if(typeG == 1){
                            $(".allCreatePostData input[name='title']").val(data[0].product.title_fa);
                            $(".allCreatePostData select[name='status']").val(1);
                            $("#calcProduct input[name='price']").val(data[3]);
                            $(".allCreatePostData input[name='count']").val(10);
                            $(".allCreatePostItem textarea[name='body']").val(data[0].product.review.description);
                            $.each(data[4],function(){
                                $('#imageTooltip').hide();
                                $('.getImageItem').append(
                                    $('<div class="getImagePic"><i><svg class="deleteImg"><use xlink:href="#trash"></use></svg></i><img src="'+this+'"></div>')
                                        .on('click' , '.deleteImg',function(ss){
                                            ss.currentTarget.parentElement.parentElement.remove();
                                        })
                                );
                            });
                            var brands = [];
                            var cats = [];
                            if(data[2]){
                                $.each(data[2],function(){
                                    cats.push(this.id);
                                });
                                $('.cats-multiple').val(cats);
                            }
                            if(data[1]){
                                $.each(data[1],function(){
                                    brands.push(this.id);
                                });
                                $('.brands-multiple').val(brands);
                            }
                            $.each(data[0]['colors'],function(){
                                $('#colors').append(
                                    $('<tr><td><input type="text" name="name" value="'+this.title+'" placeholder="نام را وارد کنید"></td><td><input name="color" value="'+this.hex_code+'" placeholder="کد را وارد کنید"></td><td><input name="count" value="5" placeholder="تعداد را وارد کنید"></td><td><input name="price" value="0" placeholder="قیمت را وارد کنید"></td><td><i id="deleteColor"><svg class="icon"><use xlink:href="#trash"></use></svg></i></td></tr>')
                                        .on('click' , '#deleteColor',function(ss){
                                            ss.currentTarget.parentElement.parentElement.remove();
                                        })
                                );
                            })
                            $.each(data[0].product.review['attributes'],function(){
                                $('#abilities').append(
                                    $('<tr><td><input type="text" name="name" value="'+this.title+' : '+this.values[0]+'" placeholder="ویژگی‌ را وارد کنید"></td><td><i id="deleteAbility"><svg class="icon"><use xlink:href="#trash"></use></svg></i></td></tr>')
                                        .on('click' , '#deleteAbility',function(ss){
                                            ss.currentTarget.parentElement.parentElement.remove();
                                        })
                                );
                            })
                        }
                        if(typeG == 2){
                            $(".allCreatePostData input[name='title']").val(data[0]);
                            $(".allCreatePostData select[name='status']").val(1);
                            $(".detailPrices input[name='price']").val(data[6]);
                            $(".allCreatePostData input[name='count']").val(10);
                            $(".allCreatePostItem textarea[name='body']").val(data[5]);
                            $.each(data[2],function(){
                                $('#imageTooltip').hide();
                                $('.getImageItem').append(
                                    $('<div class="getImagePic"><i><svg class="deleteImg"><use xlink:href="#trash"></use></svg></i><img src="'+this+'"></div>')
                                        .on('click' , '.deleteImg',function(ss){
                                            ss.currentTarget.parentElement.parentElement.remove();
                                        })
                                );
                            });
                            var brands = [];
                            if(data[1]){
                                $.each(data[1],function(){
                                    brands.push(this.id);
                                });
                                $('.brands-multiple').val(brands);
                            }
                            $.each(data[3],function(){
                                $('#abilities').append(
                                    $('<tr><td><input type="text" name="name" value="'+this+' : '+this+'" placeholder="ویژگی‌ را وارد کنید"></td><td><i id="deleteAbility"><svg class="icon"><use xlink:href="#trash"></use></svg></i></td></tr>')
                                        .on('click' , '#deleteAbility',function(ss){
                                            ss.currentTarget.parentElement.parentElement.remove();
                                        })
                                );
                            })
                        }
                        if(typeG == 0){
                            $(".allCreatePostDetailItems input[name='title']").val(data[0]);
                            $(".allCreatePostDetailItems select[name='status']").val(1);
                            $("#calcProduct .detailPrices input[name='price']").val(data[1]);
                            $(".allCreatePostDetailItems input[name='count']").val(data[6]);
                            var cats1 = [];
                            if(data[4]){
                                $.each(data[4],function(){
                                    cats1.push(this.id);
                                });
                                $('.cats-multiple').val(cats1);
                            }
                            $.each(data[5],function(){
                                $('#imageTooltip').hide();
                                $('.getImageItem').append(
                                    $('<div class="getImagePic"><i><svg class="deleteImg"><use xlink:href="#trash"></use></svg></i><img src="'+this+'"></div>')
                                        .on('click' , '.deleteImg',function(ss){
                                            ss.currentTarget.parentElement.parentElement.remove();
                                        })
                                );
                            });
                            $.each(data[2],function(){
                                $('#abilities').append(
                                    $('<tr><td><input type="text" name="name" value="'+this+'" placeholder="ویژگی‌ را وارد کنید"></td><td><i id="deleteAbility"><svg class="icon"><use xlink:href="#trash"></use></svg></i></td></tr>')
                                        .on('click' , '#deleteAbility',function(ss){
                                            ss.currentTarget.parentElement.parentElement.remove();
                                        })
                                );
                            })
                        }
                    },
                    error: function (xhr) {
                        $.toast({
                            text: "محصول یافت نشد", // Text that is to be shown in the toast
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
                        $(".getDigikala button").text('دریافت محصول');
                    }
                });
            })
            $("button[name='createPost']").click(function(event){
                $(this).text('منتظر بمانید');
                var title = $(".allCreatePostData input[name='title']").val();
                var weight = $(".allCreatePostData input[name='weight']").val();
                var slug = $(".allCreatePostData input[name='slug']").val();
                var time = $(".allCreatePostData input[name='time']").val();
                var status = $(".allCreatePostData select[name='status']").val();
                var off = $(".allCreatePostData input[name='off']").val();
                var price = $("#calcProduct input[name='price']").val();
                var count = $(".allCreatePostData input[name='count']").val();
                var score = $(".allCreatePostData input[name='score']").val();
                var prepare = $(".allCreatePostData input[name='prepare']").val();
                var body = $(".allCreatePostData textarea[name='body']").val();
                var showcase = $(".allCreatePostData input[name='showcase']").is(":checked");
                var original = $(".allCreatePostData input[name='original']").is(":checked");
                var used = $(".allCreatePostData input[name='used']").is(":checked");
                var inquiry = $(".allCreatePostData input[name='inquiry']").is(":checked");
                var countTank = $("input[name='countTank']").val();
                var carriers = $("select[name='carriers']").val();
                var user_id = $("select[name='user_id']").val();
                var brands = [];
                var cats = [];
                var guarantees = [];
                var tags = [];
                var image = [];
                $(".allCreatePostDetailItems select[name='brands'] :selected").each(function(){
                    brands.push($(this).val());
                });
                $(".allCreatePostDetailItems select[name='tags'] :selected").each(function(){
                    tags.push($(this).val());
                });
                $(".getImagePic").each(function(){
                    image.push(this.lastElementChild.src);
                });
                $("select[name='cats'] :selected").each(function(){
                    cats.push($(this).val());
                });
                $("select[name='guarantees'] :selected").each(function(){
                    guarantees.push($(this).val());
                });
                var abilities = [];
                $("#abilities tr").each(function(){
                    if($(this).find("input").length >= 1){
                        var ability = {
                            name:"",
                        };
                        $(this).find("input").each(function(){
                            ability.name = this.value;
                        })
                        abilities.push(ability);
                    }
                });

                var videos = [];
                $("#videos tr").each(function(){
                    if($(this).find("input").length >= 1){
                        var video = {
                            url:"",
                        };
                        $(this).find("input").each(function(){
                            video.url = this.value;
                        })
                        videos.push(video);
                    }
                });
                var form = {
                    "_token": "{{ csrf_token() }}",
                    title:title,
                    weight:weight,
                    slug:slug,
                    status:status,
                    off:off,
                    score:score,
                    price:price,
                    count:count,
                    prepare:prepare,
                    time:time,
                    body:body,
                    showcase:showcase,
                    original:original,
                    used:used,
                    inquiry:inquiry,
                    countTank:countTank,
                    user_id:user_id,
                    carriers:carriers,
                    brands:JSON.stringify(brands),
                    cats:JSON.stringify(cats),
                    guarantees:JSON.stringify(guarantees),
                    tags:JSON.stringify(tags),
                    abilities:JSON.stringify(abilities),
                    image:JSON.stringify(image),
                    videos:JSON.stringify(videos),
                };
                $.ajax({
                    url: "/admin/product/create",
                    type: "post",
                    data: form,
                    success: function (data) {
                        $.toast({
                            text: "محصول اضافه شد", // Text that is to be shown in the toast
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
                        window.location.href="/admin/product";
                    },
                    error: function (xhr) {
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
                        $("button[name='createPost']").text('ثبت اطلاعات');
                    }
                });
            });
            $('#addAbility').click(function (){
                $('#abilities').append(
                    $('<tr><td><input type="text" name="name" placeholder="ویژگی‌ را وارد کنید"></td><td><i id="deleteAbility"><svg class="icon"><use xlink:href="#trash"></use></svg></i></td></tr>')
                        .on('click' , '#deleteAbility',function(ss){
                            ss.currentTarget.parentElement.parentElement.remove();
                        })
                );
            })
            $('#addVideo').click(function (){
                $('#videos').append(
                    $('<tr><td><input type="text" name="url" placeholder="آدرس را وارد کنید"></td><td><i id="deleteVideo"><svg class="icon"><use xlink:href="#trash"></use></svg></i></td></tr>')
                        .on('click' , '#deleteVideo',function(ss){
                            ss.currentTarget.parentElement.parentElement.remove();
                        })
                );
            })
            $('#addColor').click(function (){
                $('#colors').append(
                    $('<tr><td><input type="text" name="name" placeholder="نام را وارد کنید"></td><td><input name="color" type="color" placeholder="کد را وارد کنید"></td><td><input name="count" placeholder="مثال : 10"></td><td><input name="price" placeholder="مبلغ اصلی با این فیلد جمع میشود"></td><td><i id="deleteColor"><svg class="icon"><use xlink:href="#trash"></use></svg></i></td></tr>')
                        .on('click' , '#deleteColor',function(ss){
                            ss.currentTarget.parentElement.parentElement.remove();
                        })
                );
            })
            $('#addSize').click(function (){
                $('#sizes').append(
                    $('<tr><td><input type="text" name="name" placeholder="سایز را وارد کنید"></td><td><input type="text" name="count" placeholder="مثال : 10"></td><td><input placeholder="مبلغ اصلی با این فیلد جمع میشود" name="price"></td><td><i id="deleteSize"><svg class="icon"><use xlink:href="#trash"></use></svg></i></td></tr>')
                        .on('click' , '#deleteSize',function(ss){
                            ss.currentTarget.parentElement.parentElement.remove();
                        })
                );
            })
        })
    </script>
@endsection

@section('jsScript')
    <script src="/js/persian-date.min.js"></script>
    <script src="/js/persian-datepicker.min.js"></script>
    <script src="/js/select2.min.js"></script>
    <script src="/js/editor/ckeditor.js"></script>
    <script src="/js/editor/adapters/jquery.js"></script>
@endsection

@section('links')
    <link rel="stylesheet" href="/css/persian-datepicker.min.css"/>
    <link rel="stylesheet" href="/css/select2.min.css"/>
@endsection
