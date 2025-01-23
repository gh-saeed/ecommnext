@extends('admin.master')

@section('tab',4)

@section('content')
    <div class="allManageSetting">
        <div class="topProductIndex">
            <div class="right">
                <a href="/admin">داشبورد</a>
                <span>/</span>
                <a href="/admin/setting/script">تنظیمات اسکریپت</a>
            </div>
        </div>
        @if (\Session::has('message'))
            <div class="alert">
                {!! \Session::get('message') !!}
            </div>
        @endif
        <form method="post" action="/admin/setting/script" class="settingMangeItems">
            @csrf
            <h3>مدیریت اسکریپت</h3>
            <div class="settingItem">
                <label for="">اسکریپت یا کد html در تگ Head</label>
                <textarea name="headScript" placeholder="با Enter میتوانید جدا کنید">{{$headScript}}</textarea>
            </div>
            <div class="settingItem">
                <label for="">اسکریپت یا کد html در تگ Body</label>
                <textarea name="bodyScript" placeholder="با Enter میتوانید جدا کنید">{{$bodyScript}}</textarea>
            </div>
            <button>ثبت اطلاعات</button>
        </form>
    </div>
@endsection
