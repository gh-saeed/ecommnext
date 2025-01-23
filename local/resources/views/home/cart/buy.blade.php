@extends('home.master')

@section('title' , __('messages.order_status1'))
@section('content')
    <main class="buyIndex">
        <div class="allBuyItems">
            @if($pay->status == 100)
                <div class="allBuySuccessItemTitle">
                    <h3>{{__('messages.order_status1')}}</h3>
                </div>
            @else
                <div class="allBuyFailItemTitle">
                    <h3>{{__('messages.order_status1')}}</h3>
                </div>
            @endif
            <div class="allBuyItem">
                <label>{{__('messages.order_created')}}</label>
                <h4>{{$pay->created_at}}</h4>
            </div>
            @if($pay->auth)
                @if($pay->address()->pluck('name')->first())
                    <div class="allBuyItem">
                        <label>{{__('messages.order_name')}}</label>
                        <h4>{{$pay->address()->pluck('name')->first()}}</h4>
                    </div>
                @elseif(auth()->user())
                    <div class="allBuyItem">
                        <label>{{__('messages.order_name')}}</label>
                        <h4>{{auth()->user()->name}}</h4>
                    </div>
                @endif
            @else
                <div class="allBuyItem">
                    <label>{{__('messages.order_name')}}</label>
                    <h4>{{auth()->user()->name}}</h4>
                </div>
            @endif
            <div class="allBuyItem">
                <label>{{__('messages.order_price')}}</label>
                <h4>{{number_format($pay->price)}} {{__('messages.arz')}}</h4>
            </div>
            <div class="allBuyItem">
                <label>{{__('messages.order_property')}}</label>
                <h4>{{$pay->property}}</h4>
            </div>
            <div class="allBuyItem">
                <label>{{__('messages.order_status')}}</label>
                @if($pay->status == 100)
                    <h4>{{__('messages.order_success')}}</h4>
                @else
                    <h4>{{__('messages.order_fail')}}</h4>
                @endif
            </div>
            <div class="allBuyButton">
                <a href="/" title="{{__('messages.back_home')}}" name="{{__('messages.back_home')}}">{{__('messages.back_home')}}</a>
            </div>
        </div>
    </main>
@endsection


