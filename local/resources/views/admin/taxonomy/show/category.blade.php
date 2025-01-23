@extends('admin.master')

@section('tab',2)

@section('content')
    <div class="allShowBrand">
        <div class="topBrandPanel">
            <div class="right">
                <a href="/admin">داشبورد</a>
                <span>/</span>
                <a>تاکسونامی</a>
                <span>/</span>
                <a href="/admin/category/{{$categories->id}}/show">دسته بندی</a>
            </div>
        </div>
        <div class="showData">
            <div class="pic">
                @if($categories->image)
                    <img src="{{$categories->image}}" alt="{{$categories->name}}">
                @else
                    <img src="/img/user.png" alt="{{$categories->name}}">
                @endif
            </div>
            <div class="showDataItems">
                <div class="showDataItem">
                    <h3>آیدی</h3>
                    <h4>{{$categories->id}}</h4>
                </div>
                <div class="showDataItem">
                    <h3>عنوان</h3>
                    <h4>{{$categories->name}}</h4>
                </div>
                <div class="showDataItem">
                    <h3>پیوند</h3>
                    <h4>{{$categories->slug}}</h4>
                </div>
                <div class="showDataItem">
                    <h3>توضیحات سئو</h3>
                    <h4>{{$categories->bodySeo}}</h4>
                </div>
                <div class="showDataItem">
                    <h3>عنوان سئو</h3>
                    <h4>{{$categories->nameSeo}}</h4>
                </div>
                <div class="showDataItem">
                    <h3>توضیحات</h3>
                    <h4>{{$categories->body}}</h4>
                </div>
                <div class="showDataItem">
                    <h3>کلمات کلیدی</h3>
                    <h4>{{$categories->keyword}}</h4>
                </div>
            </div>
        </div>
        <table>
            <tr>
                <th>آیدی</th>
                <th>تصویر</th>
                <th>عنوان</th>
                <th>مبلغ</th>
                <th>تعداد موجود</th>
            </tr>
            @foreach($categories->product as $item)
                <tr>
                    <td>{{$item->id}}</td>
                    <td>
                        <div class="pic">
                            @if($item->image != '[]')
                                <img src="{{json_decode($item->image)[0]}}" alt="{{$item->title}}">
                            @endif
                        </div>
                    </td>
                    <td>{{$item->title}}</td>
                    <td>{{number_format($item->price)}} تومان </td>
                    <td>{{$item->count}}</td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection()
