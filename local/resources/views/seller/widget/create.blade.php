@extends('seller.master')

@section('tab' , 0)
@section('title' , 'داشبورد')
@section('content')
    <div class="widgetCreate">
        <div class="options">
            <div class="option openLearn">آموزش ساخت غرفه</div>
            <div class="option openDemo">مشاهده و استفاده دمو آماده</div>
            <a href="/vendor/{{auth()->user()->slug}}" target="_blank" class="option">مشاهده پیشنمایش غرفه شما</a>
        </div>
        <div class="title">
            <p>صفحه غرفه شما</p>
        </div>
        <div class="page1">
            <div class="items">
                @foreach($widgets as $item)
                    <div class="item createWidget">
                        <div class="deleteAll">
                            <i>
                                <svg class="icon">
                                    <use xlink:href="#trash"></use>
                                </svg>
                            </i>
                        </div>
                        <div class="createItem">
                            <label for="name">نوع بخش</label>
                            <select name="name">
                                <option value="تبلیغ ساده" {{$item->name == 'تبلیغ ساده' ? 'selected' : ''}}>بنر ساده</option>
                                <option value="دسته بندی" {{$item->name == 'دسته بندی' ? 'selected' : ''}}>دسته بندی</option>
                                <option value="معرفی سایت" {{$item->name == 'معرفی سایت' ? 'selected' : ''}}>معرفی غرفه</option>
                                <option value="بازارگردی" {{$item->name == 'بازارگردی' ? 'selected' : ''}}>بازارگردی</option>
                                <option value="استوری2" {{$item->name == 'استوری2' ? 'selected' : ''}}>استوری2</option>
                                <option value="بلاگ2" {{$item->name == 'بلاگ2' ? 'selected' : ''}}>بلاگ2</option>
                                <option value="تک غرفه" {{$item->name == 'تک غرفه' ? 'selected' : ''}}>تک غرفه</option>
                                <option value="لیست غرفه" {{$item->name == 'لیست غرفه' ? 'selected' : ''}}>لیست غرفه</option>
                                <option value="تبلیغ بزرگ" {{$item->name == 'تبلیغ بزرگ' ? 'selected' : ''}}>بنر بزرگ</option>
                                <option value="دسته بندی2" {{$item->name == 'دسته بندی2' ? 'selected' : ''}}>دسته بندی2</option>
                                <option value="لحظه ای" {{$item->name == 'لحظه ای' ? 'selected' : ''}}>لحظه ای</option>
                                <option value="محصولات اسلایدری" {{$item->name == 'محصولات اسلایدری' ? 'selected' : ''}}>محصولات اسلایدری</option>
                                <option value="بلاگ" {{$item->name == 'بلاگ' ? 'selected' : ''}}>بلاگ</option>
                                <option value="استوری" {{$item->name == 'استوری' ? 'selected' : ''}}>استوری</option>
                            </select>
                        </div>
                        <div class="createItems">
                            <div class="createItem change1 change2">
                                <label>نمایش عنوان :</label>
                                <input type="text" placeholder="عنوان را وارد کنید" name="title" value="{{$item->title}}">
                            </div>
                            <div class="createItem change1 change3">
                                <label>عنوان مشاهده بیشتر :</label>
                                <input type="text" placeholder="عنوان را وارد کنید" name="more" value="{{$item->more}}">
                            </div>
                            <div class="createItem change1 change5">
                                <label>توضیحات :</label>
                                <input type="text" placeholder="توضیحات را وارد کنید" name="description" value="{{$item->description}}">
                            </div>
                            <div class="createItem change1 change8">
                                <label>لینک تصویر :</label>
                                <input type="text" placeholder="مثال : https://example.com/pic.jpg" name="background" value="{{$item->background}}">
                            </div>
                            <div class="createItem change1 change10">
                                <label for="cats">دسته بندی :</label>
                                <select class="cats-multiple" name="cats" id="cats" multiple="multiple">
                                    @foreach($cats as $val)
                                        <option value="{{$val->id}}" {{($item->cats ? in_array($val->id, json_decode($item->cats)) ? 'selected' : '' : '')}}>{{$val->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="createItem change1 change12">
                                <label for="sort">نمایش براساس :</label>
                                <select name="sort" id="sort">
                                    <option {{$item->sort == 0 ? 'selected' : ''}} value="0">جدید ترین</option>
                                    <option {{$item->sort == 1 ? 'selected' : ''}} value="1">محبوب ترین</option>
                                    <option {{$item->sort == 2 ? 'selected' : ''}} value="2">پربازدید ترین</option>
                                    <option {{$item->sort == 3 ? 'selected' : ''}} value="3">کمترین قیمت</option>
                                    <option {{$item->sort == 4 ? 'selected' : ''}} value="4">بیشترین قیمت</option>
                                </select>
                            </div>
                            <div class="createItem">
                                <label>وضعیت نمایش :</label>
                                <select name="status">
                                    <option value="0" {{$item->sort == 0 ? 'selected' : ''}}>غیرفعال</option>
                                    <option value="1" {{$item->sort == 1 ? 'selected' : ''}} selected>فعال</option>
                                </select>
                            </div>
                        </div>
                        <div class="abilityPost change1 change15">
                            <table class="abilityTable" id="ads1">
                                <tr>
                                    <th>تصویر بنر</th>
                                    <th>آدرس ریدایرکت بنر</th>
                                    <th>
                                        <i id="addAd1">
                                            <svg class="icon">
                                                <use xlink:href="#add"></use>
                                            </svg>
                                        </i>
                                    </th>
                                </tr>
                                @if($item->ads1 && $item->ads1 != '[]')
                                    @foreach(json_decode($item->ads1) as $val)
                                        <tr>
                                            <td><input type="text" name="image" value="{{$val->image}}" placeholder="مثال : https://example.ir/pic.jpg"></td>
                                            <td><input type="text" name="address" value="{{$val->address}}" placeholder="مثال : https://example.ir/"></td>
                                            <td><i id="deleteAbility"><svg class="icon"><use xlink:href="#trash"></use></svg></i></td>
                                        </tr>
                                    @endforeach
                                @endif
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="item">
                <div class="create">
                    <i>
                        <svg class="icon">
                            <use xlink:href="#add"></use>
                        </svg>
                    </i>
                    <p>افزودن بخش جدید</p>
                </div>
            </div>
        </div>
        <button class="submit">جهت ثبت نهایی کلیک کنید</button>
        <div class="allThemes">
            <div class="details1">
                <div class="des1">از بین غرفه های آماده میتوانید یکی را انتخاب کنید.</div>
                <div class="themes">
                    <form action="/seller/widget/demo?demo=1" method="POST" class="theme1">
                        @csrf
                        <div class="pic">
                            <img src="/img/theme1.webp" alt="theme1">
                        </div>
                        <button class="body">انتخاب</button>
                    </form>
                    <form action="/seller/widget/demo?demo=2" method="POST" class="theme1">
                        @csrf
                        <div class="pic">
                            <img src="/img/theme2.webp" alt="theme1">
                        </div>
                        <button class="body">انتخاب</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="allLearn">
            <div class="details1">
                <div class="des1">توضیحات آمورش</div>
                <div class="detail">1:ابتدا از دکمه <span>"افزودن بخش جدید"</span> یک بخش ایجاد کنید</div>
                <div class="detail">2:سپس از دکمه <span>"انتخاب بهش"</span> بخش مد نظر خودتان را انتخاب کنید</div>
                <div class="detail">3:بعد از انتخاب بخش دلخواه از بین بنر ها و محصولات و... میتوانید موارد دلخواه اون بخش را ویرایش کنید</div>
                <div class="detail">3:بعد از شخصی سازی بخش انتخابی میتوانید مجدد بخش جدید درست کنید یا با زدن دکمه <span>"ثبت نهایی"</span> اقدام به ساخت صفحه خود کنید</div>
                <div class="detail note">** میتوانید با کشیدن هر بخش به بالا و پایین بخش هارا جابه جا کنید **</div>
                <div class="detail note">** میتوانید از بخش <span>"مشاهده و استفاده دمو آماده"</span> اقدام به استفاده از دمو های آماده کنید **</div>
            </div>
        </div>
    </div>
@endsection

@section('scripts3')
    <script>
        $(document).mouseup(function(e)
        {
            var container2 = $(".allLearn");
            if (container2.is(e.target) && container2.has(e.target).length == 0)
            {
                $('.allLearn').hide();
            }
            var container = $(".allThemes");
            if (container.is(e.target) && container.has(e.target).length == 0)
            {
                $('.allThemes').hide();
            }
        });
        $(document).ready(function(){
            var cats = {!! json_encode($cats, JSON_HEX_TAG) !!};
            var cats1 = ''
            $.each(cats,function (){
                cats1 += `<option value="${this.id}">${this.name}</option>`
            });
            $(".openDemo").click(function (){
                $(".allThemes").show();
            })
            $(".openLearn").click(function (){
                $(".allLearn").show();
            })
            if($(".createWidget").length){
                document.querySelectorAll("select[name='cats']").forEach((selectElement) => {
                    new SlimSelect({
                        select: selectElement,
                        placeholder: "دسته‌بندی را انتخاب کنید ...",
                    });
                });
            }
            $.each($("select[name='name']"),function (){
                getSelect($(this),$(this).val());
            })
            $(".widgetCreate .create").click(function (){
                const newWidget = $( `<div class="item createWidget">
                    <div class="deleteAll">
                    <i>
                        <svg class="icon">
                            <use xlink:href="#trash"></use>
                        </svg>
                    </i></div>
            <div class="createItem">
                <label for="name">نوع بخش</label>
                <select name="name">
                    <option value="">انتخاب بخش</option>
                    <option value="تبلیغ ساده">بنر ساده</option>
                    <option value="دسته بندی">دسته بندی</option>
                    <option value="معرفی سایت">معرفی غرفه</option>
                    <option value="بازارگردی">بازارگردی</option>
                    <option value="استوری2">استوری2</option>
                    <option value="بلاگ2">بلاگ2</option>
                    <option value="تک غرفه">تک غرفه</option>
                    <option value="لیست غرفه">لیست غرفه</option>
                    <option value="تبلیغ بزرگ">بنر بزرگ</option>
                    <option value="دسته بندی2">دسته بندی2</option>
                    <option value="لحظه ای">لحظه ای</option>
                    <option value="محصولات اسلایدری">محصولات اسلایدری</option>
                    <option value="بلاگ">بلاگ</option>
                    <option value="استوری">استوری</option>
                </select>
            </div>
            <div class="createItems">
                <div class="createItem change1 change2">
                    <label>نمایش عنوان :</label>
                    <input type="text" placeholder="عنوان را وارد کنید" name="title">
                </div>
                <div class="createItem change1 change3">
                    <label>عنوان مشاهده بیشتر :</label>
                    <input type="text" placeholder="عنوان را وارد کنید" name="more">
                </div>
                <div class="createItem change1 change5">
                    <label>توضیحات :</label>
                    <input type="text" placeholder="توضیحات را وارد کنید" name="description">
                </div>
                <div class="createItem change1 change8">
                    <label>لینک تصویر :</label>
                    <input type="text" placeholder="مثال : https://example.com/pic.jpg" name="background">
                </div>
                <div class="createItem change1 change10">
                    <label for="cats">دسته بندی :</label>
                    <select class="cats-multiple" name="cats" id="cats" multiple="multiple">${cats1}</select>
                </div>
                <div class="createItem change1 change12">
                    <label for="sort">نمایش براساس :</label>
                    <select name="sort" id="sort">
                        <option value="0">جدید ترین</option>
                        <option value="1">محبوب ترین</option>
                        <option value="2">پربازدید ترین</option>
                        <option value="3">کمترین قیمت</option>
                        <option value="4">بیشترین قیمت</option>
                    </select>
                </div>
                <div class="createItem">
                    <label>وضعیت نمایش :</label>
                    <select name="status">
                        <option value="0">غیرفعال</option>
                        <option value="1" selected>فعال</option>
                    </select>
                </div>
            </div>
            <div class="abilityPost change1 change15">
                <table class="abilityTable" id="ads1">
                    <tr>
                        <th>تصویر بنر</th>
                        <th>آدرس ریدایرکت بنر</th>
                        <th>
                            <i id="addAd1">
                                <svg class="icon">
                                    <use xlink:href="#add"></use>
                                </svg>
                            </i>
                        </th>
                    </tr>
                </table>
            </div>
        </div>`);
                $(".items").append(newWidget);
                new SlimSelect({
                    select: ".createWidget:last-child select[name='cats']",
                    placeholder: "دسته‌بندی را انتخاب کنید ...",
                });
            })
            $(".submit").click(function(event){
                $(this).text('صبر کنید...');
                var widgets = [];
                $.each($(".items .item"),function (){
                    var name = $(this).find("select[name='name']").val();
                    var title = $(this).find("input[name='title']").val();
                    var more = $(this).find("input[name='more']").val();
                    var description = $(this).find("input[name='description']").val();
                    var background = $(this).find("input[name='background']").val();
                    var sort = $(this).find("select[name='sort']").val();
                    var type = $(this).find("select[name='type']").val();
                    var status = $(this).find("select[name='status']").val();

                    var cats = [];
                    $(this).find("select[name='cats'] :selected").each(function(){
                        cats.push($(this).val());
                    });
                    var ads1 = [];
                    $(this).find("#ads1 tr").each(function(){
                        if($(this).find("input").length >= 1){
                            var ad1 = {
                                image:"",
                                address:"",
                            };
                            $(this).find("input").each(function(){
                                if (this.name == 'image') {
                                    ad1.image = this.value;
                                }
                                if (this.name == 'address') {
                                    ad1.address = this.value;
                                }
                            })
                            ads1.push(ad1);
                        }
                    });

                    var widget = {
                        name:name,
                        title:title,
                        more:more,
                        description:description,
                        background:background,
                        sort:sort,
                        type:type,
                        status:status,
                        cats:JSON.stringify(cats),
                        ads1:JSON.stringify(ads1),
                    };
                    widgets.push(widget);
                });


                var form = {
                    "_token": "{{ csrf_token() }}",
                    widgets: JSON.stringify(widgets),
                };

                $.ajax({
                    url: "/seller/widget/create",
                    type: "post",
                    data: form,
                    success: function (data) {
                        $.toast({
                            text: "ویجت اضافه شد", // Text that is to be shown in the toast
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
            });
            $(document).on('click','.deleteAll',function (){
                $(this).parent().remove();
            })
            $(document).on("click","#deleteAbility",function (ss){
                ss.currentTarget.parentElement.parentElement.remove();
            })
            $(document).on('click','#addAd1',function (){
                $(this).parent().parent().parent().parent().parent().find('#ads1').append(
                    $('<tr><td><input type="text" name="image" placeholder="مثال : https://example.ir/pic.jpg"></td><td><input type="text" name="address" placeholder="مثال : https://example.ir/"></td><td><i id="deleteAbility"><svg class="icon"><use xlink:href="#trash"></use></svg></i></td></tr>')
                );
            })
            $(document).on('change',"select[name='name']",function (){
                $(this).parent().parent().find('.change1').hide();
                getSelect($(this),$(this).val());
            })
            $( ".items" ).sortable({});
            function getSelect(element,data){
                if(data == 'معرفی سایت'){
                    element.parent().parent().find('.change11').show();
                    element.parent().parent().find('.change8').show();
                    element.parent().parent().find('.change2').show();
                    element.parent().parent().find('.change5').show();
                    element.parent().parent().find('.change3').show();
                    element.parent().parent().find('.change7').show();
                    element.parent().parent().find('.change9').show();
                }
                if(data == 'تبلیغ ساده' || data == 'تبلیغ بزرگ'){
                    element.parent().parent().find('.change15').show();
                }
                if(data == 'دسته بندی' || data == 'دسته بندی2'){
                    element.parent().parent().find('.change10').show();
                }
                if(data == 'استوری' || data == 'استوری2'){
                    element.parent().parent().find('.change11').show();
                    element.parent().parent().find('.change2').show();
                    element.parent().parent().find('.change9').show();
                }
                if(data == 'تک غرفه'){
                    element.parent().parent().find('.change11').show();
                }
                if(data == 'لیست غرفه' || data == 'محصولات اسلایدری' || data == 'لحظه ای'){
                    element.parent().parent().find('.change11').show();
                    element.parent().parent().find('.change12').show();
                    element.parent().parent().find('.change10').show();
                    element.parent().parent().find('.change2').show();
                    element.parent().parent().find('.change3').show();
                }
                if(data == 'بازارگردی'){
                    element.parent().parent().find('.change2').show();
                    element.parent().parent().find('.change3').show();
                    element.parent().parent().find('.change7').show();
                }
            }
        })
    </script>
@endsection

@section('jsScript')
    <script src="/js/jquery.toast.min.js"></script>
    <script src="/js/select3.min.js"></script>
    <link rel="stylesheet" href="/css/select3.min.css"/>
    <script src="/js/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="/css/jquery.toast.min.css"/>
@endsection
