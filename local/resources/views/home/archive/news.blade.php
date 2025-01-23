@extends('home.master')

@section('title' , $category->name)
@section('content')
    <div class="allNews width">
        <h1>{{$category->name}}</h1>
        <div class="allNewsRight">
            <div class="allNewsRightItems">
                @foreach ($news as $item)
                    <a class="allNewsRightItem" href="/blog/{{$item->slug}}" title="{{$item->titleSeo}}">
                        <figure>
                            <img src="{{$item->image}}" alt="{{$item->imageAlt}}">
                        </figure>
                        <div class="allNewsRightItemOver">
                            <h3>{{$item->title}}</h3>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        @if($category->body)
            <div class="description">
                <p>{{$category->body}}</p>
            </div>
        @endif
    </div>
@endsection
