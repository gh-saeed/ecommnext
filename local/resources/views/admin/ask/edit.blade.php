@extends('admin.master')

@section('tab',16)
@section('content')
    <div class="allCreatePost">
        <div class="allCreatePost">
            <div class="allPostPanelTop">
                <h1>افزودن سوال</h1>
                <div class="allPostTitle">
                    <a href="/admin">داشبورد</a>
                    <span>/</span>
                    <a href="/admin/ask">همه سوال ها</a>
                    <span>/</span>
                    <a href="/admin/ask/{{$posts->id}}/edit">ویرایش سوال</a>
                </div>
            </div>
            <div class="allCreatePostData">
                <div class="allCreatePostSubject">
                    <div class="allCreatePostItem">
                        <label>عنوان سئو :</label>
                        <input type="text" name="title" value="{{ old('title', $posts->title) }}" placeholder="عنوان را وارد کنید">
                        <div id="validation-title"></div>
                    </div>
                    <div class="allCreatePostItem">
                        <label>توضیحات سئو :</label>
                        <textarea name="body" placeholder="توضیحات را وارد کنید">{{$posts->body}}</textarea>
                        <div id="validation-body"></div>
                    </div>
                    <button class="button" name="createPost" type="submit">ارسال اطلاعات</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts3')
    <script>
        $(document).ready(function(){
            var posts = {!! $posts->toJson() !!};
            $(".allCreatePostItem select[name='language']").val(posts.language);
            $("button[name='createPost']").click(function(event){
                var title = $(".allCreatePostItem input[name='title']").val();
                var body = $(".allCreatePostItem textarea[name='body']").val();

                var form = {
                    "_token": "{{ csrf_token() }}",
                    title:title,
                    body:body,
                };

                $.ajax({
                    url: "/admin/ask/"+posts.id+"/edit",
                    type: "put",
                    data: form,
                    success: function (data) {
                        window.location.href="/admin/ask";
                    },
                    error: function (xhr) {
                        $.each(xhr.responseJSON.errors, function(key,value) {
                            $('#validation-' + key).append('<div class="alert alert-danger">'+value+'</div');
                        });
                    }
                });
            });
        })
    </script>
@endsection
