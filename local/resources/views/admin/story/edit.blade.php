@extends('admin.master')

@section('tab',38)
@section('content')
    <div class="allCreatePost">
        <div class="allCreatePost">
            <div class="allPostPanelTop">
                <h1>ویرایش استوری</h1>
                <div class="allPostTitle">
                    <a href="/admin/dashboard">داشبورد</a>
                    <span>/</span>
                    <a href="/admin/story">همه استوری ها</a>
                    <span>/</span>
                    <a href="/admin/story/{{$story->id}}/edit">ویرایش استوری</a>
                </div>
            </div>
            <div class="allCreatePostData">
                <div class="allCreatePostSubject">
                    <div class="allCreatePostItem">
                        <label>عنوان* :</label>
                        <input type="text" name="title" value="{{$story->title}}" placeholder="عنوان را وارد کنید">
                        <div id="validation-title"></div>
                    </div>
                    <div class="allCreatePostItem">
                        <label>نوع استوری* :</label>
                        <select name="type" id="type">
                            <option value="0">تصویر</option>
                            <option value="1" selected>ویدئو</option>
                        </select>
                        <div id="validation-status"></div>
                    </div>
                    <div class="allCreatePostItem type0">
                        <label>تصویر :</label>
                        <input type="text" name="image" value="{{$story->image}}" placeholder="{{url('/pic.png')}}">
                        <div id="validation-image"></div>
                    </div>
                    <div class="allCreatePostItem type1">
                        <label>ویدئو (در بخش گالری میتوانید آپلود کنید) :</label>
                        <input type="text" name="image" value="{{$story->image}}" placeholder="{{url('/video.mp4')}}">
                        <div id="validation-image"></div>
                    </div>
                    <div class="addImageButton">برای انتخاب کاور استوری کلیک کنید</div>
                    <div class="sendGallery">
                        <div class="getImageItem">
                            <span id="imageTooltip">تصاویر خود را وارد کنید</span>
                        </div>
                    </div>
                    <button class="button" name="createPost" type="submit">ارسال اطلاعات</button>
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
            var posts = {!! $story->toJson() !!};
            $('.filemanager').hide();
            $('.addImageButton').click(function(){
                $('.filemanager').show();
                $(".getImagePic").remove();
            });
            if(posts.type){
                $('.type0').hide();
            }else{
                $('.type1').hide();
            }
            $("select[name='type']").val(posts.type);
            $("select[name='type']").change(function(){
                $('.type0').hide();
                $('.type1').hide();
                $('.type'+$(this).val()).show();
            });
            if(posts.cover){
                $('#imageTooltip').hide();
                $('.getImageItem').append(
                    $('<div class="getImagePic"><i><svg class="deleteImg"><use xlink:href="#trash"></use></svg></i><img src="'+posts.cover+'"></div>')
                        .on('click' , '.deleteImg',function(ss){
                            ss.currentTarget.parentElement.parentElement.remove();
                        })
                );
            }
            $("button[name='createPost']").click(function(event){
                $("button[name='createPost']").text('صبر کنید ...');
                var title = $(".allCreatePostData input[name='title']").val();
                var type = $(".allCreatePostData select[name='type']").val();
                var image = type == 1 ? $(".allCreatePostData .type1 input[name='image']").val() : $(".allCreatePostData .type0 input[name='image']").val();
                var cover = '';
                $(".getImagePic").each(function(){
                    cover = this.lastElementChild.src;
                });
                var form = {
                    "_token": "{{ csrf_token() }}",
                    title:title,
                    type:type,
                    image:image,
                    cover: cover,
                };
                $.ajax({
                    url: "/admin/story/"+posts.id+"/edit",
                    type: "put",
                    data: form,
                    success: function (data) {
                        $.toast({
                            text: "استوری اضافه شد", // Text that is to be shown in the toast
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
                        window.location.href="/admin/story";
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
                            $('#validation-' + key).append('<div class="alert alert-danger">این مورد اجباری است</div');
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
