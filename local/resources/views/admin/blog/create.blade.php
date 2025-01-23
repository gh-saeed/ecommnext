@extends('admin.master')

@section('tab',5)
@section('content')
    <div class="allCreatePost">
        <div class="allCreatePost">
            <div class="allPostPanelTop">
                <h1>افزودن بلاگ</h1>
                <div class="allPostTitle">
                    <a href="/admin">داشبورد</a>
                    <span>/</span>
                    <a href="/admin/blog">همه بلاگ ها</a>
                    <span>/</span>
                    <a href="/admin/blog/create">افزودن بلاگ</a>
                </div>
            </div>
            <div class="allCreatePostData">
                <div class="allCreatePostSubject">
                    <div class="allCreatePostItem">
                        <label>عنوان سئو :</label>
                        <input type="text" name="titleSeo" placeholder="عنوان را وارد کنید">
                        <div id="validation-titleSeo"></div>
                    </div>
                    <div class="allCreatePostItem">
                        <label>توضیحات سئو :</label>
                        <textarea name="bodySeo" placeholder="توضیحات را وارد کنید"></textarea>
                        <div id="validation-bodySeo"></div>
                    </div>
                    <div class="allCreatePostItem">
                        <label>کلمات کلیدی :</label>
                        <input type="text" name="keywordSeo" placeholder="با , جدا کنید">
                        <div id="validation-keywordSeo"></div>
                    </div>
                    <div class="allCreatePostItem">
                        <label>alt تصویر :</label>
                        <input type="text" name="imageAlt" placeholder="عنوان را وارد کنید">
                        <div id="validation-imageAlt"></div>
                    </div>
                    <div class="allCreatePostItem">
                        <label>توضیحات :</label>
                        <textarea name="body" class="editor"></textarea>
                    </div>
                    <div class="addImageButton">برای افزودن تصویر کلیک کنید</div>
                    <div class="sendGallery">
                        <div class="getImageItem">
                            <span id="imageTooltip">تصاویر خود را وارد کنید</span>
                        </div>
                    </div>
                    <button class="button" name="createPost" type="submit">ارسال اطلاعات</button>
                </div>
                <div class="allCreatePostDetails">
                    <div class="allCreatePostDetail">
                        <div class="allCreatePostDetailItemsTitle">
                            جزییات
                        </div>
                        <div class="allCreatePostDetailItems">
                            <div class="allCreatePostDetailItem">
                                <label>عنوان* :</label>
                                <input type="text" name="title" placeholder="عنوان را وارد کنید">
                                <div id="validation-title"></div>
                            </div>
                            <div class="allCreatePostDetailItem">
                                <label>ویدئو :</label>
                                <input type="text" name="video" placeholder="لینک را وارد کنید">
                                <div id="validation-video"></div>
                            </div>
                            <div class="allCreatePostDetailItem">
                                <label>پیوند(slug) :</label>
                                <input type="text" name="slug" placeholder="پیوند را وارد کنید">
                            </div>
                            <div class="allCreatePostDetailItem">
                                <label>مدت زمان مطالعه* :</label>
                                <input type="text" name="time" placeholder="به دقیقه وارد کنید">
                            </div>
                            <div class="allCreatePostDetailItem">
                                <label>وضعیت* :</label>
                                <select name="status" id="status">
                                    <option value="0">پیشنویس</option>
                                    <option value="1" selected>منتشر شده</option>
                                </select>
                                <div id="validation-status"></div>
                            </div>
                            <div class="allCreatePostDetailItem">
                                <label for="s1d" class="allCreatePostDetailItemData">
                                    پیشنهاد
                                    <input id="s1d" type="checkbox" name="suggest" class="switch" >
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
                                <label>برچسب :</label>
                                <select class="tags-multiple" name="tags" multiple="multiple">
                                    @foreach ($tags as $tag)
                                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="filemanager">
            @include('admin.filemanager')
        </div>
    </div>
@endsection

@section('scripts3')
    <script>
        $(document).ready(function(){
            $('.filemanager').hide();
            $('.addImageButton').click(function(){
                $('.filemanager').show();
            });
            $('.tags-multiple').select2({
                placeholder: 'برچسب را انتخاب کنید ...',
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
            $( 'textarea.editor' ).ckeditor();
            $("button[name='createPost']").click(function(event){
                $("button[name='createPost']").text('صبر کنید ...');
                var title = $(".allCreatePostDetailItems input[name='title']").val();
                var slug = $("input[name='slug']").val();
                var status = $("select[name='status']").val();
                var body = $(".allCreatePostItem textarea[name='body']").val();
                var suggest = $("input[name='suggest']").is(":checked");
                var titleSeo = $("input[name='titleSeo']").val();
                var video = $("input[name='video']").val();
                var time = $("input[name='time']").val();
                var bodySeo = $("textarea[name='bodySeo']").val();
                var keywordSeo = $("input[name='keywordSeo']").val();
                var imageAlt = $("input[name='imageAlt']").val();
                var tags = [];
                var cats = [];
                var image = [];
                $(".getImagePic").each(function(){
                    image= this.lastElementChild.src;
                });
                $("select[name='cats'] :selected").each(function(){
                    cats.push($(this).val());
                });
                $("select[name='tags'] :selected").each(function(){
                    tags.push($(this).val());
                });

                var form = {
                    "_token": "{{ csrf_token() }}",
                    title:title,
                    slug:slug,
                    status:status,
                    suggest:suggest,
                    time:time,
                    body:body,
                    titleSeo:titleSeo,
                    video:video,
                    bodySeo:bodySeo,
                    keywordSeo:keywordSeo,
                    imageAlt:imageAlt,
                    cats:JSON.stringify(cats),
                    tags:JSON.stringify(tags),
                    image: image,
                };
                $.ajax({
                    url: "/admin/blog/create",
                    type: "post",
                    data: form,
                    success: function (data) {
                        $.toast({
                            text: "بلاگ اضافه شد", // Text that is to be shown in the toast
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
                        window.location.href="/admin/blog";
                    },
                    error: function (xhr) {
                        $("button[name='createPost']").text('ارسال اطلاعات');
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
            });
        })
    </script>
@endsection

@section('jsScript')
    <script src="/js/jquery.toast.min.js"></script>
    <script src="/js/select2.min.js"></script>
    <script src="/js/editor/ckeditor.js"></script>
    <script src="/js/editor/adapters/jquery.js"></script>
@endsection

@section('links')
    <link rel="stylesheet" href="/css/select2.min.css"/>
    <link rel="stylesheet" href="/css/jquery.toast.min.css"/>
@endsection
