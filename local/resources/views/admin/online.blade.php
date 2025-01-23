@extends('admin.master')

@section('tab' , 0)
@section('content')
    <div class="allPayPanel">
        <div class="topProductIndex">
            <div class="right">
                <a href="/admin">داشبورد</a>
                <span>/</span>
                <span>رهگیری کاربران سایت (لحظه ای)</span>
            </div>
        </div>
        @if (\Session::has('message'))
            <div class="alert">
                {!! \Session::get('message') !!}
            </div>
        @endif
        <div class="allReturnedPay" style="grid-template-columns: repeat(auto-fill, minmax(20rem, 1fr))">
            @foreach (array_reverse($pages, true) as $item)
                @if($item)
                    <div class="postItem">
                        <h3> آیپی : {{$item['ip']}}</h3>
                        <h5>
                            صفحه :
                            <a href="{{$item['url']}}">{{$item['url']}}</a>
                        </h5>
                        <h5>
                            آیدی کاربر :
                            <span>{{$item['id']>=1?$item['id']:'-'}}</span>
                        </h5>
                        <h5>
                            زمان ورود :
                            <span>{{$item['time']}}</span>
                        </h5>
                        @if($item['id'])
                            <a class="show" target="_blank" href="/admin/user/{{$item['id']}}/edit" title="مشاهده کاربر">مشاهده کاربر</a>
                        @else
                            <a class="show" style="background: red">ثبت نام نکرده</a>
                        @endif
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection

@section('scripts3')
    <script>
        $(document).ready(function(){
            setInterval(checkUser,5000);
            function checkUser(){
                var form = {
                    "_token": "{{ csrf_token() }}",
                };
                $.ajax({
                    url: '/admin/check-user',
                    type: "post",
                    data: form,
                    success: function (data) {
                        $('.allReturnedPay').children('.postItem').remove();
                        $.each(data,function (){
                            $('.allReturnedPay').append(
                                `<div class="postItem">
                        <h3> آیپی : ${this['ip']}</h3>
                        <h5>
                            صفحه :
                            <a href="${this['url']}">${this['url']}</a>
                        </h5>
                        <h5>
                            آیدی کاربر :
                            <span>${this['id']>=1?this['id']:'-'}</span>
                        </h5>
                        <h5>
                            زمان ورود :
                            <span>${this['time']}</span>
                        </h5>
                                ${this['id']?`<a class="show" target="_blank" href="/admin/user/${this['id']}/edit" title="مشاهده کاربر">مشاهده کاربر</a>`:'<a class="show" style="background: red">ثبت نام نکرده</a>'}
                                </div>`
                            );
                        })
                    },
                });
            }
        })
    </script>
@endsection

