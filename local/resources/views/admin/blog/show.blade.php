@extends('admin.master')

@section('tab',5)
@section('content')
    <div class="allShowBrand">
        <div class="topBrandPanel">
            <div class="right">
                <a href="/admin">داشبورد</a>
                <span>/</span>
                <a href="/admin/blog">همه بلاگ</a>
                <span>/</span>
                <a href="/admin/blog/{{$posts->id}}/show">آمار بلاگ</a>
            </div>
        </div>
        <div class="showData">
            <div class="pic">
                @if($posts->image)
                    <img src="{{$posts->image}}" alt="{{$posts->title}}">
                @else
                    <img src="/img/user.png" alt="{{$posts->title}}">
                @endif
            </div>
            <div class="showDataItems">
                <div class="showDataItem">
                    <h3>آیدی</h3>
                    <h4>{{$posts->id}}</h4>
                </div>
                <div class="showDataItem">
                    <h3>عنوان</h3>
                    <h4>{{$posts->title}}</h4>
                </div>
                <div class="showDataItem">
                    <h3>پیوند</h3>
                    <h4>{{$posts->slug}}</h4>
                </div>
                <div class="showDataItem">
                    <h3>مدت زمان مطالعه</h3>
                    <h4>{{$posts->time}}</h4>
                </div>
                <div class="showDataItem">
                    <h3>وضعیت محصول</h3>
                    @if($posts->status == 1)
                        <h4>منتشر شده</h4>
                    @else
                        <h4>پیشنویس</h4>
                    @endif
                </div>
                @if(count($posts->category)>=1)
                    <div class="showDataItem">
                        <h3>دسته بندی</h3>
                        @foreach($posts->category as $item)
                            <h4>{{$item->name}}</h4>
                        @endforeach
                    </div>
                @endif
                @if(count($posts->tag)>=1)
                    <div class="showDataItem">
                        <h3>برچسب</h3>
                        @foreach($posts->tag as $item)
                            <h4>{{$item->name}}</h4>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection()
