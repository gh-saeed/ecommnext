@extends('home.master')

@section('title' , __('messages.detail_order'))
@section('content')
    <div class="allProfileIndex width">
        @include('home.profile.list' , ['tab' => 1])
        <div class="allShowPay">
            <div class="topShowPay">
                <div class="title">
                    <h1 style="color: {{$pays->status == 100 ? 'green' : 'red'}}">جزئیات سفارش</h1>
                    <span>{{$pays->created_at}}</span>
                    <a href="/invoice/{{$pays->property}}" target="_blank">
                        <svg class="icon">
                            <use xlink:href="#pay"></use>
                        </svg>
                        دریافت فاکتور
                    </a>
                </div>
                <div class="detail">
                    <div class="topDetail">
                        <div class="items">
                            @if(count($pays->address) >= 1)
                                <div class="item">
                                    <h5>نام گیرنده :</h5>
                                    <div>{{$pays->address[0]->name}}</div>
                                </div>
                                <div class="item">
                                    <h5>شماره تماس :</h5>
                                    <div>{{$pays->address[0]->number}}</div>
                                </div>
                                <div class="item">
                                    <h5>کد پستی :</h5>
                                    <div>{{$pays->address[0]->post}}</div>
                                </div>
                            @else
                                <div class="item">
                                    <h5>نام گیرنده :</h5>
                                    <div>{{$pays->user->name}}</div>
                                </div>
                                <div class="item">
                                    <h5>شماره تماس :</h5>
                                    <div>{{$pays->user->number}}</div>
                                </div>
                            @endif
                            <div class="item">
                                <h5>شماره سفارش :</h5>
                                <div>{{$pays->property}}</div>
                            </div>
                            <div class="item">
                                <h5>وضعیت پرداخت :</h5>
                                @if($pays->status == 100)
                                    <div style="color: green">پرداخت شده</div>
                                @else
                                    <div style="color: red">پرداخت نشده</div>
                                @endif
                            </div>
                        </div>
                        <div class="items">
                            <div class="item">
                                <h5>مبلغ فاکتور :</h5>
                                <div>{{ number_format($pays->price - $pays->payMeta()->where('cancel', 1)->sum(DB::raw('price + carrier_price'))) }} تومان</div>
                            </div>
                            <div class="item">
                                <h5>مالیات :</h5>
                                <div>%{{$pays->tax}}</div>
                            </div>
                            <div class="item">
                                <h5>نوع پرداخت :</h5>
                                <div>
                                    @if($pays->method == 1)
                                        کیف پول
                                    @else
                                        درگاه پرداخت
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if(count($pays->address) >= 1)
                            <div class="items">
                                <div class="item">
                                    <h5>آدرس :</h5>
                                    <div>
                                        {{$pays->address[0]->state}}
                                        - {{$pays->address[0]->city}}
                                        - {{$pays->address[0]->address}}
                                        پلاک :
                                        {{$pays->address[0]->plaque}}
                                        واحد :
                                        {{$pays->address[0]->unit}}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="allShowPayContainer">
                <div class="items">
                    <div class="titleProducts">
                        <div class="title">محصولاتی که سفارش داده شده</div>
                    </div>
                    @foreach($pays->payMeta as $item)
                        <div class="item">
                            @if($item->product)
                                <a href="/product/{{$item->product->slug}}" class="cartDetailPic">
                                    <img src="{{$item->product->image != '[]' ?json_decode($item->product->image)[0]:''}}" alt="{{$item->product->title}}">
                                </a>
                            @endif
                            <div class="cartDetailInfo">
                                @if($item->product)
                                    <a href="/product/{{$item->product->slug}}" class="cartDetailInfoItem">
                                        <h3>
                                            {{$item->product->title}}
                                            @if($item->cancel)
                                                <span class="cancel">(لغو شده)</span>
                                            @endif
                                        </h3>
                                    </a>
                                    <div class="cartDetailInfoItem">
                                        <span>غرفه :</span>
                                        <span>{{$item->product->user->name}}</span>
                                    </div>
                                @endif
                                @if($item->color)
                                    <div class="cartDetailInfoItem">
                                        <span>رنگ :</span>
                                        <span>{{$item->color}}</span>
                                    </div>
                                @endif
                                @if($item->size)
                                    <div class="cartDetailInfoItem">
                                        <span>سایز :</span>
                                        <span>{{$item->size}}</span>
                                    </div>
                                @endif
                                @if($item->guarantee_name)
                                    <div class="cartDetailInfoItem">
                                        <span>گارانتی :</span>
                                        <span>{{$item->guarantee_name}}</span>
                                    </div>
                                @endif
                                <div class="cartDetailInfoItem">
                                    <span>تعداد :</span>
                                    <span>{{$item->count}}</span>
                                </div>
                                <div class="cartDetailInfoItem">
                                    <span>زمان تحویل احتمالی :</span>
                                    <span>{{$item->time}}</span>
                                </div>
                                <div class="cartDetailInfoItem">
                                    <span>مبلغ محصول :</span>
                                    <span>{{number_format($item->price)}} تومان</span>
                                </div>
                                <div class="cartDetailInfoItem">
                                    <span>هزینه ارسال :</span>
                                    <span>{{number_format($item->carrier_price)}} تومان</span>
                                </div>
                                <div class="cartDetailInfoItem">
                                    <span>حامل :</span>
                                    <span>{{$item->carrier_name}}</span>
                                </div>
                                <div class="cartDetailInfoItem">
                                    <span>کد رهگیری :</span>
                                    <span>{{$item->track}}</span>
                                </div>
                                <div class="cartDetailInfoItem">
                                    <span>وضعیت تحویل :</span>
                                    <span>
                                        @if($item->deliver == 0)
                                            دریافت سفارش
                                        @elseif($item->deliver == 1)
                                            در انتظار بررسی
                                        @elseif($item->deliver == 2)
                                            بسته بندی شده
                                        @elseif($item->deliver == 3)
                                            تحویل پیک
                                        @elseif($item->deliver == 4)
                                            تحویل داده شده
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
