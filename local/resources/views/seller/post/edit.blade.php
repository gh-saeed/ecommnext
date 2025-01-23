@extends('seller.master')

@section('tab',2)
@section('content')
    <div class="allCreatePost">
        <div class="allCreatePost">
            <div class="allPostPanelTop">
                <h1>{{__('messages.edit_product')}}</h1>
                <div class="allPostTitle">
                    <a href="/seller">{{__('messages.dashboard')}}</a>
                    <span>/</span>
                    <a href="/seller/product">{{__('messages.dashboard')}}</a>
                    <span>/</span>
                    <a href="/seller/product/{{$posts->id}}/edit">{{__('messages.edit_product')}}</a>
                </div>
            </div>
            <div class="allCreatePostData">
                <div class="allCreatePostSubject">
                    <div class="allCreatePostItem">
                        <label>توضیحات* :</label>
                        <textarea placeholder="توضیحات" name="body">{{$posts?$posts->body:''}}</textarea>
                        <div id="validation-body"></div>
                    </div>
                    <div class="addImageButton">{{__('messages.add_pic')}}</div>
                    <div class="sendGallery">
                        <div class="getImageItem">
                            <span id="imageTooltip">{{__('messages.add_pic2')}}</span>
                        </div>
                    </div>
                    <div class="abilityPost">
                        <div class="abilityTitle">
                            <label>{{__('messages.product_property')}}</label>
                            <i id="addAbility">
                                <svg class="icon">
                                    <use xlink:href="#add"></use>
                                </svg>
                            </i>
                        </div>
                        <table class="abilityTable" id="abilities">
                            <tr>
                                <th>{{__('messages.product_property')}}</th>
                                <th>{{__('messages.delete')}}</th>
                            </tr>
                        </table>
                    </div>
                    <div class="abilityPost">
                        <div class="abilityTitle">
                            <label>{{__('messages.color')}}</label>
                            <i id="addColor">
                                <svg class="icon">
                                    <use xlink:href="#add"></use>
                                </svg>
                            </i>
                        </div>
                        <table class="abilityTable" id="colors">
                            <tr>
                                <th>{{__('messages.color_name')}}</th>
                                <th>{{__('messages.count')}}</th>
                                <th>{{__('messages.increase_price')}}</th>
                                <th>{{__('messages.delete')}}</th>
                            </tr>
                        </table>
                    </div>
                    <div class="abilityPost">
                        <div class="abilityTitle">
                            <label>{{__('messages.size')}}</label>
                            <i id="addSize">
                                <svg class="icon">
                                    <use xlink:href="#add"></use>
                                </svg>
                            </i>
                        </div>
                        <table class="abilityTable" id="sizes">
                            <tr>
                                <th>{{__('messages.size')}}</th>
                                <th>{{__('messages.count')}}</th>
                                <th>{{__('messages.increase_price')}}</th>
                                <th>{{__('messages.delete')}}</th>
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
                    <button class="button" name="createPost" type="submit">{{__('messages.submit_info')}}</button>
                </div>
                <div class="allCreatePostDetails">
                    <div class="allCreatePostDetail">
                        <div class="allCreatePostDetailItemsTitle">
                            {{__('messages.detail')}}
                        </div>
                        <div class="allCreatePostDetailItems">
                            <div class="allCreatePostDetailItem">
                                <label>{{__('messages.title1')}}* :</label>
                                <input type="text" name="title" value="{{$posts?$posts->title:''}}" placeholder="{{__('messages.title1')}}">
                                <div id="validation-title"></div>
                            </div>
                            <div class="allCreatePostDetailItem">
                                <label>وزن (گرم)* :</label>
                                <input type="text" name="weight" value="{{$posts?$posts->weight:''}}" placeholder="{{__('messages.weight')}}">
                            </div>
                            <div class="allCreatePostDetailItem">
                                <label>{{__('messages.off_percent')}} :</label>
                                <input type="text" name="off" value="{{$posts?$posts->off:''}}" placeholder="{{__('messages.off_percent')}}">
                            </div>
                            <div class="allCreatePostDetailItem">
                                <label>{{__('messages.price_arz')}}* :</label>
                                <input type="text" name="price" value="{{$posts?$posts->price:''}}" placeholder="{{__('messages.price_arz')}}">
                                <div id="validation-price"></div>
                            </div>
                        </div>
                    </div>
                    <div class="allCreatePostDetail">
                        <div class="allCreatePostDetailItemsTitle">
                            {{__('messages.more_info')}}
                        </div>
                        <div class="allCreatePostDetailItems">
                            <div class="allCreatePostDetailItem">
                                <label>زمان آماده سازی* :(روز)</label>
                                <input type="text" name="prepare" value="{{ old('prepare', $posts?$posts->prepare:'') }}" placeholder="مثال : 2">
                            </div>
                            <div class="allCreatePostDetailItem">
                                <label>تخمین زمان تحویل* :(روز)</label>
                                <input type="text" name="time" value="{{ old('time', $posts?$posts->time:'') }}" placeholder="مثال : 2">
                            </div>
                            <div class="allCreatePostDetailItem">
                                <label>{{__('messages.count')}}* :</label>
                                <input type="text" name="count" value="{{$posts?$posts->count:''}}" placeholder="{{__('messages.count')}}">
                                <div id="validation-count"></div>
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
                                <label>برچسب :</label>
                                <select class="tag-multiple" name="tags" multiple="multiple">
                                    @foreach ($tags as $tag)
                                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="allCreatePostDetailItem">
                                <label>حامل و روش ارسال* :</label>
                                <select class="carrier-multiple" name="carriers">
                                    @foreach ($carriers as $carrier)
                                        <option value="{{ $carrier->id }}">{{ $carrier->name . ' - ' . number_format($carrier->price) . ' تومان ' }}</option>
                                    @endforeach
                                </select>
                                <div id="validation-carriers"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="filemanager">
            @include('seller.filemanager')
        </div>
    </div>
