@extends('home.master')

@section('title' , __('messages.edit_user') . ' - ')
@section('content')
    <div class="allProfileIndex width">
        @include('home.profile.list' , ['tab' => 8])
        <div class="allUserIndexInfo">
            <form method="post" id="upload-image-form" enctype="multipart/form-data">
                @csrf
                <div class="sendImage">
                    <input type="file" id="post_cover" class="dropify" name="image"/>
                </div>
                <button type="submit" id="upload-image">{{__('messages.upload')}}</button>
            </form>
            <form method="post" action="/change-all-user-info">
                @csrf
                <div class="allUserIndexInfoPersonal">
                    <div class="allUserIndexInfoPersonalItems">
                        <div class="allUserIndexInfoPersonalItem">
                            <label>{{__('messages.user_name')}}</label>
                            <input type="text" placeholder="{{__('messages.user_name')}}" name="name" value="{{auth()->user()->name}}">
                        </div>
                        <div class="allUserIndexInfoPersonalItem">
                            <label>{{__('messages.edit_pass1')}}</label>
                            <input type="password" placeholder="{{__('messages.edit_pass1')}}" name="password">
                        </div>
                    </div>
                    <div class="allUserIndexInfoPersonalItems">
                        <div class="allUserIndexInfoPersonalItem">
                            <label>{{__('messages.user_body')}}</label>
                            <textarea placeholder="{{__('messages.user_body')}}" name="body">{{auth()->user()->body}}</textarea>
                        </div>
                    </div>
                </div>
                <button class="infoButton">{{__('messages.user_edit')}}</button>
            </form>
        </div>
    </div>
@endsection

@section('scriptPage')
    <link rel="stylesheet" href="/css/dropify.min.css"/>
    <script src="/js/dropify.min.js"></script>
    <script>
        $(document).ready(function(){
            var wait1 = {!! json_encode(__('messages.wait'), JSON_HEX_TAG) !!};
            var upload1 = {!! json_encode(__('messages.upload'), JSON_HEX_TAG) !!};
            var success1 = {!! json_encode(__('messages.success'), JSON_HEX_TAG) !!};
            var change_logo1 = {!! json_encode(__('messages.change_logo'), JSON_HEX_TAG) !!};
            var select_logo1 = {!! json_encode(__('messages.select_logo'), JSON_HEX_TAG) !!};
            var delete_pic = {!! json_encode(__('messages.delete_pic'), JSON_HEX_TAG) !!};
            var delete_pic2 = {!! json_encode(__('messages.delete_pic2'), JSON_HEX_TAG) !!};
            $('#upload-image-form').submit(function(e) {
                $(".upload-image-form button").text(wait1);
                if($(".upload-image-form button").text() != wait1){
                    e.preventDefault();
                    let formData = new FormData(this);

                    $.ajax({
                        type:'POST',
                        url: `/profile/upload-profile`,
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: (response) => {
                            $(".upload-image-form button").text(upload1);
                            if (response) {
                                $.toast({
                                    text: change_logo1, // Text that is to be shown in the toast
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
                            }
                        },
                        error: function(response){
                            $('#image-input-error').text(response.responseJSON.errors.file);
                        }
                    });
                }else{
                    e.preventDefault();
                    let formData = new FormData(this);
                    $.ajax({
                        type:'get',
                        url: `/`,
                        data: formData,
                        contentType: false,
                        processData: false,
                    });
                }
            });

            $('.dropify').dropify({
                messages: {
                    default: select_logo1,
                    replace: select_logo1,
                    remove: delete_pic,
                    error: delete_pic2,
                }
            });
        })
    </script>
@endsection
