@extends('admin.master')

@section('tab' , 8)
@section('content')
    <div class="allInventoryIndex">
        <div class="topProductIndex">
            <div class="right">
                <a href="/admin">داشبورد</a>
                <span>/</span>
                @if($inventory == 1)
                    <a href="/admin/inventory">انبارداری</a>
                @else
                    <a href="/admin/empty">محصولات ناموجود</a>
                @endif
            </div>
            <div class="allTopTableItem">
                <div class="filterItems">
                    <div class="filterTitle">
                        <i>
                            <svg class="icon">
                                <use xlink:href="#filter"></use>
                            </svg>
                        </i>
                        فیلتر اطلاعات
                    </div>
                    <form method="GET" action="/admin/inventory" class="filterContent">
                        <div class="filterContentItem">
                            <label>فیلتر عنوان و آیدی</label>
                            <input type="text" name="title" placeholder="مثال: 10" value="{{$title}}">
                        </div>
                        <button type="submit">اعمال</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="allTableContainer">
            @foreach ($products as $item)
                <div class="postItem">
                    <div class="postTop">
                        <div class="postPic">
                            @if($item->image != '[]')
                            <img src="{{json_decode($item->image)[0]}}" alt="{{$item->title}}">
                            @endif
                        </div>
                        <div class="postTitle">
                            <h3>
                                {{$item->title}}
                                @if($item->count >= 1)
                                    <span class="count">({{ $item->count }} مورد)</span>
                                @else
                                    <span>(ناموجود)</span>
                                @endif
                            </h3>
                        </div>
                        <div class="postOptions">
                            <a title="ویرایش محصول" href="/admin/product/{{$item->id}}/edit">
                                <svg class="icon">
                                    <use xlink:href="#edit"></use>
                                </svg>
                            </a>
                            <a href="/admin/product/{{$item->id}}/show" title="نمایش محصول">
                                <svg class="icon">
                                    <use xlink:href="#eye"></use>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="postBot">
                        <ul>
                            <li>
                                <span>رنگ :</span>
                                @if($item->colors && $item->colors != '[]')
                                <div>
                                    @foreach(json_decode($item->colors) as $value)
                                        <span>
                                            @if($value->count >= 1)
                                                <span class="count">{{$value->name}} ({{ $value->count }} مورد)</span>
                                            @else
                                                <span>{{$value->name}} (ناموجود)</span>
                                            @endif
                                        </span>
                                    @endforeach
                                </div>
                                @else
                                    <div>
                                        <span>بدون رنگ</span>
                                    </div>
                                @endif
                            </li>
                            <li>
                                <span>سایز :</span>
                                @if($item->size && $item->size != '[]')
                                    <div>
                                        @foreach(json_decode($item->size) as $value)
                                            <span>
                                                @if($value->count >= 1)
                                                    <span class="count">{{$value->name}} ({{ $value->count }} مورد)</span>
                                                @else
                                                    <span>{{$value->name}} (ناموجود)</span>
                                                @endif
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <div>
                                        <span>بدون سایز</span>
                                    </div>
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
        {{ $products->links('admin.paginate') }}
    </div>
@endsection


@section('scripts3')
    <script>
        $(document).ready(function(){
            $('.filterContent').hide();
            $('.filterTitle').click(function(){
                $('.filterContent').toggle();
            })
        })
    </script>
@endsection
