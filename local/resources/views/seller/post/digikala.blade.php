@extends('seller.master')

@section('title' , 'افزودن محصول با متاتگ')
@section('tab',2)
@section('content')
    <div class="sellerAuto">
        @if (\Session::has('message'))
            <div class="success">
                {!! \Session::get('message') !!}
            </div>
        @endif
        @if (\Session::has('error'))
            <div class="error">{!! \Session::get('error') !!}</div>
        @endif
        @if($check)
            <div class="check">
                <a target="_blank" href="https://www.digikala.com/seller/{{$check}}">{{$check}}</a>
                <span>در حال بررسی</span>
            </div>
        @endif
        <form class="data" action="/seller/product/digikala" method="post">
            @csrf
            <input name="link" value="{{\App\Models\Auto::where('user_id',auth()->user()->id)->where('status',1)->where('type',0)->value('link')}}" type="text" placeholder="شناسه فروشگاه شما در دیجیکالا مثال : digikala">
            <button>ثبت</button>
        </form>
        <div class="description">
            <h4>آموزش و توضیحات</h4>
            <ul>
                <li>نمونه شناسه فروشنده در آدرس https://www.digikala.com/seller/test به صورت test باید ثبت کنید</li>
                <li>شما میتوانید شناسه فروشنده های دیگر در دیجیکالا را قرار دهید و محصولاتشان را دریافت کنید</li>
                <li>بعد از ثبت و تایید توسط مدیریت محصولات به صورت خودکار در پنل شما قرار خواهد گرفت</li>
            </ul>
        </div>
    </div>
@endsection

