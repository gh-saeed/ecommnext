@extends('admin.master')

@section('tab',16)
@section('content')
    <div class="allCreatePost">
        <div class="allCreatePost">
            <div class="allPostPanelTop">
                <h1>افزودن سوالات متداول</h1>
                <div class="allPostTitle">
                    <a href="/admin">داشبورد</a>
                    <span>/</span>
                    <a href="/admin/ask">همه سوالات متداول ها</a>
                    <span>/</span>
                    <a href="/admin/ask/create">افزودن سوال</a>
                </div>
            </div>
            <div class="allCreatePostData">
                <div class="allCreatePostSubject">
                    <div class="allCreatePostItem">
                        <label>عنوان* :</label>
                        <input type="text" name="title" placeholder="عنوان را وارد کنید">
                        <div id="validation-title"></div>
                    </div>
                    <div class="allCreatePostItem">
                        <label>توضیحات* :</label>
                        <textarea name="body" placeholder="توضیحات را وارد کنید"></textarea>
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
            $("button[name='createPost']").click(function(event){
                var title = $(".allCreatePostSubject input[name='title']").val();
                var body = $(".allCreatePostSubject textarea[name='body']").val();

                var form = {
                    "_token": "{{ csrf_token() }}",
                    title:title,
                    body:body,
                };

                $.ajax({
                    url: "/admin/ask/create",
                    type: "post",
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
