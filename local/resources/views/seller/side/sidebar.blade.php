<div class="allSideBar">
    <div class="logoHeaderPanel">
        <a href="/">
            <img src="{{$logo}}">
        </a>
    </div>
    <div class="allSideBarItem">
        <div class="allSideBarIconsText">
            <div class="active" id="showList1">
                <i>
                    <svg class="icon">
                        <use xlink:href="#home"></use>
                    </svg>
                </i>
                <span class="sidemenu-label">{{__('messages.dashboard')}}</span>
                <i class="arrow">
                    <svg class="icon">
                        <use xlink:href="#left"></use>
                    </svg>
                </i>
            </div>
            <h4 class="unActive" id="showList1">
                <i>
                    <svg class="icon">
                        <use xlink:href="#home"></use>
                    </svg>
                </i>
                {{__('messages.dashboard')}}
                <i class="arrow">
                    <svg class="icon">
                        <use xlink:href="#left"></use>
                    </svg>
                </i>
            </h4>
            <ul id="showList1" class="active">
                <li>
                    <a href="/">
                        <i>
                            <svg class="icon">
                                <use xlink:href="#left"></use>
                            </svg>
                        </i>
                        {{__('messages.home')}}
                    </a>
                </li>
                <li>
                    <a href="/seller/dashboard">
                        <i>
                            <svg class="icon">
                                <use xlink:href="#left"></use>
                            </svg>
                        </i>
                        داشبورد
                    </a>
                </li>
            </ul>
        </div>
        <a class="allSideBarIconsText" href="/seller/gallery">
            <div class="active" id="showList2">
                <i>
                    <svg class="icon">
                        <use xlink:href="#gallery"></use>
                    </svg>
                </i>
                <span class="sidemenu-label">{{__('messages.gallery')}}</span>
                <i class="arrow">
                    <svg class="icon">
                        <use xlink:href="#left"></use>
                    </svg>
                </i>
            </div>
            <h4 class="unActive" id="showList2">
                <i>
                    <svg class="icon">
                        <use xlink:href="#gallery"></use>
                    </svg>
                </i>
                {{__('messages.gallery')}}
                <i class="arrow">
                    <svg class="icon">
                        <use xlink:href="#left"></use>
                    </svg>
                </i>
            </h4>
        </a>
        <div class="allSideBarIconsText">
            <div class="active" id="showList3">
                <i>
                    <svg class="icon">
                        <use xlink:href="#post"></use>
                    </svg>
                </i>
                <span class="sidemenu-label">محصولات</span>
                <i class="arrow">
                    <svg class="icon">
                        <use xlink:href="#left"></use>
                    </svg>
                </i>
            </div>
            <h4 class="unActive" id="showList3">
                <i>
                    <svg class="icon">
                        <use xlink:href="#post"></use>
                    </svg>
                </i>
                محصولات
                <i class="arrow">
                    <svg class="icon">
                        <use xlink:href="#left"></use>
                    </svg>
                </i>
            </h4>
            <ul id="showList3" class="active">
                <li>
                    <a href="/seller/product">
                        <i>
                            <svg class="icon">
                                <use xlink:href="#left"></use>
                            </svg>
                        </i>
                        {{__('messages.all_product')}}
                    </a>
                </li>
                <li>
                    <a href="/seller/product/create">
                        <i>
                            <svg class="icon">
                                <use xlink:href="#left"></use>
                            </svg>
                        </i>
                        {{__('messages.add_product')}}
                    </a>
                </li>
                <li>
                    <a href="/seller/product/digikala">
                        <i>
                            <svg class="icon">
                                <use xlink:href="#left"></use>
                            </svg>
                        </i>
                        انتقال خودکار محصول از دیجیکالا
                    </a>
                </li>
                <li>
                    <a href="/seller/product/change">
                        <i>
                            <svg class="icon">
                                <use xlink:href="#left"></use>
                            </svg>
                        </i>
                        تغییر گروهی محصولات
                    </a>
                </li>
            </ul>
        </div>
        <div class="allSideBarIconsText">
            <div class="active" id="showList9">
                <i>
                    <svg class="icon">
                        <use xlink:href="#wallet"></use>
                    </svg>
                </i>
                <span class="sidemenu-label">موارد مالی</span>
                <i class="arrow">
                    <svg class="icon">
                        <use xlink:href="#left"></use>
                    </svg>
                </i>
            </div>
            <h4 class="unActive" id="showList9">
                <i>
                    <svg class="icon">
                        <use xlink:href="#wallet"></use>
                    </svg>
                </i>
                موارد مالی
                <i class="arrow">
                    <svg class="icon">
                        <use xlink:href="#left"></use>
                    </svg>
                </i>
            </h4>
            <ul id="showList9" class="active">
                <li>
                    <a href="/seller/checkout">
                        <i>
                            <svg class="icon">
                                <use xlink:href="#left"></use>
                            </svg>
                        </i>
                        تسویه حساب
                    </a>
                </li>
                <li>
                    <a href="/charge">
                        <i>
                            <svg class="icon">
                                <use xlink:href="#left"></use>
                            </svg>
                        </i>
                        افزایش حساب
                    </a>
                </li>
            </ul>
        </div>
        <a href="/seller/pay" class="allSideBarIconsText">
            <div class="active" id="showList4">
                <i>
                    <svg class="icon">
                        <use xlink:href="#pay"></use>
                    </svg>
                </i>
                <span class="sidemenu-label">{{__('messages.all_order1')}}</span>
                <i class="arrow">
                    <svg class="icon">
                        <use xlink:href="#left"></use>
                    </svg>
                </i>
            </div>
            <h4 class="unActive" id="showList4">
                <i>
                    <svg class="icon">
                        <use xlink:href="#pay"></use>
                    </svg>
                </i>
                {{__('messages.all_order1')}}
                <i class="arrow">
                    <svg class="icon">
                        <use xlink:href="#left"></use>
                    </svg>
                </i>
            </h4>
        </a>
        <a href="/seller/story" class="allSideBarIconsText">
            <div class="active" id="showList12">
                <i>
                    <svg class="icon">
                        <use xlink:href="#video"></use>
                    </svg>
                </i>
                <span class="sidemenu-label">استوری و ویدئوها</span>
                <i class="arrow">
                    <svg class="icon">
                        <use xlink:href="#left"></use>
                    </svg>
                </i>
            </div>
            <h4 class="unActive" id="showList12">
                <i>
                    <svg class="icon">
                        <use xlink:href="#video"></use>
                    </svg>
                </i>
                استوری و ویدئوها
                <i class="arrow">
                    <svg class="icon">
                        <use xlink:href="#left"></use>
                    </svg>
                </i>
            </h4>
        </a>
        <a href="/seller/carrier" class="allSideBarIconsText">
            <div class="active" id="showList6">
                <i>
                    <svg class="icon">
                        <use xlink:href="#car"></use>
                    </svg>
                </i>
                <span class="sidemenu-label">روش و هزینه ارسال</span>
                <i class="arrow">
                    <svg class="icon">
                        <use xlink:href="#left"></use>
                    </svg>
                </i>
            </div>
            <h4 class="unActive" id="showList6">
                <i>
                    <svg class="icon">
                        <use xlink:href="#car"></use>
                    </svg>
                </i>
                روش و هزینه ارسال
                <i class="arrow">
                    <svg class="icon">
                        <use xlink:href="#left"></use>
                    </svg>
                </i>
            </h4>
        </a>
        <div class="allSideBarIconsText">
            <div class="active" style="display: none" id="showList10">
                <i>
                    <svg class="icon">
                        <use xlink:href="#calculator"></use>
                    </svg>
                </i>
                <span class="sidemenu-label">
                    سیستم حسابداری
                </span>
                <i class="arrow">
                    <svg class="icon">
                        <use xlink:href="#left"></use>
                    </svg>
                </i>
            </div>
            <h4 class="unActive" id="showList10">
                <i>
                    <svg class="icon">
                        <use xlink:href="#calculator"></use>
                    </svg>
                </i>
                <span class="sidemenu-label">
                    سیستم حسابداری
                </span>
                <i class="arrow">
                    <svg class="icon">
                        <use xlink:href="#left"></use>
                    </svg>
                </i>
            </h4>
            <ul id="showList10" class="active">
                <li>
                    <a href="/seller/statistics/product">
                        <i>
                            <svg class="icon">
                                <use xlink:href="#left"></use>
                            </svg>
                        </i>
                        <span class="sidemenu-label">
                            آمارگیری فروش هر محصول
                        </span>
                    </a>
                </li>
                <li>
                    <a href="/seller/cost-benefit">
                        <i>
                            <svg class="icon">
                                <use xlink:href="#left"></use>
                            </svg>
                        </i>
                        <span class="sidemenu-label">
                            سود و زیان فروشگاه
                        </span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="allSideBarIconsText">
            <div class="active" id="showList5">
                <i>
                    <svg class="icon">
                        <use xlink:href="#box"></use>
                    </svg>
                </i>
                <span class="sidemenu-label">انبارداری</span>
                <i class="arrow">
                    <svg class="icon">
                        <use xlink:href="#left"></use>
                    </svg>
                </i>
            </div>
            <h4 class="unActive" id="showList5">
                <i>
                    <svg class="icon">
                        <use xlink:href="#box"></use>
                    </svg>
                </i>
                انبارداری
                <i class="arrow">
                    <svg class="icon">
                        <use xlink:href="#left"></use>
                    </svg>
                </i>
            </h4>
            <ul id="showList5" class="active">
                <li>
                    <a href="/seller/inquiry">
                        <i>
                            <svg class="icon">
                                <use xlink:href="#left"></use>
                            </svg>
                        </i>
                        استعلام موجودی کاربران
                    </a>
                </li>
                <li>
                    <a href="/seller/inventory">
                        <i>
                            <svg class="icon">
                                <use xlink:href="#left"></use>
                            </svg>
                        </i>
                        موجودی محصولات
                    </a>
                </li>
                <li>
                    <a href="/seller/empty">
                        <i>
                            <svg class="icon">
                                <use xlink:href="#left"></use>
                            </svg>
                        </i>
                        {{__('messages.empty_product')}}
                    </a>
                </li>
                <li>
                    <a href="/seller/tank">
                        <i>
                            <svg class="icon">
                                <use xlink:href="#left"></use>
                            </svg>
                        </i>
                        مشاهده و ثبت انبار
                    </a>
                </li>
                <li>
                    <a href="/seller/pay/returned">
                        <i>
                            <svg class="icon">
                                <use xlink:href="#left"></use>
                            </svg>
                        </i>
                        محصولات مرجوعی
                    </a>
                </li>
            </ul>
        </div>
        <div class="allSideBarIconsText">
            <div class="active" id="showList7">
                <i>
                    <svg class="icon">
                        <use xlink:href="#ticket2"></use>
                    </svg>
                </i>
                <span class="sidemenu-label">پشتیبانی</span>
                <i class="arrow">
                    <svg class="icon">
                        <use xlink:href="#left"></use>
                    </svg>
                </i>
            </div>
            <h4 class="unActive" id="showList7">
                <i>
                    <svg class="icon">
                        <use xlink:href="#ticket2"></use>
                    </svg>
                </i>
                پشتیبانی
                <i class="arrow">
                    <svg class="icon">
                        <use xlink:href="#left"></use>
                    </svg>
                </i>
            </h4>
            <ul id="showList7" class="active">
                <li>
                    <a href="/seller/ticket">
                        <i>
                            <svg class="icon">
                                <use xlink:href="#left"></use>
                            </svg>
                        </i>
                        ارسال تیکت
                    </a>
                </li>
                <li>
                    <a href="/seller/chat">
                        <i>
                            <svg class="icon">
                                <use xlink:href="#left"></use>
                            </svg>
                        </i>
                        گفت و گو
                    </a>
                </li>
            </ul>
        </div>
        <div class="allSideBarIconsText">
            <div class="active" style="display: none" id="showList11">
                <i>
                    <svg class="icon">
                        <use xlink:href="#excel2"></use>
                    </svg>
                </i>
                <span class="sidemenu-label">اکسل</span>
                <i class="arrow">
                    <svg class="icon">
                        <use xlink:href="#left"></use>
                    </svg>
                </i>
            </div>
            <h4 class="unActive" id="showList11">
                <i>
                    <svg class="icon">
                        <use xlink:href="#excel2"></use>
                    </svg>
                </i>
                اکسل
                <i class="arrow">
                    <svg class="icon">
                        <use xlink:href="#left"></use>
                    </svg>
                </i>
            </h4>
            <ul id="showList11" class="active">
                <li>
                    <a href="/seller/import">
                        <i>
                            <svg class="icon">
                                <use xlink:href="#left"></use>
                            </svg>
                        </i>
                        درون ریزی اکسل
                    </a>
                </li>
                <li>
                    <a href="/seller/excel">
                        <i>
                            <svg class="icon">
                                <use xlink:href="#left"></use>
                            </svg>
                        </i>
                        خروجی اکسل
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
@section('scripts2')
    <script>
        $(document).ready(function(){
            var tab = '{!! app()->view->getSections()['tab'] !!}';
            $('.allSideBarIconsText>.active').hide();
            if(tab == 0){
                $('.allSideBarIconsText>#showList1').each(function() {
                    if($( this ).attr('class') == 'active'){
                        $(this).show();
                    }else{
                        $(this).hide();
                    }
                });
            }
            if(tab == 1){
                $('.allSideBarIconsText>#showList2').each(function() {
                    if($( this ).attr('class') == 'active'){
                        $(this).show();
                    }else{
                        $(this).hide();
                    }
                });
            }
            if(tab == 2){
                $('.allSideBarIconsText>#showList3').each(function() {
                    if($( this ).attr('class') == 'active'){
                        $(this).show();
                    }else{
                        $(this).hide();
                    }
                });
            }
            if(tab == 3){
                $('.allSideBarIconsText>#showList4').each(function() {
                    if($( this ).attr('class') == 'active'){
                        $(this).show();
                    }else{
                        $(this).hide();
                    }
                });
            }
            if(tab == 4){
                $('.allSideBarIconsText>#showList5').each(function() {
                    if($( this ).attr('class') == 'active'){
                        $(this).show();
                    }else{
                        $(this).hide();
                    }
                });
            }
            if(tab == 5){
                $('.allSideBarIconsText>#showList6').each(function() {
                    if($( this ).attr('class') == 'active'){
                        $(this).show();
                    }else{
                        $(this).hide();
                    }
                });
            }
            if(tab == 6){
                $('.allSideBarIconsText>#showList7').each(function() {
                    if($( this ).attr('class') == 'active'){
                        $(this).show();
                    }else{
                        $(this).hide();
                    }
                });
            }
            if(tab == 7){
                $('.allSideBarIconsText>#showList8').each(function() {
                    if($( this ).attr('class') == 'active'){
                        $(this).show();
                    }else{
                        $(this).hide();
                    }
                });
            }
            if(tab == 8){
                $('.allSideBarIconsText>#showList9').each(function() {
                    if($( this ).attr('class') == 'active'){
                        $(this).show();
                    }else{
                        $(this).hide();
                    }
                });
            }
            if(tab == 9){
                $('.allSideBarIconsText>#showList10').each(function() {
                    if($( this ).attr('class') == 'active'){
                        $(this).show();
                    }else{
                        $(this).hide();
                    }
                });
            }
            if(tab == 10){
                $('.allSideBarIconsText>#showList11').each(function() {
                    if($( this ).attr('class') == 'active'){
                        $(this).show();
                    }else{
                        $(this).hide();
                    }
                });
            }
            if(tab == 11){
                $('.allSideBarIconsText>#showList12').each(function() {
                    if($( this ).attr('class') == 'active'){
                        $(this).show();
                    }else{
                        $(this).hide();
                    }
                });
            }
            $('.allSideBarIconsText>#showList1').click(function (e){
                $('.allSideBarIconsText>.unActive').each(function() {
                    $(this).show();
                });
                $('.allSideBarIconsText>.active').each(function() {
                    $(this).hide();
                });
                $('.allSideBarIconsText>#showList1').each(function() {
                    if($( this ).attr('class') != e.currentTarget.className){
                        $(this).show();
                    }else{
                        $(this).hide();
                    }
                });
            })
            $('.allSideBarIconsText>#showList2').click(function (e){
                $('.allSideBarIconsText>.unActive').each(function() {
                    $(this).show();
                });
                $('.allSideBarIconsText>.active').each(function() {
                    $(this).hide();
                });
                $('.allSideBarIconsText>#showList2').each(function() {
                    if($( this ).attr('class') != e.currentTarget.className){
                        $(this).show();
                    }else{
                        $(this).hide();
                    }
                });
            })
            $('.allSideBarIconsText>#showList3').click(function (e){
                $('.allSideBarIconsText>.unActive').each(function() {
                    $(this).show();
                });
                $('.allSideBarIconsText>.active').each(function() {
                    $(this).hide();
                });
                $('.allSideBarIconsText>#showList3').each(function() {
                    if($( this ).attr('class') != e.currentTarget.className){
                        $(this).show();
                    }else{
                        $(this).hide();
                    }
                });
            })
            $('.allSideBarIconsText>#showList4').click(function (e){
                $('.allSideBarIconsText>.unActive').each(function() {
                    $(this).show();
                });
                $('.allSideBarIconsText>.active').each(function() {
                    $(this).hide();
                });
                $('.allSideBarIconsText>#showList4').each(function() {
                    if($( this ).attr('class') != e.currentTarget.className){
                        $(this).show();
                    }else{
                        $(this).hide();
                    }
                });
            })
            $('.allSideBarIconsText>#showList5').click(function (e){
                $('.allSideBarIconsText>.unActive').each(function() {
                    $(this).show();
                });
                $('.allSideBarIconsText>.active').each(function() {
                    $(this).hide();
                });
                $('.allSideBarIconsText>#showList5').each(function() {
                    if($( this ).attr('class') != e.currentTarget.className){
                        $(this).show();
                    }else{
                        $(this).hide();
                    }
                });
            })
            $('.allSideBarIconsText>#showList6').click(function (e){
                $('.allSideBarIconsText>.unActive').each(function() {
                    $(this).show();
                });
                $('.allSideBarIconsText>.active').each(function() {
                    $(this).hide();
                });
                $('.allSideBarIconsText>#showList6').each(function() {
                    if($( this ).attr('class') != e.currentTarget.className){
                        $(this).show();
                    }else{
                        $(this).hide();
                    }
                });
            })
            $('.allSideBarIconsText>#showList7').click(function (e){
                $('.allSideBarIconsText>.unActive').each(function() {
                    $(this).show();
                });
                $('.allSideBarIconsText>.active').each(function() {
                    $(this).hide();
                });
                $('.allSideBarIconsText>#showList7').each(function() {
                    if($( this ).attr('class') != e.currentTarget.className){
                        $(this).show();
                    }else{
                        $(this).hide();
                    }
                });
            })
            $('.allSideBarIconsText>#showList9').click(function (e){
                $('.allSideBarIconsText>.unActive').each(function() {
                    $(this).show();
                });
                $('.allSideBarIconsText>.active').each(function() {
                    $(this).hide();
                });
                $('.allSideBarIconsText>#showList9').each(function() {
                    if($( this ).attr('class') != e.currentTarget.className){
                        $(this).show();
                    }else{
                        $(this).hide();
                    }
                });
            })
            $('.allSideBarIconsText>#showList10').click(function (e){
                $('.allSideBarIconsText>.unActive').each(function() {
                    $(this).show();
                });
                $('.allSideBarIconsText>.active').each(function() {
                    $(this).hide();
                });
                $('.allSideBarIconsText>#showList10').each(function() {
                    if($( this ).attr('class') != e.currentTarget.className){
                        $(this).show();
                    }else{
                        $(this).hide();
                    }
                });
            })
            $('.allSideBarIconsText>#showList11').click(function (e){
                $('.allSideBarIconsText>.unActive').each(function() {
                    $(this).show();
                });
                $('.allSideBarIconsText>.active').each(function() {
                    $(this).hide();
                });
                $('.allSideBarIconsText>#showList11').each(function() {
                    if($( this ).attr('class') != e.currentTarget.className){
                        $(this).show();
                    }else{
                        $(this).hide();
                    }
                });
            })
            $('.allSideBarIconsText>#showList12').click(function (e){
                $('.allSideBarIconsText>.unActive').each(function() {
                    $(this).show();
                });
                $('.allSideBarIconsText>.active').each(function() {
                    $(this).hide();
                });
                $('.allSideBarIconsText>#showList12').each(function() {
                    if($( this ).attr('class') != e.currentTarget.className){
                        $(this).show();
                    }else{
                        $(this).hide();
                    }
                });
            })
        })
    </script>
@endsection
