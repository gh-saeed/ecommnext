@extends('admin.master')

@section('tab',4)

@section('content')
    <div class="allManageSetting">
        <div class="topProductIndex">
            <div class="right">
                <a href="/admin">داشبورد</a>
                <span>/</span>
                <a href="/admin/setting/payment">تنظیمات درگاه</a>
            </div>
        </div>
        @if (\Session::has('message'))
            <div class="alert">
                {!! \Session::get('message') !!}
            </div>
        @endif
        <form method="post" action="/admin/setting/payment" class="settingMangeItems">
            @csrf
            <div class="settingItem">
                <label>کد مرچنت زرینپال</label>
                <input type="text" name="zarinpal" value="{{$zarinpal}}" placeholder="کد را وارد کنید">
            </div>
            <div class="settingItem">
                <label>کد مرچنت زیبال</label>
                <input type="text" name="zibal" value="{{$zibal}}" placeholder="کد را وارد کنید">
            </div>
            <div class="settingItem">
                <label>کد مرچنت آیدی پی</label>
                <input type="text" name="idpay" value="{{$idpay}}" placeholder="کد را وارد کنید">
            </div>
            <div class="settingItem">
                <label>کد مرچنت نکست پی</label>
                <input type="text" name="nextpay" value="{{$nextpay}}" placeholder="کد را وارد کنید">
            </div>
            <div class="settingItem">
                <label>کد مرچنت سامان</label>
                <input type="text" name="samansep" value="{{$samansep}}" placeholder="کد را وارد کنید">
            </div>
            <div class="settingItem">
                <label>ترمینال آیدی به پرداخت</label>
                <input type="text" name="terminalBeh" value="{{$terminalBeh}}" placeholder="ترمینال آیدی را وارد کنید">
            </div>
            <div class="settingItem">
                <label>نام کاربری به پرداخت</label>
                <input type="text" name="userBeh" value="{{$userBeh}}" placeholder="نام کاربری را وارد کنید">
            </div>
            <div class="settingItem">
                <label>رمز به پرداخت</label>
                <input type="text" name="passwordBeh" value="{{$passwordBeh}}" placeholder="رمز را وارد کنید">
            </div>
            <div class="settingItem">
                <label>مرچنت پاسارگاد</label>
                <input type="text" name="merchantPasargad" value="{{$merchantPasargad}}" placeholder="مرچنت را وارد کنید">
            </div>
            <div class="settingItem">
                <label>ترمینال پاسارگاد</label>
                <input type="text" name="terminalPasargad" value="{{$terminalPasargad}}" placeholder="ترمینال را وارد کنید">
            </div>
            <div class="settingItem">
                <label>مدرک به صورت متن پاسارگاد</label>
                <input type="text" name="certificatePasargad" value="{{$certificatePasargad}}" placeholder="مدرک به صورت متن را وارد کنید">
            </div>
            <div class="settingItem">
                <label>مرچنت آسان پرداخت</label>
                <input type="text" name="terminalAsan" value="{{$terminalAsan}}" placeholder="مرچنت را وارد کنید">
            </div>
            <div class="settingItem">
                <label>نام کاربری آسان پرداخت</label>
                <input type="text" name="userAsan" value="{{$userAsan}}" placeholder="نام کاربری را وارد کنید">
            </div>
            <div class="settingItem">
                <label>رمز آسان پرداخت</label>
                <input type="text" name="passwordAsan" value="{{$passwordAsan}}" placeholder="رمز را وارد کنید">
            </div>
            <div class="settingItem">
                <label>کلید سداد</label>
                <input type="text" name="keySadad" value="{{$keySadad}}" placeholder="کد را وارد کنید">
            </div>
            <div class="settingItem">
                <label>کد پذیرنده سداد</label>
                <input type="text" name="merchantSadad" value="{{$merchantSadad}}" placeholder="مرچنت آیدی را وارد کنید">
            </div>
            <div class="settingItem">
                <label>پایانه سداد</label>
                <input type="text" name="terminalSadad" value="{{$terminalSadad}}" placeholder="ترمینال آیدی را وارد کنید">
            </div>
            <div class="settingItem">
                <label>درگاه خود را انتخاب کنید</label>
                <select name="choicePay">
                    <option value="0">زرینپال</option>
                    <option value="1">زیبال</option>
                    <option value="2">نکست پی</option>
                    <option value="3">آیدی پی</option>
                    <option value="4">به پرداخت ملت</option>
                    <option value="5">سداد</option>
                </select>
            </div>
            <div class="allCreatePostDetailItem">
                <label for="zarinpalStatus1" class="allCreatePostDetailItemData">
                    امکان خرید از زرینپال
                    <input id="zarinpalStatus1" type="checkbox" name="zarinpalStatus" class="switch" >
                </label>
                <label for="zibalStatus1" class="allCreatePostDetailItemData">
                    امکان خرید از زیبال
                    <input id="zibalStatus1" type="checkbox" name="zibalStatus" class="switch" >
                </label>
                <label for="nextpayStatus1" class="allCreatePostDetailItemData">
                    امکان خرید از نکست پی
                    <input id="nextpayStatus1" type="checkbox" name="nextpayStatus" class="switch" >
                </label>
                <label for="idpayStatus1" class="allCreatePostDetailItemData">
                    امکان خرید از آیدی پی
                    <input id="idpayStatus1" type="checkbox" name="idpayStatus" class="switch" >
                </label>
                <label for="statusBeh1" class="allCreatePostDetailItemData">
                    امکان خرید از به پرداخت ملت
                    <input id="statusBeh1" type="checkbox" name="statusBeh" class="switch" >
                </label>
                <label for="statusSadad1" class="allCreatePostDetailItemData">
                    امکان خرید از سداد
                    <input id="statusSadad1" type="checkbox" name="statusSadad" class="switch" >
                </label>
                <label for="statusAsan1" class="allCreatePostDetailItemData">
                    امکان خرید از آسان پرداخت
                    <input id="statusAsan1" type="checkbox" name="statusAsan" class="switch" >
                </label>
                <label for="statusAsan2" class="allCreatePostDetailItemData">
                    امکان خرید از پاسارگاد
                    <input id="statusAsan2" type="checkbox" name="statusPasargad" class="switch" >
                </label>
                <label for="statusSaman1" class="allCreatePostDetailItemData">
                    امکان خرید از سامان(سپ)
                    <input id="statusSaman1" type="checkbox" name="statusSaman" class="switch" >
                </label>
            </div>
            <button>ثبت اطلاعات</button>
        </form>
    </div>
