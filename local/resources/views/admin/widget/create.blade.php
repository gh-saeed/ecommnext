@extends('admin.master')

@section('tab' , 3)
@section('content')
    <div class="allCreateWidget">
        <div class="topProductIndex">
            <div class="right">
                <a href="/admin">داشبورد</a>
                <span>/</span>
                <a href="/admin/widget">ویجت ها</a>
                <span>/</span>
                <a href="/admin/widget/create">افزودن ویجت</a>
            </div>
        </div>
        <div class="createWidget">
            <div class="createItem">
                <label for="name">نوع ویجت</label>
                <select name="name">
                    <option value="تبلیغ ساده">تبلیغ ساده</option>
                    <option value="دسته بندی">دسته بندی</option>
                    <option value="معرفی سایت">معرفی سایت</option>
                    <option value="بازارگردی">بازارگردی</option>
                    <option value="استوری2">استوری2</option>
                    <option value="بلاگ2">بلاگ2</option>
                    <option value="تبلیغ بزرگ">تبلیغ بزرگ</option>
                    <option value="دسته بندی2">دسته بندی2</option>
                    <option value="لحظه ای">لحظه ای</option>
                    <option value="محصولات اسلایدری">محصولات اسلایدری</option>
                    <option value="تک غرفه">تک غرفه</option>
                    <option value="لیست غرفه" selected>لیست غرفه</option>
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
                <div class="createItem change1 change7">
                    <label>لینک مشاهده بیشتر :</label>
                    <input type="text" placeholder="لینک را وارد کنید" name="slug">
                </div>
                <div class="createItem change1 change8">
                    <label>آدرس تصویر :</label>
                    <input type="text" placeholder="آدرس را وارد کنید" name="background">
                </div>
                <div class="createItem change1 change9">
                    <label>تعداد نمایش :</label>
                    <input type="text" placeholder="تعداد را وارد کنید" name="count">
                </div>
                <div class="createItem change1 change10">
                    <label for="cats">دسته بندی :</label>
                    <select class="cats-multiple" name="cats" id="cats" multiple="multiple">
                        @foreach ($cats as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="createItem change1 change11">
                    <label for="user_id">غرفه دار :</label>
                    <select class="user-multiple" name="user_id" id="user_id" multiple="multiple">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
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
                    <label for="responsive">پلتفرم :</label>
                    <select name="responsive" id="responsive">
                        <option value="0" selected>دسکتاپ</option>
                        <option value="1">موبایل</option>
                    </select>
                </div>
                <div class="createItem">
                    <label>وضعیت نمایش :</label>
                    <select name="status">
                        <option value="0">پیشنویس</option>
                        <option value="1" selected>انتشار</option>
                    </select>
                </div>
            </div>
            <div class="abilityPost change1 change15">
                <table class="abilityTable" id="ads1">
                    <tr>
                        <th>تصویر تبلیغ</th>
                        <th>آدرس تبلیغ</th>
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
            <div class="abilityPost change1 change18">
                <table class="abilityTable" id="ads4">
                    <tr>
                        <th>عنوان</th>
                        <th>توضیح</th>
                        <th>
                            <i id="addAd4">
                                <svg class="icon">
                                    <use xlink:href="#add"></use>
                                </svg>
                            </i>
                        </th>
                    </tr>
                </table>
            </div>
            <button class="button" name="createPost" type="submit">ثبت ویجت</button>
        </div>
    </div>
@endsection

@section('scripts3')
    <script>
        $(document).ready(function(){
            $('.cats-multiple').select2({
                placeholder: 'دسته بندی را انتخاب کنید ...',
                "language": {
                    "noResults": function(){
                        return "موردی پیدا نشد";
                    }
                },
            });
            $('.user-multiple').select2({
                placeholder: 'غرفه را انتخاب کنید ...',
                "language": {
                    "noResults": function(){
                        return "موردی پیدا نشد";
                    }
                },
            });
            $(".change1").hide();
            $('#addAd1').click(function (){
                $('#ads1').append(
                    $('<tr><td><input type="text" name="image" placeholder="تصویر را وارد کنید"></td><td><input type="text" name="address" placeholder="آدرس را وارد کنید"></td><td><i id="deleteAbility"><svg class="icon"><use xlink:href="#trash"></use></svg></i></td></tr>')
                        .on('click' , '#deleteAbility',function(ss){
                            ss.currentTarget.parentElement.parentElement.remove();
                        })
                );
            })
            $('#addAd4').click(function (){
                $('#ads4').append(
                    $('<tr><td><input type="text" name="title" placeholder="عنوان را وارد کنید"></td><td><input type="text" name="body" placeholder="توضیح را وارد کنید"></td><td><i id="deleteAbility"><svg class="icon"><use xlink:href="#trash"></use></svg></i></td></tr>')
                        .on('click' , '#deleteAbility',function(ss){
                            ss.currentTarget.parentElement.parentElement.remove();
                        })
                );
            })
            getSelect($("select[name='name']").val());
            $("select[name='name']").change(function (){
                $('.change1').hide();
                getSelect($(this).val());
            })
            $("button[name='createPost']").click(function(event){
                var name = $("select[name='name']").val();
                var title = $("input[name='title']").val();
                var more = $("input[name='more']").val();
                var number = $("input[name='number']").val();
                var description = $("input[name='description']").val();
                var background = $("input[name='background']").val();
                var slug = $("input[name='slug']").val();
                var responsive = $("select[name='responsive']").val();
                var count = $("input[name='count']").val();
                var sort = $("select[name='sort']").val();
                var type = $("select[name='type']").val();
                var status = $("select[name='status']").val();

                var cats = [];
                $("select[name='cats'] :selected").each(function(){
                    cats.push($(this).val());
                });
                var users = [];
                $("select[name='user_id'] :selected").each(function(){
                    users.push($(this).val());
                });
                var ads1 = [];
                $("#ads1 tr").each(function(){
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
                var ads4 = [];
                $("#ads4 tr").each(function(){
                    if($(this).find("input").length >= 1){
                        var ad4 = {
                            title:"",
                            body:"",
                        };
                        $(this).find("input").each(function(){
                            if (this.name == 'title') {
                                ad4.title = this.value;
                            }
                            if (this.name == 'body') {
                                ad4.body = this.value;
                            }
                        })
                        ads4.push(ad4);
                    }
                });

                var form = {
                    "_token": "{{ csrf_token() }}",
                    name:name,
                    title:title,
                    more:more,
                    description:description,
                    background:background,
                    slug:slug,
                    responsive:responsive,
                    count:count,
                    sort:sort,
                    type:type,
                    status:status,
                    number:number,
                    cats:JSON.stringify(cats),
                    users:JSON.stringify(users),
                    ads1:JSON.stringify(ads1),
                    ads4:JSON.stringify(ads4),
                };

                $.ajax({
                    url: "/admin/widget/create",
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
                        window.location.href="/admin/widget";
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
            function getSelect(data){
                if(data == 'معرفی سایت'){
                    $('.change11').show();
                    $('.change8').show();
                    $('.change2').show();
                    $('.change5').show();
                    $('.change3').show();
                    $('.change7').show();
                    $('.change9').show();
                }
                if(data == 'تبلیغ ساده' || data == 'تبلیغ بزرگ'){
                    $('.change15').show();
                }
                if(data == 'دسته بندی' || data == 'دسته بندی2'){
                    $('.change10').show();
                }
                if(data == 'تک غرفه'){
                    $('.change11').show();
                }
                if(data == 'استوری' || data == 'استوری2'){
                    $('.change11').show();
                    $('.change2').show();
                    $('.change9').show();
                }
                if(data == 'لیست غرفه' || data == 'محصولات اسلایدری' || data == 'لحظه ای'){
                    $('.change11').show();
                    $('.change2').show();
                    $('.change3').show();
                }
                if(data == 'بازارگردی'){
                    $('.change2').show();
                    $('.change3').show();
                    $('.change7').show();
                }
                if(data == 'بلاگ' || data == 'بلاگ2'){
                    $('.change2').show();
                    $('.change3').show();
                    $('.change10').show();
                    $('.change9').show();
                }
            }
        })
    </script>
@endsection

@section('jsScript')
    <script src="/js/jquery.toast.min.js"></script>
    <script src="/js/select2.min.js"></script>
    <link rel="stylesheet" href="/css/select2.min.css"/>
    <link rel="stylesheet" href="/css/jquery.toast.min.css"/>
@endsection
