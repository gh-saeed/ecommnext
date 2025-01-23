@extends('admin.master')

@section('tab',4)

@section('content')
    <div class="allManageSetting">
        <div class="topProductIndex">
            <div class="right">
                <a href="/admin">داشبورد</a>
                <span>/</span>
                <a href="#">تنظیمات گالری</a>
            </div>
        </div>
        @if (Session::has('message'))
            <div class="alert">
                {!! \Session::get('message') !!}
            </div>
        @endif
        <form method="post" action="/admin/setting/gallery" class="settingMangeItems">
            @csrf
            @if (!extension_loaded('fileinfo'))
                <div class="alert" style="background: red;color: white">
                    اکستنشن fileinfo فعال نیست. لطفاً این اکستنشن را فعال کنید.
                </div>
            @endif
            @if (!ini_get('allow_url_fopen'))
                <div class="alert" style="background: red;color: white">
                    اکستنشن allow_url_fopen فعال نیست. لطفاً این اکستنشن را فعال کنید.
                </div>
            @endif
            <h3 style="margin-top: 1rem">بهینه سازی تصاویر</h3>
            <div class="settingItemPage">
                <div class="settingItem">
                    <label for="">درصد بهینه سازی و کم کردن حجم (1-99)</label>
                    <input type="text" name="optimizeImage" value="{{$optimizeImage}}">
                </div>
                <div class="settingItem">
                    <label for="">تبدیل تصاویر به :</label>
                    <select name="changeImage">
                        <option value="webp">webp</option>
                        <option value="jpg">jpg</option>
                        <option value="png">png</option>
                    </select>
                </div>
            </div>
            <h3>واترمارک</h3>
            <div class="settingItemPage">
                <div class="settingItem">
                    <label for="">تصویر واترمارک</label>
                    <input type="text" name="watermarkImage" placeholder="آدرس تصویر" value="{{$watermarkImage}}">
                </div>
                <div class="settingItem">
                    <label for="">وضعیت واترمارک</label>
                    <select name="watermarkStatus">
                        <option value="1" {{$watermarkStatus == 1 ? 'selected' : ''}}>فعال</option>
                        <option value="0" {{$watermarkStatus == 0 ? 'selected' : ''}}>غیرفعال</option>
                    </select>
                </div>
            </div>
            <button>ثبت اطلاعات</button>
        </form>
    </div>
@endsection

@section('scripts3')
    <script>
        $(document).ready(function(){
            var changeImage = {!! json_encode($changeImage, JSON_HEX_TAG) !!};
            $(".settingMangeItems select[name='changeImage']").val(changeImage);
        })
    </script>
@endsection
