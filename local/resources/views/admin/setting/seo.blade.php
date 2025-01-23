@extends('admin.master')

@section('tab',4)

@section('content')
    <div class="allManageSetting">
        <div class="topProductIndex">
            <div class="right">
                <a href="/admin">داشبورد</a>
                <span>/</span>
                <a href="/admin/setting/seo">تنظیمات سئو</a>
            </div>
        </div>
        @if (\Session::has('message'))
            <div class="alert">
                {!! \Session::get('message') !!}
            </div>
        @endif
        <form method="post" action="/admin/setting/seo" class="settingMangeItems">
            @csrf
            <div class="settingItem">
                <label for="">عنوان فعالیت سایت</label>
                <input type="text" name="titleSeo" value="{{$titleSeo}}" placeholder="نام را وارد کنید">
            </div>
            <div class="settingItem">
                <label for="">کلمات کلیدی سایت</label>
                <input type="text" name="keyword" value="{{$keyword}}" placeholder="با , جدا کنید">
            </div>
            <div class="settingItem">
                <label for="">توضیحات سئو سایت</label>
                <textarea name="aboutSeo" placeholder="توضیحات را وارد کنید">{{$aboutSeo}}</textarea>
            </div>
            <button>ثبت اطلاعات</button>
        </form>
    </div>
@endsection
