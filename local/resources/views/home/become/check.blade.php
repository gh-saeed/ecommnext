@extends('home.master')

@section('title' , __('messages.seller'))
@section('content')
    <div class="allBecomeSeller width">
        @if (\Session::has('success'))
            <div class="success">
                {!! \Session::get('success') !!}
            </div>
        @endif
        <div class="checkUploaded">
            <h3>{{__('messages.seller_doc_status')}}</h3>
            <table>
                <tr>
                    <th>{{__('messages.seller_front')}}</th>
                    <th>{{__('messages.seller_back')}}</th>
                    <th>{{__('messages.seller_doc_status1')}}</th>
                    <th>{{__('messages.seller_created')}}</th>
                </tr>
                @foreach ($documents as $item)
                    <tr>
                        <td>
                                <span>
                                    <img src="{{$item->frontNaturalId}}" alt="{{__('messages.seller_front')}}">
                                </span>
                        </td>
                        <td>
                                <span>
                                    <img src="{{$item->backNaturalId}}" alt="{{__('messages.seller_back')}}">
                                </span>
                        </td>
                        <td>
                            @if($item->status == 0)
                                <span>{{__('messages.seller_wait')}}</span>
                            @endif
                            @if($item->status == 1)
                                <span class="unActive">{{__('messages.seller_reject')}}</span>
                            @endif
                            @if($item->status == 2)
                                <span class="activeStatus">{{__('messages.seller_accept')}}</span>
                            @endif
                        </td>
                        <td>
                            <span>{{$item->created_at}}</span>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
