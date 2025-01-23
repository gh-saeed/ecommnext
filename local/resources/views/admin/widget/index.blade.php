@extends('admin.master')

@section('tab' , 3)
@section('content')
<div class="allWidgetIndex">
    <div class="topProductIndex">
        <div class="right">
            <a href="/admin">داشبورد</a>
            <span>/</span>
            <a href="/admin/widget">ویجت ها</a>
            <span>/</span>
            <a href="/admin/widget/create">افزودن ویجت</a>
        </div>
    </div>
    <div class="allWidget">
        <table>
            <thead>
                <tr>
                    <th>نوع</th>
                    <th>عنوان</th>
                    <th>وضعیت نمایش</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody id="sort-1">
                @foreach($widgets as $item)
                    <tr>
                        <td id="{{$item->id}}">{{$item->name}}</td>
                        <td>{{$item->title}}</td>
                        <td>
                            @if($item->status == 0)
                                پیشنویس
                            @else
                                منتشر شده
                            @endif
                        </td>
                        <td>
                            <div class="buttons">
                                <a href="/admin/widget/{{$item->id}}/edit">ویرایش</a>
                                <button class="deleteUser" id="{{$item->id}}">حذف</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="popUp" style="display:none;">
        <div class="popUpItem">
            <div class="title">آیا از حذف ویجت مطمئن هستید؟</div>
            <p>با حذف ویجت اطلاعات ویجت به طور کامل حذف میشوند</p>
            <div class="buttonsPop">
                <form method="POST" action="" id="deletePost">
                    @csrf
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit">حذف شود</button>
                </form>
                <button id="cancelDelete">منصرف شدم</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts3')
    <script>
        $(document).ready(function(){
            var post = 0;
            var typeWidget = {!! json_encode($type, JSON_HEX_TAG) !!};
            $('.popUp').hide();
            $( "#sort-1" ).sortable({
                update: function(event, ui) {
                    var data = [];
                    $('tbody tr').each(function(){
                        data.push(this.firstElementChild.id);
                    })
                    var form = {
                        "_token": "{{ csrf_token() }}",
                        widget:data,
                        type:typeWidget,
                    };

                    $.ajax({
                        url: "/admin/widget",
                        type: "post",
                        data: form,
                    });
                }
            });
            $('#cancelDelete').click(function(){
                $('.popUp').hide();
                post = 0;
            })
            $('#deletePost').click(function(){
                $('.popUp').hide();
            });
            $('table tr').on('click' , '.deleteUser' ,function(){
                post = this.id;
                $('.popUp').show();
                $('.buttonsPop form').attr('action' , '/admin/widget/' + post+'/delete');
            })
        })
    </script>
@endsection

@section('jsScript')
    <script src="/js/jquery-ui.min.js"></script>
@endsection
