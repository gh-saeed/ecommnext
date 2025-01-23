@extends('seller.master')

@section('tab',10)
@section('content')
    <div class="allExcelPanel">
        <div class="allExcelPanelTop">
            <h1>خروجی اکسل</h1>
            <div class="allExcelPanelTitle">
                <a href="/seller/dashboard">داشبورد</a>
                <span>/</span>
                <a href="/seller/excel">خروجی اکسل</a>
            </div>
        </div>
        <div class="allExcelPanelItems">
            <a href="/seller/get-excel/allProduct" class="allExcelItem">
                <i>
                    <svg class="icon">
                        <use xlink:href="#excel2"></use>
                    </svg>
                </i>
                <h3>خروجی همه محصولات</h3>
            </a>
            <a href="/seller/get-excel/todayProduct" class="allExcelItem">
                <i>
                    <svg class="icon">
                        <use xlink:href="#excel2"></use>
                    </svg>
                </i>
                <h3>خروجی محصولات امروز</h3>
            </a>
            <a href="/seller/get-excel/allPay" class="allExcelItem">
                <i>
                    <svg class="icon">
                        <use xlink:href="#excel2"></use>
                    </svg>
                </i>
                <h3>خروجی همه سفارش ها</h3>
            </a>
            <a href="/seller/get-excel/todayPay" class="allExcelItem">
                <i>
                    <svg class="icon">
                        <use xlink:href="#excel2"></use>
                    </svg>
                </i>
                <h3>خروجی سفارش امروز</h3>
            </a>
            <a href="/seller/get-excel/allPayMeta" class="allExcelItem">
                <i>
                    <svg class="icon">
                        <use xlink:href="#excel2"></use>
                    </svg>
                </i>
                <h3>خروجی همه محصولات خریداری شده</h3>
            </a>
            <a href="/seller/get-excel/todayPayMeta" class="allExcelItem">
                <i>
                    <svg class="icon">
                        <use xlink:href="#excel2"></use>
                    </svg>
                </i>
                <h3>خروجی محصولات خریداری شده امروز</h3>
            </a>
        </div>
    </div>
@endsection
