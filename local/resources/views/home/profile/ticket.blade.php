@extends('home.master')

@section('title' , __('messages.ticket1'))
@section('content')
    <div class="allProfileIndex width">
        @include('home.profile.list' , ['tab' => 5])
        <div class="profileIndexTicket">
            <div class="titleTicket">
                <h1>تیکت ها</h1>
                <button>افزودن تیکت</button>
            </div>
            @if (\Session::has('message'))
                <div class="alert">
                    {!! \Session::get('message') !!}
                </div>
            @endif
            <table>
                <tr>
                    <th>عنوان</th>
                    <th>زمان ثبت</th>
                    <th>عملیات</th>
                </tr>
                @foreach($tickets as $item)
                    <tr>
                        <td>
                            <span>{{$item->body}}</span>
                        </td>
                        <td>
                            <span>{{$item->updated_at}}</span>
                        </td>
                        <td>
                            <div class="buttons">
                                <button id="{{$item->id}}" class="editButton">نمایش</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
            <div class="allTickets" style="display: none">
                <div class="container clearfix">
                    <div class="chat">
                        <div class="chat-header clearfix">
                            @if(auth()->user()->profile)
                                <img src="{{auth()->user()->profile}}" alt="{{auth()->user()->name}}">
                            @else
                                <img src="/img/user.png" alt="{{auth()->user()->name}}">
                            @endif
                            <div class="chat-with">گفتگو با مدیریت</div>
                        </div>
                        <div class="chat-history">
                            <ul></ul>
                        </div>
                        <div class="chat-message clearfix">
                            <div class="messageData">
                                <textarea name="body" placeholder ="متن خود را وارد کنید..."></textarea>
                                <span id="btnFileTicket" style="display:none;">یک فایل آماده وجود دارد</span>
                            </div>
                            <div class="chatButtons">
                                <button class="sendTicket">
                                    <i>
                                        <svg class="icon">
                                            <use xlink:href="#sendTicket"></use>
                                        </svg>
                                    </i>
                                    ارسال
                                </button>
                                <button class="btnFile">
                                    <i>
                                        <svg class="icon">
                                            <use xlink:href="#add-document"></use>
                                        </svg>
                                    </i>
                                    پیوست فایل
                                </button>
                                <button class="btnBack">
                                    <i>
                                        <svg class="icon">
                                            <use xlink:href="#cancel"></use>
                                        </svg>
                                    </i>
                                    بازگشت
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sendFiles" style="display:none;">
                <div class="sendPos">
                    <div class="sendImage">
                        <input type="file" id="post_cover" class="dropify" name="image"/>
                    </div>
                </div>
            </div>
            <form method="post" action="/profile/ticket/send-ticket" enctype="multipart/form-data" class="createTicket" style="display:none;">
                @csrf
                <p>در صورت تمایل میتوانید پیام خودتان را ثبت کنید</p>
                <label class="bodyLabel" for="ticket1name">
                    عنوان* :
                    <input type="text" id="ticket1name" name="title" placeholder="عنوان خود را وارد کنید">
                </label>
                <label class="bodyLabel" for="ticket1body">
                    توضیح* :
                    <textarea id="ticket1body" name="body" placeholder="توضیح خود را وارد کنید"></textarea>
                </label>
                <div class="sendImage">
                    <input type="file" id="post_cover" class="dropify" name="image"/>
                </div>
                <div class="buttons">
                    <button class="submit">ارسال پیام</button>
                    <div class="cancel">انصراف</div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scriptPage')
    <link rel="stylesheet" href="/css/dropify.min.css"/>
    <link rel="stylesheet" href="/css/jquery.toast.min.css"/>
    <script src="/js/jquery.toast.min.js"></script>
    <script src="/js/dropify.min.js"></script>
    <script>
        $(document).mouseup(function(e)
        {
            var container = $(".sendFiles");

            if (container.is(e.target) && container.has(e.target).length === 0)
            {
                if($(".sendFiles input[name='image']").val()){
                    $('#btnFileTicket').show()
                }else{
                    $('#btnFileTicket').hide()
                }
                container.hide();
            }
        });
        $(document).ready(function(){
            var ticket = 0;
            var user = {!! json_encode(auth()->user(), JSON_HEX_TAG) !!};
            $('.btnFile').click(function (){
                $('.sendFiles').toggle();
            })
            $('.profileIndexTicket .titleTicket button').click(function (){
                $('.profileIndexTicket table').hide();
                $('.profileIndexTicket .allTickets').hide();
                $('.profileIndexTicket .sendFiles').hide();
                $('.profileIndexTicket .createTicket').show();
            })
            $('.createTicket .cancel').click(function (){
                $('.profileIndexTicket table').show();
                $('.profileIndexTicket .allTickets').hide();
                $('.profileIndexTicket .sendFiles').hide();
                $('.profileIndexTicket .createTicket').hide();
            })
            $(document).on('click','.profileIndexTicket table tr .editButton',function () {
                ticket = $(this).attr('id');
                $('.allTickets').show();
                $('.allProfileIndex table').hide();
                getMyTicket();
            })
            $(document).on('click','.profileIndexTicket .btnBack',function () {
                ticket = 0;
                $('.chat .chat-history .clearfix').remove();
                $('.allTickets').hide();
                $('.allProfileIndex table').show();
            })
            $('.chat-message .sendTicket').click(function (e){
                e.preventDefault();
                let formData = new FormData();
                formData.append('_token', "{{ csrf_token() }}");
                formData.append('title', 'پاسخ تیکت');
                formData.append('type', 0);
                formData.append('body', $('.chat-message textarea').val());
                formData.append('parent_id', ticket);
                var fileInput = $(".sendFiles input[name='image']")[0];
                formData.append('image', fileInput.files[0]);
                $.ajax({
                    url: '/profile/ticket/send-ticket',
                    type: "post",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        $('.chat-message textarea').val('');
                        $('.chat .chat-history .clearfix').remove();
                        getMyTicket();
                    },
                    error: function (xhr) {
                        alert('متن خود را وارد کنید.')
                    }
                });
            })
            function getMyTicket(){
                if(ticket >= 1){
                    var form = {
                        "_token": "{{ csrf_token() }}",
                        ticket:ticket,
                    };
                    $.ajax({
                        url: '/profile/ticket/get-ticket',
                        type: "post",
                        data: form,
                        success: function (data) {
                            $('.chat .chat-history ul').append(
                                '<li class="clearfix">'+
                                '<div class="message-data '+(data.user.id != user.id ? 'align-left' : '')+'">'+
                                '<span class="message-data-name" >'+data.user.name+'</span>'+
                                '<span class="message-data-time" >('+data.created_at+')</span>'+
                                '</div>'+
                                '<div class="message ' + (data.user.id != user.id ? 'other-message float-left' : 'my-message') + '">' + data.body.replace(/\n/g, '<br>')+
                                (data.file != '' && data.file != null ? '<a download href="'+data.file+'"><i><svg class="icon"><use xlink:href="#files"></use></svg></i></a>' : '')+
                                '</div></li>'
                            );
                            if(data.tickets.length >= 1) {
                                $.each(data.tickets, function () {
                                    $('.chat .chat-history ul').append(
                                        '<li class="clearfix">' +
                                        '<div class="message-data ' + (this.user.id != user.id ? 'align-left' : '') + '">' +
                                        '<span class="message-data-name">' + this.user.name + '</span>' +
                                        '<span class="message-data-time" >('+this.created_at+')</span>'+
                                        '</div>' +
                                        '<div class="message ' + (this.user.id != user.id ? 'other-message float-left' : 'my-message') + '">' + this.body.replace(/\n/g, '<br>')+
                                        (this.file != '' && this.file != null ? '<a download href="'+this.file+'"><i><svg class="icon"><use xlink:href="#files"></use></svg></i></a>' : '') +
                                        '</div></li>'
                                    );
                                })
                            }
                            $('.allTickets .chat .chat-history').animate({ scrollTop: $('.allTickets .chat .chat-history').height()+2000 }, 1000);
                        },
                    });
                }
            }
            $('.dropify').dropify({
                messages: {
                    default: "فایل پیوست خود را اینجا قرار دهید.",
                    replace: "برای جایگزین کردن تصویر بکشید و رها کنید.",
                    remove: "حذف تصویر",
                    error: "خطایی به وجود آمده است. دوباره تلاش کنید.",
                }
            });
        })
    </script>
@endsection
