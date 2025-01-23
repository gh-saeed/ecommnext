@extends('admin.master')

@section('tab',20)
@section('content')
    <div class="allExcelPanel">
        <div class="allExcelPanelTop">
            <h1>خروجی اکسل</h1>
            <div class="allExcelPanelTitle">
                <a href="/admin">داشبورد</a>
                <span>/</span>
                <a href="/admin/excel">خروجی اکسل</a>
            </div>
        </div>
        <div class="allExcelPanelItems">
            <a href="/admin/get-excel/allUser" class="allExcelItem">
                <i>
                    <svg class="icon">
                        <use xlink:href="#excel2"></use>
                    </svg>
                </i>
                <h3>خروجی همه کاربران</h3>
            </a>
            <a href="/admin/get-excel/todayUser" class="allExcelItem">
                <i>
                    <svg class="icon">
                        <use xlink:href="#excel2"></use>
                    </svg>
                </i>
                <h3>خروجی کاربران امروز</h3>
            </a>
            <a href="/admin/get-excel/allProduct" class="allExcelItem">
                <i>
                    <svg class="icon">
                        <use xlink:href="#excel2"></use>
                    </svg>
                </i>
                <h3>خروجی همه محصولات</h3>
            </a>
            <a href="/admin/get-excel/todayProduct" class="allExcelItem">
                <i>
                    <svg class="icon">
                        <use xlink:href="#excel2"></use>
                    </svg>
                </i>
                <h3>خروجی محصولات امروز</h3>
            </a>
            <a href="/admin/get-excel/allPay" class="allExcelItem">
                <i>
                    <svg class="icon">
                        <use xlink:href="#excel2"></use>
                    </svg>
                </i>
                <h3>خروجی همه سفارش ها</h3>
            </a>
            <a href="/admin/get-excel/todayPay" class="allExcelItem">
                <i>
                    <svg class="icon">
                        <use xlink:href="#excel2"></use>
                    </svg>
                </i>
                <h3>خروجی سفارش امروز</h3>
            </a>
            <a href="/admin/get-excel/allNews" class="allExcelItem">
                <i>
                    <svg class="icon">
                        <use xlink:href="#excel2"></use>
                    </svg>
                </i>
                <h3>خروجی همه بلاگ ها</h3>
            </a>
            <a href="/admin/get-excel/todayNews" class="allExcelItem">
                <i>
                    <svg class="icon">
                        <use xlink:href="#excel2"></use>
                    </svg>
                </i>
                <h3>خروجی بلاگ امروز</h3>
            </a>
            <a href="/admin/get-excel/allPayMeta" class="allExcelItem">
                <i>
                    <svg class="icon">
                        <use xlink:href="#excel2"></use>
                    </svg>
                </i>
                <h3>خروجی همه محصولات خریداری شده</h3>
            </a>
            <a href="/admin/get-excel/todayPayMeta" class="allExcelItem">
                <i>
                    <svg class="icon">
                        <use xlink:href="#excel2"></use>
                    </svg>
                </i>
                <h3>خروجی محصولات خریداری شده امروز</h3>
            </a>
            <a href="/admin/get-excel/allComment" class="allExcelItem">
                <i>
                    <svg class="icon">
                        <use xlink:href="#excel2"></use>
                    </svg>
                </i>
                <h3>خروجی همه دیدگاه ها</h3>
            </a>
            <a href="/admin/get-excel/todayComment" class="allExcelItem">
                <i>
                    <svg class="icon">
                        <use xlink:href="#excel2"></use>
                    </svg>
                </i>
                <h3>خروجی دیدگاه امروز</h3>
            </a>
        </div>
    </div>
@endsection
