@extends('home.master')

@section('title' , __('messages.order_user'))
@section('content')
    <div class="allProfileIndex width">
        @include('home.profile.list' , ['tab' => 1])
        <div>
            <div class="profileIndexPay">
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
