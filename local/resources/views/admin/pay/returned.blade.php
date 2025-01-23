@extends('admin.master')

@section('tab' , 34)
@section('content')
    <div class="allPayPanel">
        <div class="topProductIndex">
            <div class="right">
                <a href="/admin">داشبورد</a>
                <span>/</span>
                <span>مرجوعی ها</span>
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
                    <form method="GET" action="/admin/pay/returned" class="filterContent">
                        <div class="filterContentItem">
                            <label>فیلتر نام محصول</label>
                            <input type="text" name="title" placeholder="نام" value="{{$title}}">
                        </div>
                        <button type="submit">اعمال</button>
                    </form>
                </div>
            </div>
        </div>
        @if (\Session::has('message'))
            <div class="alert">
                {!! \Session::get('message') !!}
            </div>
        @endif
        <div class="allReturnedPay">
            @foreach ($pays as $item)
                <div class="postItem" id="{{$item->id}}">
                    <a href="/product/{{$item->product->slug}}" target="_blank" class="pic">
                        <img src="{{json_decode($item->product->image)[0]}}">
                    </a>
                    <h3>{{$item->product->title}}</h3>
                    <h5>
                        رنگ :
                        @if($item->color)
                            <span>{{$item->color}}</span>
                        @else
                            <span>-</span>
                        @endif
                    </h5>
                    <h5>
                        سایز :
                        @if($item->size)
                            <span>{{$item->size}}</span>
                        @else
                            <span>-</span>
                        @endif
                    </h5>
                    <h5>
                        کاربر :
                        @if($item->user)
                            <span>{{$item->user->name}}</span>
                        @else
                            <span>-</span>
                        @endif
                    </h5>
                    <h5>
                        تعداد مرجوعی :
                        <span>{{$item->count}} عدد</span>
                    </h5>
                    <h5>
                        مبلغ :
                        <span>{{number_format($item->price)}} تومان</span>
                    </h5>
                    <a class="show" target="_blank" href="/admin/pay/{{$item->pay->id}}" title="مشاهده سفارش">مشاهده سفارش</a>
                </div>
            @endforeach
        </div>
        {{ $pays->links('admin.paginate') }}
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

