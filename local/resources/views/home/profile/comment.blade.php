@extends('home.master')

@section('title' , __('messages.comments'))
@section('content')
    <div class="allProfileIndex width">
        @include('home.profile.list' , ['tab' => 4])
        <div class="allProduct">
            <table>
                <tr>
                    <th>نوع</th>
                    <th>{{__('messages.picture1')}}</th>
                    <th>{{__('messages.title1')}}</th>
                    <th>{{__('messages.status')}}</th>
                    <th>{{__('messages.order_created')}}</th>
                </tr>
                @foreach($comments as $item)
                    <tr>
                        <td>
                            @if($item->type == 0)
                                محصول
                            @elseif($item->type == 1)
                                غرفه دار
                            @endif
                        </td>
                        <td>
                            <div class="pic">
                                @if($item->type == 0)
                                    @if($item->product)
                                        @if($item->product->image != '[]')
                                            <a href="/product/{{$item->product->slug}}">
                                                <img src="{{json_decode($item->product->image)[0]}}" alt="{{$item->product->title}}">
                                            </a>
                                        @endif
                                    @endif
                                @elseif($item->type == 1)
                                    @if($item->user)
                                        <a href="/{{'@'.$item->user->slug}}">
                                            <img src="{{$item->user->profile??'/img/user.png'}}" alt="{{$item->user->name}}">
                                        </a>
                                    @endif
                                @endif
                            </div>
                        </td>
                        <td>{{$item->title}}</td>
                        <td>{{$item->status == 1?'تایید شده':'در حال بررسی'}}</td>
                        <td>{{$item->created_at}}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
