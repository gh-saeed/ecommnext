@extends('seller.master')

@section('tab',10)
@section('content')
    <div class="allExcelPanel">
        <div class="allExcelPanelTop">
            <h1>درون ریزی</h1>
            <div class="allExcelPanelTitle">
                <a href="/admin">داشبورد</a>
                <span>/</span>
                <a href="/admin/import">درون ریزی</a>
            </div>
        </div>
        <div class="items">
            <div class="item import1">
                <div class="abilityPost">
                    <div class="abilityTitle">
                        <label>چینش اکسل محصولات</label>
                    </div>
                    <table class="abilityTable" id="pays">
                        <tr>
                            <th>1-عنوان</th>
                            <th>2-کد محصول</th>
                            <th>3-مبلغ اصلی</th>
                            <th>4-تخفیف</th>
                            <th>5-تعداد</th>
                            <th>6-تصویر (با , جدا کنید)</th>
                            <th>7-توضیح</th>
                            <th>8-وزن</th>
                            <th>9-آیدی حامل</th>
                            <th>10-دسته بندی</th>
                        </tr>
                    </table>
                </div>
                <form method="post" id="upload-image-form" enctype="multipart/form-data">
                    @csrf
                    <div class="sendImage">
                        <input type="file" id="post_cover" class="dropify" name="image"/>
                    </div>
                    <button type="submit" id="upload-image">آپلود</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts4')
    <script>
        $(document).ready(function(){
            $('.import1 #upload-image-form').submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                $('.import1 #upload-image').text('صبر کنید ..');
                $.ajax({
                    type:'POST',
                    url: `/admin/import-product`,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: (response) => {
                        $('.import1 #upload-image').text('آپلود');
                        alert('محصول منتقل شد')
                    },
                    error: function(response){
                        $('.import1 #upload-image').text('آپلود');
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
@endsection

@section('jsScript2')
    <script src="/js/jquery.toast.min.js"></script>
    <script src="/js/dropify.min.js"></script>
@endsection
