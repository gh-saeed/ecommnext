@extends('home.master')

@section('title' , $post->title)
@section('content')
    <main class="allSingleNews width">
    <div class="right">
        <figure class="pic">
            <img class="lazyload" src="{{$post->image}}" alt="{{$post->imageAlt}}">
        </figure>
        <div class="postsList">
            <div class="titleList">
                مطالب مرتبط
            </div>
            <ul>
                @foreach($related as $item)
                    <li>
                        <a href="/blog/{{$item->slug}}" title="{{$item->titleSeo}}">
                            <img src="{{$item->image}}" alt="{{$item->imageAlt}}">
                            <div class="showInfo">
                                <h4>{{$item->title}}</h4>
                                <span>{{$item->created_at}}</span>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="left">
        <div class="top">
            <h1>{{$post->title}}</h1>
        </div>
        <div class="leftItem">
            <div class="option">
                <h3>دسته بندی ها</h3>
                @if(count($post->category) >= 1)
                    <a href="/blog/category/{{$post->category[0]->slug}}">{{$post->category[0]->name}}</a>
                @else
                    <a>بدون دسته بندی</a>
                @endif
            </div>
            <div class="option">
                <h3>نویسنده</h3>
                @if($post->user)
                    <a href="/{{'@'.$post->user->slug}}">{{$post->user->name}}</a>
                @else
                    <a>بدون دسته بندی</a>
                @endif
            </div>
            <div class="option">
                <h3>تاریخ انتشار</h3>
                <a>{{$post->created_at}}</a>
            </div>
            <div class="option">
                <h3>زمان مطالعه</h3>
                <a>
                        <span>
                            {{$post->time}}
                        </span>
                    دقیقه
                </a>
            </div>
        </div>
        <div class="leftP">{!! $post->body !!}</div>
    </div>
    </main>
@endsection
