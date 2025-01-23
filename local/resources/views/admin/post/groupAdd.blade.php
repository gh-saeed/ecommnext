@extends('admin.master')

@section('tab',1)
@section('content')
    <div class="allCreateGroup">
        <form action="/admin/product/group/create" enctype="multipart/form-data" method="post" class="createGroup">
            @csrf
            <div class="products"></div>
            <div class="buttons">
                <div class="add">+افزودن محصول</div>
                <button class="createF" style="background: blue">جهت ثبت نهایی کلیک کنید</button>
            </div>
        </form>
        <div class="filemanager">
            @include('admin.filemanager')
        </div>
    </div>
@endsection

@section('scripts3')
    <script>
        $(document).ready(function(){
            var users = {!! json_encode($users, JSON_HEX_TAG) !!};
            var carriers = {!! json_encode($carriers, JSON_HEX_TAG) !!};
            var brands = {!! json_encode($brands, JSON_HEX_TAG) !!};
            var cats = {!! json_encode($cats, JSON_HEX_TAG) !!};
            var users1 = ''
            var carriers1 = ''
            var brands1 = ''
            var cats1 = ''
            $.each(users,function (){
                users1 += `<option value="${this.id}">${this.name}</option>`
            });
            $.each(carriers,function (){
                carriers1 += `<option value="${this.id}">${this.name}</option>`
            });
            $.each(brands,function (){
                brands1 += `<option value="${this.id}">${this.name}</option>`
            });
            $.each(cats,function (){
                cats1 += `<option value="${this.id}">${this.name}</option>`
            });
            $('.filemanager').hide();
            $('.addImageButton').click(function(){
                $('.filemanager').show();
            });
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
            $(".createGroup .add").click(function (){
                $(".createGroup .products").append(
                    $(`<div class="container">
                    <div class="items">
                        <div class="item">
                            <label>عنوان* :</label>
                            <input type="text" name="title[]" placeholder="عنوان را وارد کنید">
                            <div id="validation-title"></div>
                        </div>
                        <div class="item">
                            <label>تعداد برای فروش* :</label>
                            <input type="text" name="count[]" placeholder="تعداد را وارد کنید">
                            <div id="validation-count"></div>
                        </div>
                        <div class="item">
                            <label>زمان آماده سازی* :</label>
                            <input type="text" name="prepare[]" placeholder="مثال : 2">
                        </div>
                        <div class="item">
                            <label>تخمین زمان تحویل* :</label>
                            <input type="text" name="time[]" placeholder="مثال : 2">
                        </div>
                        <div class="item">
                            <label>وزن :</label>
                            <input type="text" name="weight[]" placeholder="وزن را وارد کنید">
                        </div>
                        <div class="item">
                            <label>پیوند(slug) :</label>
                            <input type="text" name="slug[]" placeholder="پیوند را وارد کنید">
                        </div>
                        <div class="item">
                            <label>درصد تخفیف(50) :</label>
                            <input type="text" name="off[]" placeholder="تخفیف را وارد کنید">
                        </div>
                        <div class="item">
                            <label>قیمت فروش به کاربر* :</label>
                            <input type="text" name="price[]" placeholder="قیمت را وارد کنید">
                            <div id="validation-price"></div>
                        </div>
                        <div class="item">
                            <label>تصویر* :</label>
                            <input type="file" name="file[]">
                            <div id="validation-price"></div>
                        </div>
                        <div class="item">
                            <label>توضیحات :</label>
                            <textarea name="body[]" class="body"></textarea>
                        </div>
                    </div>
                    <div class="items">
                        <div class="item">
                            <label>وضعیت* :</label>
                            <select name="status[]" id="status">
                                <option value="0">پیشنویس</option>
                                <option value="1">منتشر شده</option>
                            </select>
                            <div id="validation-status"></div>
                        </div>
                        <div class="item2">
                            <label>غرفه دار :</label>
                            <select class="users-multiple" name="user_id[]">${users1}</select>
                        </div>
                        <div class="item2">
                            <label>دسته بندی :</label>
                            <select class="cats-multiple" name="cats[]">${cats1}</select>
                        </div>
                        <div class="item2">
                            <label>برند :</label>
                            <select class="brands-multiple" name="brands[]">${brands1}</select>
                        </div>
                        <div class="item2">
                            <label>حامل :</label>
                            <select class="carrier-multiple" name="carriers[]">${carriers1}</select>
                        </div>
                    </div>
                </div>`)
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
