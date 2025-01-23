@extends('admin.master')

@section('tab',1)
@section('content')
    <div class="allShowBrand">
        <div class="topBrandPanel">
            <div class="right">
                <a href="/admin">داشبورد</a>
                <span>/</span>
                <a href="/admin/product">همه محصولات</a>
                <span>/</span>
                <a href="/admin/product/{{$posts->id}}/show">آمار محصولات</a>
            </div>
        </div>
        <div class="showData">
            <div class="pic">
                @if($posts->image != '[]')
                    <img src="{{json_decode($posts->image)[0]}}" alt="{{$posts->title}}">
                @else
                    <img src="/img/user.png" alt="{{$posts->name}}">
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
                    <h3>تعداد موجود</h3>
                    <h4>{{$posts->count}}</h4>
                </div>
                <div class="showDataItem">
                    <h3>تعداد علاقه مندی</h3>
                    <h4>{{$posts->like_count}}</h4>
                </div>
                <div class="showDataItem">
                    <h3>تعداد دیدگاه</h3>
                    <h4>{{$posts->comments_count}}</h4>
                </div>
                <div class="showDataItem">
                    <h3>تعداد نشانه ها</h3>
                    <h4>{{$posts->bookmark_count}}</h4>
                </div>
                <div class="showDataItem">
                    <h3>کد محصول</h3>
                    <h4>{{$posts->product_id}}</h4>
                </div>
                <div class="showDataItem">
                    <h3>تخفیف</h3>
                    @if($posts->off)
                        <h4>{{$posts->off}}</h4>
                    @else
                        <h4>بدون تخفیف</h4>
                    @endif
                </div>
                <div class="showDataItem">
                    <h3>مبلغ</h3>
                    <h4>{{number_format($posts->price)}} تومان </h4>
                </div>
                <div class="showDataItem">
                    <h3>وضعیت محصول</h3>
                    @if($posts->status == 1)
                        <h4>منتشر شده</h4>
                    @else
                        <h4>پیشنویس</h4>
                    @endif
                </div>
                @if(count($posts->brand)>=1)
                    <div class="showDataItem">
                        <h3>برند</h3>
                        @foreach($posts->brand as $item)
                            <h4>{{$item->name}}</h4>
                        @endforeach
                    </div>
                @endif
                @if(count($posts->category)>=1)
                    <div class="showDataItem">
                        <h3>دسته بندی</h3>
                        @foreach($posts->category as $item)
                            <h4>{{$item->name}}</h4>
                        @endforeach
                    </div>
                @endif
                @if(count($posts->guarantee)>=1)
                    <div class="showDataItem">
                        <h3>گارانتی</h3>
                        @foreach($posts->guarantee as $item)
                            <h4>{{$item->name}}</h4>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection()
