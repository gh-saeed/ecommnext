@extends('admin.master')

@section('tab',7)
@section('content')
    <div class="allCreatePost">
        <div class="allCreatePost">
            <div class="allPostPanelTop">
                <h1>افزودن سفارش</h1>
                <div class="allPostTitle">
                    <a href="/admin">داشبورد</a>
                    <span>/</span>
                    <a href="/admin/pay">همه سفارش ها</a>
                    <span>/</span>
                    <a href="/admin/pay/create">افزودن سفارش</a>
                </div>
            </div>
            <div class="allCreatePostData">
                <div class="allCreatePostSubject">
                    <div class="allCreatePostItem">
                        <label>نوع حامل* :</label>
                        <input type="text" name="carrier" placeholder="نام حامل را وارد کنید">
                        <div id="validation-titleSeo"></div>
                    </div>
                    <div class="allCreatePostItem">
                        <label>مبلغ حامل (تومان)* :</label>
                        <input type="text" name="carrier_price" placeholder="مثال : 1000">
                        <div id="validation-carrier_price"></div>
                    </div>
                    <div class="allCreatePostItem">
                        <label>مبلغ کل (تومان)* :</label>
                        <input type="text" name="price" placeholder="قیمت را وارد کنید">
                        <div id="validation-price"></div>
                    </div>
                    <div class="allCreatePostItem">
                        <label for="state">استان*</label>
                        <input type="text" name="state" placeholder="قیمت را وارد کنید">
                        <div id="validation-state"></div>
                    </div>
                    <div class="allCreatePostItem">
                        <label for="city">شهر*</label>
                        <input id="city" type="text" placeholder="شهر را وارد کنید" name="city">
                        <div id="validation-city"></div>
                    </div>
                    <div class="allCreatePostItem">
                        <label for="address">نشانی پستی*</label>
                        <input id="address" type="text" placeholder="نشانی را وارد کنید" name="address">
                        <div id="validation-address"></div>
                    </div>
                    <div class="allCreatePostItem">
                        <label for="plaque">پلاک*</label>
                        <input id="plaque" type="text" placeholder="پلاک را وارد کنید" name="plaque">
                        <div id="validation-plaque"></div>
                    </div>
                    <div class="allCreatePostItem">
                        <label for="unit">واحد</label>
                        <input id="unit" type="text" placeholder="واحد را وارد کنید" name="unit">
                    </div>
                    <div class="allCreatePostItem">
                        <label for="post">کد پستی*</label>
                        <input id="post" type="text" placeholder="کد پستی را وارد کنید" name="post">
                        <div id="validation-post"></div>
                    </div>
                    <div class="allCreatePostItem">
                        <label for="name">نام گیرنده*</label>
                        <input id="name" type="text" placeholder="نام را وارد کنید" name="name">
                        <div id="validation-name"></div>
                    </div>
                    <div class="allCreatePostItem">
                        <label for="number">شماره تماس*</label>
                        <input id="number" type="text" placeholder="شماره تماس را وارد کنید" name="number">
                        <div id="validation-number"></div>
                    </div>
                    <div class="note">
                        <label>لینک پرداخت مستقیم توسط کاربر :</label>
                        <p>{{url('/fast?order=')}}<span class="link1"></span></p>
                    </div>
                </div>
                <div class="allCreatePostDetails">
                    <div class="allCreatePostDetail">
                        <div class="allCreatePostDetailItemsTitle">
                            جزییات
                        </div>
                        <div class="allCreatePostDetailItems">
                            <div class="allCreatePostDetailItem">
                                <label>درگاه* :</label>
                                <select name="gate" id="gate">
                                    <option value="0" selected>زرینپال</option>
                                    <option value="1">زیبال</option>
                                    <option value="2">نکست پی</option>
                                    <option value="3">نکست پی</option>
                                    <option value="4">آیدی پی</option>
                                    <option value="5">به پرداخت ملت</option>
                                    <option value="6">سداد ملی</option>
                                    <option value="7">آسان پرداخت</option>
                                    <option value="8">پاسارگاد</option>
                                </select>
                                <div id="validation-gate"></div>
                            </div>
                            <div class="allCreatePostDetailItem">
                                <label>مبلغ بیعانه (تومان) :</label>
                                <input type="text" name="deposit" placeholder="قیمت را وارد کنید">
                                <div id="validation-deposit"></div>
                            </div>
                            <div class="allCreatePostDetailItem">
                                <label>درصد مالیات :</label>
                                <input type="text" name="tax" placeholder="مثال : 10">
                                <div id="validation-tax"></div>
                            </div>
                            <div class="allCreatePostDetailItem">
                                <label>درصد تخفیف :</label>
                                <input type="text" name="discount_off" placeholder="مثال : 10">
                                <div id="validation-discount_off"></div>
                            </div>
                            <div class="allCreatePostDetailItem">
                                <label>کد رهگیری :</label>
                                <input type="text" name="track" placeholder="مثال : 22222210">
                                <div id="validation-track"></div>
                            </div>
                            <div class="allCreatePostDetailItem">
                                <label>شماره سفارش :</label>
                                <input type="text" name="property" placeholder="مثال : 22222210" value="{{\App\Models\Pay::buildCode()}}">
                                <div id="validation-track"></div>
                            </div>
                            <div class="allCreatePostDetailItem">
                                <label for="s1d0" class="allCreatePostDetailItemData">
                                    پین شدن سفارش
                                    <input id="s1d0" type="checkbox" name="pin" class="switch">
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="allCreatePostDetail">
                        <div class="allCreatePostDetailItemsTitle">
                            تاکسونامی
                        </div>
                        <div class="allCreatePostDetailItems">
                            <div class="allCreatePostDetailItem">
                                <label>وضعیت پرداخت* :</label>
                                <select name="status" id="status">
                                    <option value="100" selected>پرداخت شده</option>
                                    <option value="50">پرداخت بیعانه</option>
                                    <option value="20">تایید و آماده پرداخت</option>
                                    <option value="10">در حال بررسی</option>
                                    <option value="0">پرداخت نشده</option>
                                    <option value="1">لغو شده</option>
                                    <option value="2">مرجوعی</option>
                                </select>
                                <div id="validation-status"></div>
                            </div>
                            <div class="allCreatePostDetailItem">
                                <label>روش پرداخت* :</label>
                                <select name="method" id="method">
                                    <option value="0" selected>پرداخت از درگاه</option>
                                    <option value="1">پرداخت از کیف پول</option>
                                    <option value="2">پرداخت در محل</option>
                                    <option value="3">پرداخت اقساطی</option>
                                    <option value="4">پرداخت فوری</option>
                                    <option value="5">کارت به کارت</option>
                                </select>
                                <div id="validation-method"></div>
                            </div>
                            <div class="allCreatePostDetailItem">
                                <label>مرحله تحویل* :</label>
                                <select name="deliver" id="deliver">
                                    <option value="0" selected>دریافت سفارش</option>
                                    <option value="1">در انتظار بررسی</option>
                                    <option value="2">بسته بندی شده</option>
                                    <option value="3">تحویل پیک</option>
                                    <option value="4">تکمیل شده</option>
                                </select>
                                <div id="validation-deliver"></div>
                            </div>
                            <div class="allCreatePostDetailItem">
                                <label>مشتری :</label>
                                <select name="user_id">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="abilityPost payAbility">
                <div class="abilityTitle">
                    <label>آیتم ها</label>
                    <i id="addColor">
                        <svg class="icon">
                            <use xlink:href="#add"></use>
                        </svg>
                    </i>
                </div>
                <table class="abilityTable" id="pays">
                    <tr>
                        <th>محصول</th>
                        <th>رنگ</th>
                        <th>سایز</th>
                        <th>تعداد</th>
                        <th>گارانتی</th>
                        <th>مبلغ کل</th>
                        <th>حذف</th>
                    </tr>
                </table>
            </div>
            <button class="button" style="margin-top: 1rem;" name="createPost" type="submit">ارسال اطلاعات</button>
        </div>
    </div>
