@extends('admin.master')

@section('tab' , 8)
@section('content')
    <div class="profileIndexTicket">
        @if (\Session::has('message'))
            <div class="alert">
                {!! \Session::get('message') !!}
            </div>
        @endif
        <table>
            <tr>
                <th>کاربر</th>
                <th>محصول</th>
                <th>سایز</th>
                <th>رنگ</th>
                <th>زمان ثبت</th>
                <th>عملیات</th>
            </tr>
            @foreach($carts as $item)
                <tr>
                    <td>
                        <span>{{$item->user->name}}</span>
                    </td>
                    <td>
                        <span>{{$item->product->title}}</span>
                    </td>
                    <td>
                        <span>{{$item->size}}</span>
                    </td>
                    <td>
                        <span>{{$item->color}}</span>
                    </td>
                    <td>
                        <span>{{$item->created_at}}</span>
                    </td>
                    <td>
                        <div class="buttons">
                            <button id="{{$item->id}}" class="accept" status="2">موجود</button>
                            <button id="{{$item->id}}" class="reject" status="1">ناموجود</button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection

@section('scripts3')
    <script>
        $(document).ready(function(){
            var post = 0;
            $('.buttons button').on('click' ,function(ss){
                ss.currentTarget.parentElement.parentElement.parentElement.remove();
                post = this.id;
                var form = {
                    "_token": "{{ csrf_token() }}",
                    "post": post,
                    "status": $(this).attr('status'),
                };
                $.ajax({
                    url: "/admin/inquiry/change",
                    type: "post",
                    data: form,
                    success: function (data) {
                        if (data == 'ok') {
                            $.toast({
                                text: "اطلاعات ثبت شد", // Text that is to be shown in the toast
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

                        }
                    },
                });
            })
        })
    </script>
@endsection

@section('jsScript')
    <script src="/js/jquery.toast.min.js"></script>
    <link rel="stylesheet" href="/css/jquery.toast.min.css"/>
@endsection
