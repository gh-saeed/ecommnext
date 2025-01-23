@extends('admin.master')

@section('tab',9)
@section('content')
    <div class="allCommentPanel">
        <div class="addComment">
            <div class="right">
                <div class="sendCommentItem">
                    <label for="status">وضعیت*</label>
                    <select name="status" id="status">
                        <option value="0">در حال بررسی</option>
                        <option value="1">تایید شده</option>
                        <option value="2">رد شده</option>
                    </select>
                </div>
                <div class="sendCommentItem">
                    <label for="bodyText">توضیحات*</label>
                    <textarea name="body" id="bodyText" placeholder="توضیحات را وارد کنید">{{$report->data}}</textarea>
                    <div id="validation-body"></div>
                </div>
                <div class="allCommentButtons">
                    <button id="createComment">ارسال</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts3')
    <script>
        $(document).ready(function(){
            var report = {!! $report->toJson() !!};
            $("select[name='status']").val(report.status);
            $('.allCommentButtons #createComment').click(function (){
                var body = $("textarea[name='body']").val();
                var status = $("select[name='status']").val();

                var form = {
                    "_token": "{{ csrf_token() }}",
                    "_method": "post",
                    status:status,
                    body:body,
                };

                $.ajax({
                    url: "/admin/report/"+report.id+'/edit',
                    type: "post",
                    data: form,
                    success: function (data) {
                        $.toast({
                            text: "ثبت شد", // Text that is to be shown in the toast
                            heading: 'موفقیت آمیز', // Optional heading to be shown on the toast
                            icon: 'success', // Type of toast icon
                            showHideTransition: 'fade', // fade, slide or plain
                            allowToastClose: true, // Boolean value true or false
                            hideAfter: 3000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                            stack: 5, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
                            position: 'bottom-left', // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values
                            textAlign: 'left',  // Text alignment i.e. left, right or center
                            loader: true,  // Whether to show loader or not. True by default
                            loaderBg: '#9EC600',  // Background color of the toast loader
                        });
                        window.location.href = '/admin/report';
                    },
                    error: function (xhr) {
                        $.toast({
                            text: "فیلد های ستاره دار را پر کنید", // Text that is to be shown in the toast
                            heading: 'دقت کنید', // Optional heading to be shown on the toast
                            icon: 'error', // Type of toast icon
                            showHideTransition: 'fade', // fade, slide or plain
                            allowToastClose: true, // Boolean value true or false
                            hideAfter: 3000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                            stack: 5, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
                            position: 'bottom-left', // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values
                            textAlign: 'left',
                            loader: true,
                            loaderBg: '#c60000',
                        });
                        $.each(xhr.responseJSON.errors, function(key,value) {
                            $('#validation-' + key).append('<div class="alert alert-danger">'+value+'</div');
                        });
                    }
                });
            })
        })
    </script>
@endsection

@section('jsScript')
    <script src="/js/jquery.toast.min.js"></script>
@endsection

@section('links')
    <link rel="stylesheet" href="/css/jquery.toast.min.css"/>
@endsection
