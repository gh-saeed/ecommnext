<div class="allFileManagers">
    <div class="fileManagers">
        <div class="closeFile">
            <svg class="icon">
                <use xlink:href="#cancel"></use>
            </svg>
        </div>
        <div class="tabs">
            <div class="tab" id="showImageContainer">{{__('messages.show_pic')}}</div>
            <div class="tab" id="addImageContainer">{{__('messages.add_pic3')}}</div>
        </div>
        <div class="allImages">
            <ul id="images"></ul>
        </div>
        <form method="post" id="upload-image-form" enctype="multipart/form-data">
            @csrf
            <div class="sendImage">
                <input type="file" id="post_cover" class="dropify" name="image"/>
            </div>
            <button type="submit" id="upload-image">{{__('messages.upload')}}</button>
        </form>
    </div>
</div>

@section('scripts4')
    <script>
        $(document).ready(function(){
            $('#upload-image-form').hide();
            $('#showImageContainer').attr('class' , 'tab active');
            $('.closeFile').click(function(){
                $('.filemanager').toggle();
            });
            $('#addImageContainer').click(function (){
                $('#addImageContainer').attr('class' , 'tab active');
                $('#showImageContainer').attr('class' , 'tab');
                $('#upload-image-form').toggle();
                $('.allImages').toggle();
            });
            $('#showImageContainer').click(function (){
                $('#showImageContainer').attr('class' , 'tab active');
                $('#addImageContainer').attr('class' , 'tab');
                $('#upload-image-form').toggle();
                $('.allImages').toggle();
            });
            getPics()
            var file_added = {!! json_encode(__('messages.file_added'), JSON_HEX_TAG) !!};
            var success1 = {!! json_encode(__('messages.success'), JSON_HEX_TAG) !!};
            var delete_pic = {!! json_encode(__('messages.delete_pic'), JSON_HEX_TAG) !!};
            var delete_pic2 = {!! json_encode(__('messages.delete_pic2'), JSON_HEX_TAG) !!};
            var delete_pic3 = {!! json_encode(__('messages.delete_pic3'), JSON_HEX_TAG) !!};
            var seller_front2 = {!! json_encode(__('messages.seller_front2'), JSON_HEX_TAG) !!};
            $('#upload-image-form').submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);

                $.ajax({
                    type:'POST',
                    url: `/seller/upload-image`,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: (response) => {
                        if (response) {
                            $.toast({
                                text: file_added, // Text that is to be shown in the toast
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
                            getPics();
                        }
                    },
                    error: function(response){
                        $('#image-input-error').text(response.responseJSON.errors.file);
                    }
                });
            });

            function getPics(){
                $('#images li').remove();
                $('#upload-image-form').hide();
                $('.allImages').show();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type:'GET',
                    url: `/seller/get-image`,
                    contentType: false,
                    processData: false,
                    success: (response) => {
                        $.each(response,function(){
                            $('#images').append(
                                $('<li><img src="'+this+'" alt=""></li>')
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
                    },
                });
            }
            $('.dropify').dropify({
                messages: {
                    default: delete_pic3,
                    replace: seller_front2,
                    remove: delete_pic,
                    error: delete_pic2,
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