@endsection

@section('scripts3')
    <script>
        $(document).ready(function(){
            var posts = {!! $posts->toJson() !!};
            $('.filemanager').hide();
            $('.addImageButton').click(function(){
                $('.filemanager').show();
            });
            $("input[name='suggest']").val(posts.suggest);
            if(posts.used == 1){
                $("input[name='used']").prop("checked", true );
            }
            if(posts.original == 1){
                $("input[name='original']").prop("checked", true );
            }
            if(posts.showcase == 1){
                $("input[name='showcase']").prop("checked", true );
            }
            $("select[name='status']").val(posts.status);
            if(posts.carriers.length >= 1){
                $(".allCreatePost select[name='carriers']").val(posts.carriers[0]['id']);
            }
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
            var product_property2 = {!! json_encode(__('messages.product_property2'), JSON_HEX_TAG) !!};
            var color3 = {!! json_encode(__('messages.color'), JSON_HEX_TAG) !!};
            var size3 = {!! json_encode(__('messages.size'), JSON_HEX_TAG) !!};
            var count3 = {!! json_encode(__('messages.count'), JSON_HEX_TAG) !!};
            var price3 = {!! json_encode(__('messages.price1'), JSON_HEX_TAG) !!};
            var property3 = {!! json_encode(__('messages.property'), JSON_HEX_TAG) !!};
            var body3 = {!! json_encode(__('messages.body'), JSON_HEX_TAG) !!};
            var color_code = {!! json_encode(__('messages.color_code'), JSON_HEX_TAG) !!};
            var select_brand = {!! json_encode(__('messages.select_brand'), JSON_HEX_TAG) !!};
            var select_cat = {!! json_encode(__('messages.select_cat'), JSON_HEX_TAG) !!};
            var not_found = {!! json_encode(__('messages.not_found'), JSON_HEX_TAG) !!};
            var not_guarantee = {!! json_encode(__('messages.not_guarantee'), JSON_HEX_TAG) !!};
            var select_tag = {!! json_encode(__('messages.select_tag'), JSON_HEX_TAG) !!};
            var product_added = {!! json_encode(__('messages.product_added'), JSON_HEX_TAG) !!};
            var login_attention = {!! json_encode(__('messages.login_attention'), JSON_HEX_TAG) !!};
            var success1 = {!! json_encode(__('messages.success'), JSON_HEX_TAG) !!};
            var star_field = {!! json_encode(__('messages.star_field'), JSON_HEX_TAG) !!};
            var submit_info = {!! json_encode(__('messages.submit_info'), JSON_HEX_TAG) !!};
            if(posts.ability) {
                if(JSON.parse(posts.ability)) {
                    $.each(JSON.parse(posts.ability),function(){
                        $('#abilities').append(
                            $('<tr><td><input type="text" name="name" value="'+this.name+'" placeholder="'+property3+'"></td><td><i id="deleteAbility"><svg class="icon"><use xlink:href="#trash"></use></svg></i></td></tr>')
                                .on('click' , '#deleteAbility',function(ss){
                                    ss.currentTarget.parentElement.parentElement.remove();
                                })
                        );
                    })
                }
            }
            if(posts.colors) {
                if(JSON.parse(posts.colors)) {
                    $.each(JSON.parse(posts.colors),function(){
                        $('#colors').append(
                            $('<tr><td><input type="text" name="name" value="'+this.name+'" placeholder="'+color3+'"></td><td><input name="count" value="'+this.count+'" placeholder="'+count3+'"></td><td><input name="price" value="'+this.price+'" placeholder="'+price3+'"></td><td><i id="deleteColor"><svg class="icon"><use xlink:href="#trash"></use></svg></i></td></tr>')
                                .on('click' , '#deleteColor',function(ss){
                                    ss.currentTarget.parentElement.parentElement.remove();
                                })
                        );
                    })
                }
            }
            if(posts.size) {
                if(JSON.parse(posts.size)) {
                    $.each(JSON.parse(posts.size),function(){
                        $('#sizes').append(
                            $('<tr><td><input type="text" name="name" value="'+this.name+'" placeholder="'+size3+'"></td><td><input type="text" name="count" value="'+this.count+'" placeholder="'+count3+'"></td><td><input placeholder="'+price3+'" value="'+this.price+'" name="price"></td><td><i id="deleteSize"><svg class="icon"><use xlink:href="#trash"></use></svg></i></td></tr>')
                                .on('click' , '#deleteSize',function(ss){
                                    ss.currentTarget.parentElement.parentElement.remove();
                                })
                        );
                    })
                }
            }
            $('.brands-multiple').select2({
                placeholder: select_brand,
                "language": {
                    "noResults": function(){
                        return not_found;
                    }
                },
            });
            $('.cats-multiple').select2({
                placeholder: select_cat,
                "language": {
                    "noResults": function(){
                        return not_found;
                    }
                },
            });
            $('.guarantee-multiple').select2({
                placeholder: not_guarantee,
                "language": {
                    "noResults": function(){
                        return not_found;
                    }
                },
            });
            $('.tag-multiple').select2({
                placeholder: select_tag,
                "language": {
                    "noResults": function(){
                        return not_found;
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
            $("select[name='brands']").change(function() {
                var d=$("select[name='brands'] :selected").map(function(){
                    return $(this).val();
                });
            });
            $("button[name='createPost']").click(function(event){
                $(this).text('منتظر بمانید');
                var title = $(".allCreatePostDetailItems input[name='title']").val();
                var weight = $(".allCreatePostDetailItems input[name='weight']").val();
                var slug = $(".allCreatePostDetailItems input[name='slug']").val();
                var status = $(".allCreatePostDetailItems select[name='status']").val();
                var off = $(".allCreatePostDetailItems input[name='off']").val();
                var price = $(".allCreatePostDetailItems input[name='price']").val();
                var count = $(".allCreatePostDetailItems input[name='count']").val();
                var suggest = $(".allCreatePostDetailItems input[name='suggest']").val();
                var carriers = $("select[name='carriers']").val();
                var prepare = $(".allCreatePostDetailItems input[name='prepare']").val();
                var time = $(".allCreatePostDetailItems input[name='time']").val();
                var body = $(".allCreatePostItem textarea[name='body']").val();
                var showcase = $(".allCreatePostDetailItems input[name='showcase']").is(":checked");
                var original = $(".allCreatePostDetailItems input[name='original']").is(":checked");
                var used = $(".allCreatePostDetailItems input[name='used']").is(":checked");
                var brands = [];
                var cats = [];
                var guarantees = [];
                var times = [];
                var tags = [];
                var image = [];
                $(".allCreatePostDetailItems select[name='brands'] :selected").each(function(){
                    brands.push($(this).val());
                });
                $(".allCreatePostDetailItems select[name='tags'] :selected").each(function(){
                    tags.push($(this).val());
                });
                $(".allCreatePostSubject .getImagePic").each(function(){
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

                var colors = [];
                $("#colors tr").each(function(){
                    if($(this).find("input").length >= 1) {
                        var color = {
                            name: "",
                            count: 0,
                            price: 0,
                        };
                        $(this).find("input").each(function () {
                            if (this.name == 'name') {
                                color.name = this.value;
                            }
                            if (this.name == 'count') {
                                color.count = this.value >= 1?this.value:0;
                            }
                            if (this.name == 'price') {
                                color.price = this.value >= 1?this.value:0;
                            }
                        })
                        colors.push(color);
                    }
                });

                var sizes = [];
                $("#sizes tr").each(function(){
                    if($(this).find("input").length >= 1) {
                        var size = {
                            name: "",
                            count: 0,
                            price: 0,
                        };
                        $(this).find("input").each(function () {
                            if (this.name == 'name') {
                                size.name = this.value;
                            }
                            if (this.name == 'count') {
                                size.count = this.value >= 1?this.value:0;
                            }
                            if (this.name == 'price') {
                                size.price = this.value >= 1?this.value:0;
                            }
                        })
                        sizes.push(size);
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
                    "_method": "put",
                    title:title,
                    weight:weight,
                    slug:slug,
                    status:status,
                    off:off,
                    price:price,
                    count:count,
                    suggest:suggest,
                    body:body,
                    carriers:carriers,
                    showcase:showcase,
                    original:original,
                    prepare:prepare,
                    time:time,
                    used:used,
                    brands:JSON.stringify(brands),
                    cats:JSON.stringify(cats),
                    guarantees:JSON.stringify(guarantees),
                    times:JSON.stringify(times),
                    tags:JSON.stringify(tags),
                    abilities:JSON.stringify(abilities),
                    colors:JSON.stringify(colors),
                    sizes:JSON.stringify(sizes),
                    image:JSON.stringify(image),
                    videos:JSON.stringify(videos),
                };

                $.ajax({
                    url: "/seller/product/"+posts.id+"/edit",
                    type: "put",
                    data: form,
                    success: function (data) {
                        $.toast({
                            text: product_added, // Text that is to be shown in the toast
                            heading: success1, // Optional heading to be shown on the toast
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
                        window.location.href="/seller/product";
                    },
                    error: function (xhr) {
                        $.toast({
                            text: star_field, // Text that is to be shown in the toast
                            heading: login_attention, // Optional heading to be shown on the toast
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
                        $("button[name='createPost']").text(submit_info);
                    }
                });
            });
            $('#addAbility').click(function (){
                $('#abilities').append(
                    $('<tr><td><input type="text" name="name" placeholder="'+property3+'"></td><td><i id="deleteAbility"><svg class="icon"><use xlink:href="#trash"></use></svg></i></td></tr>')
                    .on('click' , '#deleteAbility',function(ss){
                        ss.currentTarget.parentElement.parentElement.remove();
                    })
                );
            })
            $('#addRate').click(function (){
                $('#rates').append(
                    $('<tr><td><input type="text" name="name" value="" placeholder="'+property3+'"></td><td><input type="range" name="rate" value="2" min="0" max="4"></td><td><i id="deleteRate"><svg class="icon"><use xlink:href="#trash"></use></svg></i></td></tr>')
                    .on('click' , '#deleteRate',function(ss){
                        ss.currentTarget.parentElement.parentElement.remove();
                    })
                );
            })
            $('#addProperty').click(function (){
                $('#properties').append(
                    $('<tr><td><input type="text" name="title" placeholder="مشخصات‌ را وارد کنید"></td><td><input name="body" placeholder="'+body3+'"/></td><td><i id="deleteProperty"><svg class="icon"><use xlink:href="#trash"></use></svg></i></td></tr>')
                    .on('click' , '#deleteProperty',function(ss){
                        ss.currentTarget.parentElement.parentElement.remove();
                    })
                );
            })
            $('#addColor').click(function (){
                $('#colors').append(
                    $('<tr><td><input type="text" name="name" placeholder="'+color3+'"></td><td><input name="count" placeholder="'+count3+'"></td><td><input name="price" placeholder="'+price3+'"></td><td><i id="deleteColor"><svg class="icon"><use xlink:href="#trash"></use></svg></i></td></tr>')
                    .on('click' , '#deleteColor',function(ss){
                        ss.currentTarget.parentElement.parentElement.remove();
                    })
                );
            })
            $('#addSize').click(function (){
                $('#sizes').append(
                    $('<tr><td><input type="text" name="name" placeholder="'+size3+'"></td><td><input type="text" name="count" placeholder="'+count3+'"></td><td><input placeholder="'+price3+'" name="price"></td><td><i id="deleteSize"><svg class="icon"><use xlink:href="#trash"></use></svg></i></td></tr>')
                    .on('click' , '#deleteSize',function(ss){
                        ss.currentTarget.parentElement.parentElement.remove();
                    })
                );
            })
        })
    </script>
@endsection

@section('jsScript')
    <script src="/js/jquery.toast.min.js"></script>
    <script src="/js/persian-date.min.js"></script>
    <script src="/js/persian-datepicker.min.js"></script>
    <script src="/js/select2.min.js"></script>
    <script src="/js/editor/ckeditor.js"></script>
    <script src="/js/editor/adapters/jquery.js"></script>
@endsection

@section('links')
    <link rel="stylesheet" href="/css/persian-datepicker.min.css"/>
    <link rel="stylesheet" href="/css/select2.min.css"/>
    <link rel="stylesheet" href="/css/jquery.toast.min.css"/>
@endsection
