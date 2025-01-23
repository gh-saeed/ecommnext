@extends('home.master')

@section('title' , __('messages.faq') . ' - ')
@section('content')
    <main class="allFaqIndex width">
        @if (\Session::has('message'))
            <div class="alert">
                {!! \Session::get('message') !!}
            </div>
        @endif
        @if (\Session::has('success'))
            <div class="success">
                {!! \Session::get('success') !!}
            </div>
        @endif
        <section class="questions">
            <h1>{{__('messages.faq')}}</h1>
            @foreach($asks as $item)
                <div class="questionIndex">
                    <div class="title">
                        <h3>{{$item->title}}</h3>
                        <i>
                            <svg class="icon">
                                <use xlink:href="#down"></use>
                            </svg>
                        </i>
                    </div>
                    <div class="description">
                        <p>{!! $item->body !!}</p>
                    </div>
                </div>
            @endforeach
        </section>
    </main>
@endsection

@section('scriptPage')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var req_field11 = {!! json_encode(__('messages.req_field'), JSON_HEX_TAG) !!};
            var elements = document.getElementsByTagName("INPUT");
            for (var i = 0; i < elements.length; i++) {
                elements[i].oninvalid = function(e) {
                    e.target.setCustomValidity("");
                    if (!e.target.validity.valid) {
                        e.target.setCustomValidity(req_field1);
                    }
                };
                elements[i].oninput = function(e) {
                    e.target.setCustomValidity("");
                };
            }
            var elements2 = document.getElementsByTagName("TEXTAREA");
            for (i = 0; i < elements2.length; i++) {
                elements2[i].oninvalid = function(e) {
                    e.target.setCustomValidity("");
                    if (!e.target.validity.valid) {
                        e.target.setCustomValidity(req_field1);
                    }
                };
                elements[i].oninput = function(e) {
                    e.target.setCustomValidity("");
                };
            }
        })
        $(document).ready(function(){
            $('.questions .questionIndex').on('click',function(){
                $.each($('.description') , function(){
                    $(this).hide();
                })
                $(this.lastElementChild).toggle();
            })
            $('.questions #buttonQuestion button').on('click',function(){
                $('.questions').toggle();
                $('.tickets').toggle();
            })
            $('.tickets .ticketButtons h4').on('click',function(){
                $('.questions').toggle();
                $('.tickets').toggle();
            })
        })
    </script>
@endsection
