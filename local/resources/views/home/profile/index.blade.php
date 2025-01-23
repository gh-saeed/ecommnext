@extends('home.master')

@section('title' , __('messages.dashboard'))
@section('content')
    <div class="allProfileIndex width">
        @include('home.profile.list' , ['tab' => 0])
        <div class="profileIndex">
            @if(\App\Models\Event::where('customer_id' , auth()->user()->id)->count())
                <div class="notes">
                    <div class="noteTitle">{{__('messages.my_note')}}</div>
                    <div class="items">
                        @foreach(\App\Models\Event::where('customer_id' , auth()->user()->id)->get() as $item)
                            <div class="item">
                                <h4>{{$item->title}}</h4>
                                <p>{{$item->body}}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            <div class="about">
                <div class="title">اطلاعات کاربری شما</div>
                <div class="items">
                    <div class="item">
                        <div class="name">نام شما</div>
                        <div class="body">{{auth()->user()->name}}</div>
                    </div>
                    @if(auth()->user()->number)
                        <div class="item">
                            <div class="name">شماره شما</div>
                            <div class="body">{{auth()->user()->number??'ــ'}}</div>
                        </div>
                    @endif
                    @if(auth()->user()->email)
                        <div class="item">
                            <div class="name">ایمیل شما</div>
                            <div class="body">{{auth()->user()->email??'ــ'}}</div>
                        </div>
                    @endif
                    <div class="item">
                        <div class="name">کد معرف</div>
                        <div class="body">{{auth()->user()->referral??'ــ'}}</div>
                    </div>
                    <div class="item">
                        <div class="name">مبلغ قابل تسویه</div>
                        <div class="body">{{number_format(auth()->user()->myCheckout())}} تومان</div>
                    </div>
                </div>
            </div>
            <div class="profileIndexPay">
                <label>{{__('messages.latest_order')}}</label>
                <table>
                    <tr>
                        <th>{{__('messages.order_deliver')}}</th>
                        <th>{{__('messages.order_property')}}</th>
                        <th>{{__('messages.buy_status')}}</th>
                        <th>{{__('messages.order_created')}}</th>
                        <th>{{__('messages.action1')}}</th>
                    </tr>
                    @foreach($pays as $item)
                        <tr>
                            <td>
                                @if($item->deliver == 0)
                                    <span class="unActive">{{__('messages.order_deliver1')}}</span>
                                @endif
                                @if($item->deliver == 1)
                                    <span class="unActive">{{__('messages.order_deliver2')}}</span>
                                @endif
                                @if($item->deliver == 2)
                                    <span class="unActive">{{__('messages.order_deliver3')}}</span>
                                @endif
                                @if($item->deliver == 3)
                                    <span class="unActive">{{__('messages.order_deliver4')}}</span>
                                @endif
                                @if($item->deliver == 4)
                                    <span class="active">{{__('messages.order_deliver5')}}</span>
                                @endif
                            </td>
                            <td>
                                <span>{{$item->property}}</span>
                            </td>
                            <td>
                                @if($item->status == 100)
                                    <span class="active">{{__('messages.order_status2')}}</span>
                                @endif
                                @if($item->status == 50)
                                    <span class="active">{{__('messages.order_status3')}}</span>
                                @endif
                                @if($item->status == 20)
                                    <span class="active">{{__('messages.order_status4')}}</span>
                                @endif
                                @if($item->status == 10)
                                    <span class="unActive">{{__('messages.order_status5')}}</span>
                                @endif
                                @if($item->status == 0)
                                    <span class="unActive">{{__('messages.order_status6')}}</span>
                                @endif
                                @if($item->status == 1)
                                    <span class="unActive">{{__('messages.order_status7')}}</span>
                                @endif
                                @if($item->status == 2)
                                    <span class="unActive">{{__('messages.order_status8')}}</span>
                                @endif
                            </td>
                            <td>
                                <span>{{$item->created_at}}</span>
                            </td>
                            <td>
                                <a href="/show-pay/{{$item->property}}">
                                    <svg class="icon">
                                        <use xlink:href="#left"></use>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
