@extends('seller.master')

@section('tab' , 9)
@section('content')
    <div class="allPayPanel">
        <div class="topProductIndex">
            <div class="right">
                <a href="/seller/dashboard">داشبورد</a>
                <span>/</span>
                <a href="/seller/cost-benefit">سود و زیان فروشگاه</a>
            </div>
        </div>
        @if (\Session::has('message'))
            <div class="alert">
                {!! \Session::get('message') !!}
            </div>
        @endif
        <div class="allStatistics">
            <div class="right">
                <h3>آمارگیری این ماه</h3>
                <div class="item">
                    <h4>فروش - تسویه حساب ها</h4>
                    <h5>{{number_format($profitsMonth - $costMonth)}} تومان</h5>
                </div>
                <div class="item">
                    <h4>تسویه حساب ها</h4>
                    <h5>{{number_format($costMonth)}}</h5>
                </div>
                <div class="item">
                    <h4>فروش به جز هزینه حمل</h4>
                    <h5>{{number_format($payPriceMonth)}}</h5>
                </div>
                <div class="item">
                    <h4>هزینه حمل</h4>
                    <h5>{{number_format($carrierPriceMonth)}}</h5>
                </div>
                <div class="item">
                    <h4>مرجوعی</h4>
                    <h5>{{number_format($backsMonth)}}</h5>
                </div>
                <div class="item">
                    <h4>پرداخت از درگاه</h4>
                    <h5>{{number_format($gatePayMonth)}}</h5>
                </div>
                <div class="item">
                    <h4>پرداخت از کیف پول</h4>
                    <h5>{{number_format($walletPayMonth)}}</h5>
                </div>
                <div class="item">
                    <h4>تعداد محصول فروخته شده</h4>
                    <h5>{{number_format($productsMonth)}}</h5>
                </div>
            </div>
            <div class="left">
                <h3>آمارگیری کلی</h3>
                <div class="item">
                    <h4>فروش - تسویه حساب ها</h4>
                    <h5>{{number_format($profits - $cost)}} تومان</h5>
                </div>
                <div class="item">
                    <h4>تسویه حساب ها</h4>
                    <h5>{{number_format($cost)}}</h5>
                </div>
                <div class="item">
                    <h4>فروش به جز هزینه حمل</h4>
                    <h5>{{number_format($payPrice)}}</h5>
                </div>
                <div class="item">
                    <h4>هزینه حمل</h4>
                    <h5>{{number_format($carrierPrice)}}</h5>
                </div>
                <div class="item">
                    <h4>مرجوعی</h4>
                    <h5>{{number_format($backs)}}</h5>
                </div>
                <div class="item">
                    <h4>پرداخت از درگاه</h4>
                    <h5>{{number_format($gatePay)}}</h5>
                </div>
                <div class="item">
                    <h4>پرداخت از کیف پول</h4>
                    <h5>{{number_format($walletPay)}}</h5>
                </div>
                <div class="item">
                    <h4>تعداد محصول فروخته شده</h4>
                    <h5>{{number_format($products)}}</h5>
                </div>
            </div>
        </div>
    </div>
@endsection
