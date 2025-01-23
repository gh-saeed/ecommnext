@extends('home.master')

@section('title' , __('messages.seller'))
@section('content')
    <div class="allBecomeSeller width">
        @if (\Session::has('success'))
            <div class="success">
                {!! \Session::get('success') !!}
            </div>
        @endif
        <form method="post" action="/send-document" enctype="multipart/form-data" class="uploadDocument">
            @csrf
            <h3>{{__('messages.seller_pic_natural')}}</h3>
            <ul>
                <li>{{__('messages.seller_pic_natural1')}}</li>
                <li>{{__('messages.seller_pic_natural2')}}</li>
                <li>{{__('messages.seller_pic_natural3')}}</li>
            </ul>
            <div class="sendFileItem">
                <div class="sendImage">
                    <input type="file" id="post_cover" class="dropify" name="frontImage"/>
                </div>
            </div>
            <div class="sendFileItem">
                <div class="sendImage">
                    <input type="file" id="post_cover" class="dropify2" name="backImage"/>
                </div>
            </div>
            <div class="buttons">
                <button type="submit" id="upload-image-form">ارسال مدارک</button>
            </div>
        </form>
    </div>
@endsection

@section('scriptPage')
    <link rel="stylesheet" href="/css/dropify.min.css"/>
    <script src="/js/dropify.min.js"></script>
    <script>
        $(document).ready(function(){
            var seller_front1 = {!! json_encode(__('messages.seller_front'), JSON_HEX_TAG) !!};
            var seller_back1 = {!! json_encode(__('messages.seller_back'), JSON_HEX_TAG) !!};
            var delete_pic1 = {!! json_encode(__('messages.delete_pic'), JSON_HEX_TAG) !!};
            var seller_front2 = {!! json_encode(__('messages.seller_front2'), JSON_HEX_TAG) !!};
            var delete_pic2 = {!! json_encode(__('messages.delete_pic2'), JSON_HEX_TAG) !!};
            $('.dropify').dropify({
                messages: {
                    default: seller_front1,
                    replace: seller_front2,
                    remove: delete_pic1,
                    error: delete_pic2,
                }
            });
            $('.dropify2').dropify({
                messages: {
                    default: seller_back1,
                    replace: seller_front2,
                    remove: delete_pic1,
                    error: delete_pic2,
                }
            });
        })
    </script>
@endsection
