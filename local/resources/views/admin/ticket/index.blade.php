@extends('admin.master')

@section('tab' , 17)
@section('content')
    <div class="allTicketIndex">
        @if (\Session::has('message'))
            <div class="success">
                {!! \Session::get('message') !!}
            </div>
        @endif
        <div class="allTickets">
            <div class="container clearfix">
                <div class="people-list" id="people-list">
                    <ul class="list">
                    </ul>
                </div>
                <div class="chat" style="display: none">
                    <div class="chat-header clearfix">
                        <img src="" />
                        <div class="chat-with"></div>
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
                            <button class="closeTicket">
                                <i>
                                    <svg class="icon">
                                        <use xlink:href="#closed"></use>
                                    </svg>
                                </i>
                                حذف تیکت
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sendFiles" style="display:none;">
            <div class="sendPos">
                <div class="sendGallery">
                    <div class="getImageItem">
                        <span id="imageTooltip">پیوست را وارد کنید</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="filemanager firstImage" style="display:none;">
            @include('admin.filemanager')
        </div>
    </div>
@endsection

@section('scripts3')
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
            var ticket = '';
            var user = {!! json_encode($user, JSON_HEX_TAG) !!};
            $('.btnFile').click(function (){
                $('.sendFiles').toggle();
            })
            $('.sendGallery').click(function (){
                $('.filemanager').toggle();
            })
            $('.chat-message .sendTicket').click(function (){
                var form = {
                    "_token": "{{ csrf_token() }}",
                    parent:ticket,
                    file_id:$(".sendFiles input[name='image']").val(),
                    body:$('.chat-message textarea').val(),
                    title:'پاسخ تیکت',
                };
                $.ajax({
                    url: '/admin/ticket/send-ticket',
                    type: "post",
                    data: form,
                    success: function (data) {
                        if($('.getImagePic')){
                            $('.getImagePic').remove();
                        }
                        $('.chat-message textarea').val('');
                        getMyTicket();
                    },
                    error: function (xhr) {
                        alert('متن خود را وارد کنید.')
                    }
                });
            })
            $(document).on('click','.people-list ul li',function () {
                ticket = this.id;
                $('.allTickets .chat').show();
                getMyTicket();
            })
            $('.closeTicket').on('click', function(){
                Swal.fire({
                    title: 'از حذف تیکت مطمئن هستید؟',
                    text: "امکان ارسال پیام مجدد وجود نخواهد داشت",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'حذف تیکت',
                    cancelButtonText: 'انصراف',
                    confirmButtonColor: '#30d633',
                    cancelButtonColor: '#d33',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = {
                            "_token": "{{ csrf_token() }}",
                            ticket:ticket,
                        };
                        $.ajax({
                            type:'POST',
                            url: `/admin/chat/delete`,
                            data: form,
                            success: (response) => {
                                window.location.reload();
                            },
                        });
                    } else {
                        result.dismiss == Swal.DismissReason.cancel
                    }
                })
            })
            getParent();
            function getParent(){
                var form = {
                    "_token": "{{ csrf_token() }}",
                };
                $.ajax({
                    url: '/admin/ticket/get-parent',
                    type: "post",
                    data: form,
                    success: function (data) {
                        $('.allTickets .container .list li').remove();
                        $.each(data,function (){
                            $('.allTickets .container .list').append(
                                $(`<li class="clearfix" id="${this.id}">
                                <img src="/img/user.png">
                                <div class="about">
                                    <div class="name">${this.user.name}
                                    <span>(${this.updated_at})</span>
                                </div>
                                <p>${this.body}</p>
                                </div>
                            </li>`)
                            );
                        })
                    },
                });
            }
            function getMyTicket(){
                if(ticket >= 1){
                    var form = {
                        "_token": "{{ csrf_token() }}",
                        ticket:ticket,
                    };
                    $.ajax({
                        url: '/admin/chat/get-chat',
                        type: "post",
                        data: form,
                        success: function (data) {
                            $('.chat .chat-history ul').children('li').remove();
                            $('.chat-header img').attr('src','/img/user.png');
                            $('.chat-header .chat-with').text('گفتگو با ' + data.user.name);
                            $('.chat .chat-history ul').append(
                                '<li class="clearfix">'+
                                '<div class="message-data '+(data.user.id != user.id ? 'align-left' : '')+'">'+
                                '<span class="message-data-name" >'+data.user.name+'</span>'+
                                '<span class="message-data-time" >('+data.updated_at+')</span>'+
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
                                        '<span class="message-data-time" >('+this.updated_at+')</span>'+
                                        '</div>' +
                                        '<div class="message ' + (this.user.id != user.id ? 'other-message float-left' : 'my-message') + '">' + this.body.replace(/\n/g, '<br>')+
                                        (this.file != '' && this.file != null ? '<a download href="'+this.file+'"><i><svg class="icon"><use xlink:href="#files"></use></svg></i></a>' : '') +
                                        '</div></li>'
                                    );
                                })
                            }
                            $('.allTicketIndex .chat .chat-history').animate({ scrollTop: $('.allTicketIndex .chat .chat-history').height() }, 1000);
                        },
                    });
                }
            }
        })
    </script>
@endsection


@section('links')
    <script src="/js/sweetalert.min.js"></script>
@endsection
