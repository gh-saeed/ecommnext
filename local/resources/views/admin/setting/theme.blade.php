@extends('admin.master')

@section('tab',4)

@section('content')
    <div class="allManageSetting">
        <div class="topProductIndex">
            <div class="right">
                <a href="/admin">داشبورد</a>
                <span>/</span>
                <a href="/admin/setting/theme">تغییر دمو و رنگ</a>
            </div>
        </div>
        @if (\Session::has('message'))
            <div class="alert">
                {!! \Session::get('message') !!}
            </div>
        @endif
        <form method="post" action="/admin/setting/theme" class="settingMangeItems">
            @csrf
            <div class="settingItem">
                <label>ویجت صفحه اصلی</label>
                <select name="demo">
                    <option value="0" selected>در صورت تغییر انتخاب کنید</option>
                    <option value="1">دمو 1</option>
                    <option value="2">دمو 2</option>
                </select>
            </div>
            <div class="settingItem">
                <label>فوتر سایت</label>
                <select name="footerDesign">
                    <option value="1">نوع 1</option>
                    <option value="2">نوع 2</option>
                </select>
            </div>
            <div class="settingItem">
                <label>هدر سایت</label>
                <select name="headerDesign">
                    <option value="1">نوع 1</option>
                    <option value="2">نوع 2</option>
                </select>
            </div>
            <div class="settingItem">
                <label>فونت سایت</label>
                <select name="font">
                    <option value="0">ایران سانس</option>
                    <option value="1">وزیر</option>
                    <option value="2">ساحل</option>
                </select>
            </div>
            <div class="settingItem">
                <label>صفحه سینگل</label>
                <select name="singleDesign">
                    <option value="1">دمو1</option>
                    <option value="2">دمو2</option>
                </select>
            </div>
            <h3>رنگ ها</h3>
            <div class="settingItemPage">
                <div class="settingItem">
                    <label for="">رنگ پیشفرض (سبز)</label>
                    <input type="color" name="greenColorLight" value="{{$greenColorLight}}">
                </div>
                <div class="settingItem">
                    <label for="">رنگ پیشفرض دوم(قرمز)</label>
                    <input type="color" name="redColorLight" value="{{$redColorLight}}">
                </div>
                <div class="settingItem">
                    <label for="">رنگ پس زمینه سایت</label>
                    <input type="color" name="backColorLight1" value="{{$backColorLight1}}">
                </div>
            </div>
            <button>ثبت اطلاعات</button>
        </form>
    </div>
@endsection

@section('scripts3')
    <script>
        $(document).ready(function(){
            var singleDesign = {!! json_encode($singleDesign, JSON_HEX_TAG) !!};
            var font = {!! json_encode($font, JSON_HEX_TAG) !!};
            var headerDesign = {!! json_encode($headerDesign, JSON_HEX_TAG) !!};
            var footerDesign = {!! json_encode($footerDesign, JSON_HEX_TAG) !!};
            $("select[name='singleDesign']").val(singleDesign);
            $("select[name='font']").val(font);
            $("select[name='headerDesign']").val(headerDesign);
            $("select[name='footerDesign']").val(footerDesign);
        })
    </script>
@endsection
