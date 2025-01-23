@extends('seller.master')

@section('tab' , 9)
@section('content')
    <div class="allPayPanel">
        <div class="topProductIndex">
            <div class="right">
                <a href="/seller/dashboard">داشبورد</a>
                <span>/</span>
                <span>فروش هر محصول</span>
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
                    <form method="GET" action="/admin/statistics/product" class="filterContent">
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
            @foreach ($products as $item)
                <div class="postItem" id="{{$item->id}}">
                    <a href="/product/{{$item->slug}}" target="_blank" class="pic">
                        @if($item->image != '[]')
                            <img src="{{json_decode($item->image)[0]}}">
                        @endif
                    </a>
                    <h3>{{$item->title}}</h3>
                    <h5>
                        تعداد سفارش :
                        <span>{{\App\Models\PayMeta::whereIn('status' , [50,100])->where('product_id' , $item->id)->sum('count')}}</span>
                    </h5>
                    <h5>
                        تعداد سفارش امروز :
                        <span>{{\App\Models\PayMeta::where('cancel' , 0)->where('status' , 100)->whereBetween('created_at', [verta()->startDay()->formatGregorian('Y-m-d H:i:s'), verta()->endDay()->formatGregorian('Y-m-d H:i:s')])->where('product_id' , $item->id)->sum('count')}}</span>
                    </h5>
                    <h5>
                        تعداد مرجوعی :
                        <span>{{\App\Models\PayMeta::where('cancel' , 1)->where('product_id' , $item->id)->sum('count')}}</span>
                    </h5>
                    <h5>
                        تعداد موجود :
                        <span>{{number_format($item->count)}}</span>
                    </h5>
                    <h5>
                        مبلغ کل سفارش :
                        <span>{{number_format(\App\Models\PayMeta::where('status' , 100)->where('cancel',0)->where('product_id' , $item->id)->sum(\Illuminate\Support\Facades\DB::raw('price + carrier_price')))}} تومان</span>
                    </h5>
                    <a class="show">مشاهده سفارشات</a>
                    <div class="showPays">
                        <h4>سفارشات اخیر</h4>
                        @foreach(\App\Models\PayMeta::where('status' , 100)->where('cancel',0)->where('product_id' , $item->id)->take(10)->get() as $val)
                            <a href="/seller/pay/{{$val->pay->property}}" class="payItem">
                                <h6>مشاهده سفارش :</h6>
                                <div class="payItemData">
                                    #{{$val->pay->property}}
                                    @if($item->deliver == 0)
                                        <span class="unActive">دریافت سفارش</span>
                                    @elseif($item->deliver == 1)
                                        <span class="unActive">در انتظار بررسی</span>
                                    @elseif($item->deliver == 2)
                                        <span class="unActive">بسته بندی شده</span>
                                    @elseif($item->deliver == 3)
                                        <span class="unActive">تحویل پیک</span>
                                    @elseif($item->deliver == 4)
                                        <span class="activeStatus">تکمیل شده</span>
                                    @endif
                                </div>
                            </a>
                        @endforeach
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