@endsection

@section('scripts3')
    <script>
        $(document).ready(function(){
            var choicePay = {!! json_encode($choicePay, JSON_HEX_TAG) !!};
            var zarinpalStatus = {!! json_encode($zarinpalStatus, JSON_HEX_TAG) !!};
            var zibalStatus = {!! json_encode($zibalStatus, JSON_HEX_TAG) !!};
            var nextpayStatus = {!! json_encode($nextpayStatus, JSON_HEX_TAG) !!};
            var idpayStatus = {!! json_encode($idpayStatus, JSON_HEX_TAG) !!};
            var statusBeh = {!! json_encode($statusBeh, JSON_HEX_TAG) !!};
            var statusSadad = {!! json_encode($statusSadad, JSON_HEX_TAG) !!};
            var statusAsan = {!! json_encode($statusAsan, JSON_HEX_TAG) !!};
            var statusPasargad = {!! json_encode($statusPasargad, JSON_HEX_TAG) !!};
            var statusSaman = {!! json_encode($statusSaman, JSON_HEX_TAG) !!};
            $("select[name='choicePay']").val(choicePay);
            if(zarinpalStatus == 1){
                $("input[name='zarinpalStatus']").prop("checked", true );
            }
            if(zibalStatus == 1){
                $("input[name='zibalStatus']").prop("checked", true );
            }
            if(nextpayStatus == 1){
                $("input[name='nextpayStatus']").prop("checked", true );
            }
            if(idpayStatus == 1){
                $("input[name='idpayStatus']").prop("checked", true );
            }
            if(statusBeh == 1){
                $("input[name='statusBeh']").prop("checked", true );
            }
            if(statusSadad == 1){
                $("input[name='statusSadad']").prop("checked", true );
            }
            if(statusAsan == 1){
                $("input[name='statusAsan']").prop("checked", true );
            }
            if(statusPasargad == 1){
                $("input[name='statusPasargad']").prop("checked", true );
            }
            if(statusSaman == 1){
                $("input[name='statusSaman']").prop("checked", true );
            }
        })
    </script>
@endsection

@section('jsScript')
    <script src="/js/editor/ckeditor.js"></script>
    <script src="/js/editor/adapters/jquery.js"></script>
@endsection