@endsection

@section('scripts3')
    <script>
        $(document).ready(function(){
            var products = {!! json_encode($products, JSON_HEX_TAG) !!};
            var selects = '';
            $.each(products,function (){
                selects += '<option value="'+this.id+'">'+this.title+'</option>'
            })
            $(".link1").text($("input[name='property']").val());
            $("input[name='property']").keyup(function(event){
                $(".link1").text($(this).val());
            })
            $("button[name='createPost']").click(function(event){
                $(this).text('منتظر بمانید');
                var carrier = $(".allCreatePostData input[name='carrier']").val();
                var carrier_price = $(".allCreatePostData input[name='carrier_price']").val();
                var price = $(".allCreatePostData input[name='price']").val();
                var state = $(".allCreatePostData input[name='state']").val();
                var city = $(".allCreatePostData input[name='city']").val();
                var address = $(".allCreatePostData input[name='address']").val();
                var plaque = $(".allCreatePostData input[name='plaque']").val();
                var unit = $(".allCreatePostData input[name='unit']").val();
                var post = $(".allCreatePostData input[name='post']").val();
                var name = $(".allCreatePostData input[name='name']").val();
                var number = $(".allCreatePostData input[name='number']").val();
                var gate = $(".allCreatePostData input[name='gate']").val();
                var deposit = $(".allCreatePostData input[name='deposit']").val();
                var discount_off = $(".allCreatePostData input[name='discount_off']").val();
                var track = $(".allCreatePostData input[name='track']").val();
                var property = $(".allCreatePostData input[name='property']").val();
                var pin = $(".allCreatePostData input[name='pin']").is(":checked");
                var tax = $(".allCreatePostData input[name='tax']").val();
                var status = $(".allCreatePostData select[name='status']").val();
                var methods = $(".allCreatePostData select[name='method']").val();
                var deliver = $(".allCreatePostData select[name='deliver']").val();
                var user_id = $(".allCreatePostData select[name='user_id']").val();
                var metas = [];
                $("#pays tr").each(function(){
                    if($(this).find("input").length >= 1){
                        var ability = {};
                        $(this).find("input").each(function(){
                            ability[$(this).attr('name')] = this.value;
                        })
                        $(this).find("select").each(function(){
                            ability[$(this).attr('name')] = this.value;
                        })
                        metas.push(ability);
                    }
                });

                var form = {
                    "_token": "{{ csrf_token() }}",
                    carrier:carrier,
                    carrier_price:carrier_price,
                    price:price,
                    state:state,
                    city:city,
                    address:address,
                    plaque:plaque,
                    unit:unit,
                    post:post,
                    name:name,
                    tax:tax,
                    number:number,
                    gate:gate,
                    deposit:deposit,
                    discount_off:discount_off,
                    track:track,
                    property:property,
                    pin:pin,
                    status:status,
                    methods:methods,
                    deliver:deliver,
                    user_id:user_id,
                    metas:JSON.stringify(metas),
                };
                $.ajax({
                    url: "/admin/pay/create",
                    type: "post",
                    data: form,
                    success: function (data) {
                        $.toast({
                            text: "سفارش اضافه شد", // Text that is to be shown in the toast
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
                        window.location.href="/admin/pay";
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
                        $("button[name='createPost']").text('ثبت اطلاعات');
                    }
                });
            });
            $('#addColor').click(function (){
                $('#pays').append(
                    $('<tr><td><select name="product">'+selects+'</select></td><td><input type="text" name="color" placeholder="رنگ را وارد کنید"></td><td><input type="text" name="size" placeholder="سایز را وارد کنید"></td><td><input type="text" name="count" placeholder="تعداد را وارد کنید"></td><td><input type="text" name="guarantee" placeholder="گارانتی را وارد کنید"></td><td><input type="text" name="price" placeholder="مبلغ را وارد کنید"></td><td><i id="deleteMeta"><svg class="icon"><use xlink:href="#trash"></use></svg></i></td></tr>')
                        .on('click' , '#deleteMeta',function(ss){
                            ss.currentTarget.parentElement.parentElement.remove();
                        })
                );
            })
        })
    </script>
@endsection
