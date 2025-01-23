@extends('admin.master')

@section('tab',14)
@section('content')
    <div class="allCreatePost">
        <div class="allCreatePost">
            <div class="allPostPanelTop">
                <h1>افزودن برگه</h1>
                <div class="allPostTitle">
                    <a href="/admin">داشبورد</a>
                    <span>/</span>
                    <a href="/admin/page">همه برگه ها</a>
                    <span>/</span>
                    <a href="/admin/page/create">افزودن برگه</a>
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
                        <label>توضیحات :</label>
                        <textarea name="body" class="editor"></textarea>
                        <div id="validation-body"></div>
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
                                <label>زبان* :</label>
                                <select name="language">
                                    <option value="fa" selected>فارسی</option>
                                    <option value="en">انگلیسی</option>
                                    <option value="ar">عربی</option>
                                    <option value="tr">ترکی</option>
                                </select>
                                <div id="validation-language"></div>
                            </div>
                            <div class="allCreatePostDetailItem">
                                <label>پیوند(slug) :</label>
                                <input type="text" name="slug" placeholder="پیوند را وارد کنید">
                            </div>
                            <div class="allCreatePostDetailItem">
                                <label>موقعیت جغرافیایی (Latitude) :</label>
                                <input type="text" name="lat" placeholder="موقعیت را وارد کنید">
                            </div>
                            <div class="allCreatePostDetailItem">
                                <label>موقعیت جغرافیایی (Longitude) :</label>
                                <input type="text" name="longitude" placeholder="موقعیت را وارد کنید">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts3')
    <script>
        $(document).ready(function(){
            $( 'textarea.editor' ).ckeditor();
            $("button[name='createPost']").click(function(event){
                var title = $(".allCreatePostDetailItems input[name='title']").val();
                var slug = $("input[name='slug']").val();
                var body = $(".allCreatePostItem textarea[name='body']").val();
                var titleSeo = $("input[name='titleSeo']").val();
                var bodySeo = $("textarea[name='bodySeo']").val();
                var keywordSeo = $("input[name='keywordSeo']").val();
                var lat = $("input[name='lat']").val();
                var longitude = $("input[name='longitude']").val();
                var language = $("select[name='language']").val();

                var form = {
                    "_token": "{{ csrf_token() }}",
                    title:title,
                    slug:slug,
                    body:body,
                    titleSeo:titleSeo,
                    bodySeo:bodySeo,
                    keywordSeo:keywordSeo,
                    lat:lat,
                    longitude:longitude,
                    language:language,
                };

                $.ajax({
                    url: "/admin/page/create",
                    type: "post",
                    data: form,
                    success: function (data) {
                        $.toast({
                            text: "برگه اضافه شد", // Text that is to be shown in the toast
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
                        window.location.href="/admin/page";
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
