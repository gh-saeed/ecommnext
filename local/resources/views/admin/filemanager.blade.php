<div class="allFileManagers">
    <div class="fileManagers">
        <div class="closeFile">
            <svg class="icon">
                <use xlink:href="#cancel"></use>
            </svg>
        </div>
        <div class="tabs">
            <div class="tab" id="showImageContainer">نمایش تصاویر</div>
            <div class="tab" id="addImageContainer">افزودن تصویر</div>
        </div>
        <div class="allImages">
            <ul id="images"></ul>
            <div class="pages">
                <div class="page" id="page1">قبلی</div>
                <div class="page" id="page2">بعدی</div>
            </div>
        </div>
        <form method="post" id="upload-image-form" enctype="multipart/form-data">
            @csrf
            <div class="sendImage">
                <input type="file" id="post_cover" class="dropify" name="image"/>
            </div>
            <button type="submit" id="upload-image">آپلود</button>
        </form>
    </div>
</div>

@section('scripts4')
<script>
    $(document).ready(function(){
        var page1 = 0;
        $('#upload-image-form').hide();
        $('#showImageContainer').attr('class' , 'tab active');
        $('.closeFile').click(function(){
            $('.filemanager').toggle();
        });
        $('#addImageContainer').click(function (){
            $('#upload-image-form').toggle();
            $('#addImageContainer').attr('class' , 'tab active');
            $('#showImageContainer').attr('class' , 'tab');
            $('.allImages').toggle();
        });
        $('#showImageContainer').click(function (){
            $('#showImageContainer').attr('class' , 'tab active');
            $('#addImageContainer').attr('class' , 'tab');
            $('#upload-image-form').toggle();
            $('.allImages').toggle();
        });
        getImages();
        $('.allFileManagers .pages #page1').click(function(e) {
            page1 != 0 ? page1 = parseInt(page1) - 1 : 0;
            getImages();
        })
        $('.allFileManagers .pages #page2').click(function(e) {
            page1 = parseInt(page1) + 1;
            getImages();
        })
        $('#upload-image-form').submit(function(e) {
            $('#upload-image-form #upload-image').text('صبر کنید ...');
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                type:'POST',
                url: `/admin/upload-image`,
                data: formData,
                contentType: false,
                processData: false,
                success: (response) => {
                    $('#upload-image-form #upload-image').text('آپلود');
                    $.toast({
                        text: "فایل اضافه شد", // Text that is to be shown in the toast
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
                    $('.getImageItem').append(
                        $('<div class="getImagePic"><input type="hidden" name="image" value="'+response.url+'"><i><svg class="deleteImg"><use xlink:href="#trash"></use></svg></i><img src="'+response.url+'"></div>')
                            .on('click' , '.deleteImg',function(ss){
                                ss.currentTarget.parentElement.parentElement.remove();
                            })
                    );
                    $('.filemanager').hide();
                    $('#imageTooltip').hide();
                },
                error: function(response){
                    $('#upload-image-form #upload-image').text('آپلود');
                    $('#image-input-error').text(response.responseJSON.errors.file);
                }
            });
        });
        function getImages(){
            $.ajax({
                type:'GET',
                url: `/admin/get-image?page=${page1}`,
                contentType: false,
                processData: false,
                success: (response) => {
                    if(response['data'].length >= 1){
                        $('.allImages ul').children('li').remove();
                        $.each(response['data'],function(){
                            $('#images').append(
                                $('<li><img src="'+this.url+'" alt=""></li>')
                                    .click(function(){
                                        $('.filemanager').hide();
                                        $('#imageTooltip').hide();
                                        $('.getImageItem').append(
                                            $('<div class="getImagePic"><input type="hidden" name="image" value="'+this.lastChild.src+'"><i><svg class="deleteImg"><use xlink:href="#trash"></use></svg></i><img src="'+this.lastChild.src+'"></div>')
                                                .on('click' , '.deleteImg',function(ss){
                                                    ss.currentTarget.parentElement.parentElement.remove();
                                                })
                                        );
                                    })
                            );
                        });
                    }
                    if(response['data'].length == 0 && page1 != 0){
                        page1 = parseInt(page1) - 1;
                        $.toast({
                            text: "اتمام تصاویر", // Text that is to be shown in the toast
                            heading: 'پایان', // Optional heading to be shown on the toast
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
                    }
                },
            });
        }
        $('.dropify').dropify({
            messages: {
                default: "بکشید و رها کنید یا برای انتخاب کلیک کنید.",
                replace: "برای جایگزین کردن تصویر بکشید و رها کنید.",
                remove: "حذف تصویر",
                error: "خطایی به وجود آمده است. دوباره تلاش کنید.",
            }
        });
    })
</script>
@endsection

@section('links2')
    <link rel="stylesheet" href="/css/dropify.min.css"/>
@endsection

@section('jsScript2')
    <script src="/js/dropify.min.js"></script>
@endsection
