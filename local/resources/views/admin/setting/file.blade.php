@extends('admin.master')

@section('tab',4)

@section('content')
    <div class="allManageSetting">
        <div class="topProductIndex">
            <div class="right">
                <a href="/admin">داشبورد</a>
                <span>/</span>
                <a href="/admin/setting/file">تنظیمات فایل</a>
            </div>
        </div>
        @if (\Session::has('message'))
            <div class="alert">
                {!! \Session::get('message') !!}
            </div>
        @endif
        <form method="post" action="/admin/setting/file" class="settingMangeItems">
            @csrf
            <h3>مدیریت فایل</h3>
            <div class="settingItem">
                <label for="">کد های css فرانت</label>
                <textarea style="direction: ltr;height: 40rem;" name="lightHomeCss">{{$lightHomeCss}}</textarea>
            </div>
            <div class="settingItem">
                <label for="">کد های css پنل فروشنده</label>
                <textarea style="direction: ltr;height: 40rem;" name="sellerCss">{{$sellerCss}}</textarea>
            </div>
            <div class="settingItem">
                <label for="">کد های css ادمین</label>
                <textarea style="direction: ltr;height: 40rem;" name="adminCss">{{$adminCss}}</textarea>
            </div>
            <div class="settingItem">
                <label for="">کد های robots.txt</label>
                <textarea style="direction: ltr;height: 40rem;" name="robot">{{$robot}}</textarea>
            </div>
            <div class="settingItem">
                <label for="">کد های htaccess</label>
                <textarea style="direction: ltr;height: 40rem;" name="htaccess">{{$htaccess}}</textarea>
            </div>
            <button>ثبت اطلاعات</button>
        </form>
    </div>
@endsection
