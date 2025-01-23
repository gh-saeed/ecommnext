@extends('admin.master')

@section('tab' , 10)
@section('content')
    <div class="allPayPanel">
        <div class="topProductIndex">
            <div class="right">
                <a href="/admin">داشبورد</a>
                <span>/</span>
                <span>بازدید های کاربر</span>
            </div>
        </div>
        <div class="allReturnedPay" style="grid-template-columns: repeat(auto-fill, minmax(20rem, 1fr))">
            @foreach ($views as $item)
                <div class="postItem">
                    <h3> آیپی : {{$item->user_ip}}</h3>
                    <h5>
                        مرورگر :
                        <span>{{$item->browser}}</span>
                    </h5>
                    <h5>
                        پلتفرم :
                        <span>{{$item->platform}}</span>
                    </h5>
                    <h5>
                        صفحه :
                        @if($item->viewable_id == 0)
                            <span>صفحه اصلی</span>
                        @else
                            <a href="/product/{{\App\Models\Product::where('id' , $item->viewable_id)->pluck('slug')->first()}}">{{\App\Models\Product::where('id' , $item->viewable_id)->pluck('title')->first()}}</a>
                        @endif
                    </h5>
                    <h5>
                        زمان ثبت :
                        <span>{{verta($item->created_at)->format(' H:i | %d / %B / %Y')}}</span>
                    </h5>
                </div>
            @endforeach
        </div>
    </div>
@endsection
