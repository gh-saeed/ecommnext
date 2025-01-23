@extends('admin.master')

@section('tab',18)
@section('content')
    <div class="changeExcel">
        <div class="allExcelPanel">
            <div class="allExcelPanelTop">
                <h1>تغییر قیمت با وارد کردن اکسل</h1>
                <div class="allExcelPanelTitle">
                    <a href="/admin">داشبورد</a>
                    <span>/</span>
                    <a href="/admin/change-price/excel">تغییر قیمت با وارد کردن اکسل</a>
                </div>
            </div>
            <div class="importDataExcel">
                <form method="post" id="upload-image-form" enctype="multipart/form-data">
                    @csrf
                    <div class="sendImage">
                        <input type="file" id="post_cover" class="dropify" name="image"/>
                    </div>
                    <button type="submit" id="upload-image">آپلود</button>
                </form>
            </div>
            <div class="infoImport">
                <ul>
                    <li>مقدار اول فایل اکسل شما باید عنوان محصول یا کد محصول</li>
                    <li>مقدار دوم فایل اکسل شما باید قیمت جدید شما باشد</li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('scripts3')
    <script>
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#upload-image-form').submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);

                $.ajax({
                    type:'POST',
                    url: `/admin/change-price/excel`,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: (response) => {
                        if (response) {
                            $.toast({
                                text: "فایل اضافه شد", // Text that is to be shown in the toast
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
                        }
                    },
                    error: function(response){
                        $('#image-input-error').text(response.responseJSON.errors.file);
                    }
                });
            });

            $('.dropify').dropify({
                messages: {
                    default: "بکشید و رها کنید یا برای انتخاب کلیک کنید.",
                    replace: "برای جایگزین کردن تصویر بکشید و رها کنید.",
                    remove: "حذف تصویر",
                    error: "خطایی به وجود آمده است. دوباره تلاش کنید.",
                }
            });
        })
    </script>
@endsection

@section('links2')
    <link rel="stylesheet" href="/css/dropify.min.css"/>
    <link rel="stylesheet" href="/css/jquery.toast.min.css"/>
    <script src="/js/jquery.toast.min.js"></script>
@endsection

@section('jsScript2')
    <script src="/js/dropify.min.js"></script>
@endsection
