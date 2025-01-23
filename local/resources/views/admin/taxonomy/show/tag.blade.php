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
                <a href="/admin/tag/{{$tags->id}}/show">برچسب</a>
            </div>
        </div>
        <div class="showData">
            <div class="pic">
                @if($tags->image)
                    <img src="{{$tags->image}}" alt="{{$tags->name}}">
                @else
                    <img src="/img/user.png" alt="{{$tags->name}}">
                @endif
            </div>
            <div class="showDataItems">
                <div class="showDataItem">
                    <h3>آیدی</h3>
                    <h4>{{$tags->id}}</h4>
                </div>
                <div class="showDataItem">
                    <h3>عنوان</h3>
                    <h4>{{$tags->name}}</h4>
                </div>
                <div class="showDataItem">
                    <h3>پیوند</h3>
                    <h4>{{$tags->slug}}</h4>
                </div>
                <div class="showDataItem">
                    <h3>توضیحات سئو</h3>
                    <h4>{{$tags->bodySeo}}</h4>
                </div>
                <div class="showDataItem">
                    <h3>عنوان سئو</h3>
                    <h4>{{$tags->nameSeo}}</h4>
                </div>
                <div class="showDataItem">
                    <h3>توضیحات</h3>
                    <h4>{{$tags->body}}</h4>
                </div>
                <div class="showDataItem">
                    <h3>کلمات کلیدی</h3>
                    <h4>{{$tags->keyword}}</h4>
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
            @foreach($tags->product as $item)
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
        <table>
            <tr>
                <th>آیدی</th>
                <th>تصویر</th>
                <th>عنوان</th>
            </tr>
            @foreach($tags->blogs as $item)
                <tr>
                    <td>{{$item->id}}</td>
                    <td>
                        <div class="pic">
                            @if($item->image)
                                <img src="{{$item->image}}" alt="{{$item->title}}">
                            @endif
                        </div>
                    </td>
                    <td>{{$item->title}}</td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection()
