@extends('home.master')

@section('title' , $title)
@section('content')
    <div class="allProfileIndex width">
        @include('home.profile.list' , ['tab' => $tab])
        <div class="profileIndexLike">
            <label>{{$title}}</label>
            <ul>
                @foreach($likePosts as $item)
                    <li>
                        <a href="/product/{{$item->slug}}">
                            <div class="userItemPic">
                                <img src="{{json_decode($item->image)[0]}}" alt="{{$item->titleSeo}}">
                            </div>
                            <div class="userItemSubject">
                                <div class="userItemSubjectTitle">{{$item->title}}</div>
                                <div class="postPriceItem">
                                    @if($item->off)
                                        <div class="offPrice">
                                            <s>{{number_format($item->offPrice)}} {{__('messages.arz')}}</s>
                                        </div>
                                    @endif
                                    <h3>{{number_format($item->price)}} {{__('messages.arz')}}</h3>
                                </div>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
