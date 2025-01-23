@extends('seller.master')

@section('tab' , 4)
@section('content')
    <div class="allInventoryIndex">
        <div class="topProductIndex">
            <div class="right">
                <a href="/seller/dashboard">{{__('messages.dashboard')}}</a>
                <span>/</span>
                @if($inventory == 1)
                    <a href="/seller/inventory">{{__('messages.inventory')}}</a>
                @else
                    <a href="/seller/empty">{{__('messages.product_unavailable')}}</a>
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
                        {{__('messages.filter_info')}}
                    </div>
                    <form method="GET" action="/seller/inventory" class="filterContent">
                        <div class="filterContentItem">
                            <label>{{__('messages.filter_title')}}</label>
                            <input type="text" name="title" placeholder="{{__('messages.filter_title')}}" value="{{$title}}">
                        </div>
                        <button type="submit">{{__('messages.action')}}</button>
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
                                    <span class="count">({{ $item->count }} {{__('messages.number')}})</span>
                                @else
                                    <span>({{__('messages.unavailable1')}})</span>
                                @endif
                            </h3>
                        </div>
                        <div class="postOptions">
                            <a title="{{__('messages.edit_product')}}" href="/seller/product/{{$item->id}}/edit">
                                <svg class="icon">
                                    <use xlink:href="#edit"></use>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="postBot">
                        <ul>
                            <li>
                                <span>{{__('messages.color')}} :</span>
                                @if($item->colors && $item->colors != '[]')
                                <div>
                                    @foreach(json_decode($item->colors) as $value)
                                        <span>
                                            @if($value->count >= 1)
                                                <span class="count">{{$value->name}} ({{ $value->count }} {{__('messages.number')}})</span>
                                            @else
                                                <span>{{$value->name}} ({{__('messages.unavailable1')}})</span>
                                            @endif
                                        </span>
                                    @endforeach
                                </div>
                                @else
                                    <div>
                                        <span>{{__('messages.no_color')}}</span>
                                    </div>
                                @endif
                            </li>
                            <li>
                                <span>{{__('messages.size')}} :</span>
                                @if($item->size && $item->size != '[]')
                                    <div>
                                        @foreach(json_decode($item->size) as $value)
                                            <span>
                                                @if($value->count >= 1)
                                                    <span class="count">{{$value->name}} ({{ $value->count }} {{__('messages.number')}})</span>
                                                @else
                                                    <span>{{$value->name}} ({{__('messages.unavailable1')}})</span>
                                                @endif
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <div>
                                        <span>{{__('messages.no_size')}}</span>
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
