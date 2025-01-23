@extends('admin.master')

@section('tab',4)

@section('content')
    <div class="allManageSetting">
        <div class="topProductIndex">
            <div class="right">
                <a href="/admin">داشبورد</a>
                <span>/</span>
                <a href="/admin/setting/cache">تنظیمات کش</a>
            </div>
        </div>
        @if (\Session::has('message'))
            <div class="alert">
                {!! \Session::get('message') !!}
            </div>
        @endif
        <form method="post" action="/admin/setting/cache" class="settingMangeItems">
            @csrf
            <div class="settingItem">
                <label>زمان ذخیره کش (دقیقه)</label>
                <input type="text" name="cacheTime" value="{{$cacheTime}}" placeholder="مثال : 2">
            </div>
            <div class="settingItem">
                <label for="">وضعیت کش</label>
                <select name="cacheStatus">
                    <option value="0">غیرفعال</option>
                    <option value="1">فعال</option>
                </select>
            </div>
            <button>ثبت اطلاعات</button>
            <div class="buttons" style="margin-top: 3rem">
                <button style="background: red" class="cacheDelete" data-type="0" data-num="0">حذف کش صفحه اصلی</button>
                <button style="background: red" class="cacheDelete" data-type="0" data-num="1">حذف کش آدرس ها</button>
                <button style="background: red" class="cacheDelete" data-type="0" data-num="2">حذف کش کانفیگ ها</button>
                <button style="background: red" class="cacheDelete" data-type="0" data-num="3">حذف کش صفحات</button>
                <button style="background: red" class="cacheDelete" data-type="0" data-num="4">حذف کش پکیج</button>
            </div>
            <div class="buttons" style="margin-top: 1rem">
                <button class="cacheDelete" data-type="1" data-num="0">کش آدرس ها</button>
                <button class="cacheDelete" data-type="1" data-num="2">کش صفحات</button>
            </div>
        </form>
    </div>
@endsection

@section('scripts3')
    <script>
        $(document).ready(function(){
            var cacheStatus = {!! json_encode($cacheStatus, JSON_HEX_TAG) !!};
            $("select[name='cacheStatus']").val(cacheStatus == 1?1:0);
            $(".settingMangeItems .buttons .cacheDelete").click(function (e) {
                e.preventDefault();
                var btn = $(this);
                var btnText = $(this).text();
                btn.text('منتظر بمانید');
                var form = {
                    "_token": "{{ csrf_token() }}",
                    'type': $(this).attr('data-type'),
                    'num': $(this).attr('data-num'),
                };
                $.ajax({
                    url: "/admin/setting/change-cache",
                    type: "post",
                    data: form,
                    success: function (data) {
                        btn.text(btnText);
                    },
                });
            })
        })
    </script>
@endsection
