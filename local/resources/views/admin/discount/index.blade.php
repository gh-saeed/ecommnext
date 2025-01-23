@extends('admin.master')

@section('tab',6)
@section('content')
    <div class="allBrandPanel">
        <div class="topBrandPanel">
            <div class="right">
                <a href="/admin">داشبورد</a>
                <span>/</span>
                <a href="/admin/discount">کد تخفیف</a>
            </div>
            <div class="allTopTableItem">
                <div class="filterItems">
                    <div class="filterTitle">
                        <i>
                            <svg class="icon">
                                <use xlink:href="#filter"></use>
                            </svg>
                        </i>
                        فیلتر اطلاعات
                    </div>
                    <form method="GET" action="/admin/discount" class="filterContent">
                        <div class="filterContentItem">
                            <label>فیلتر عنوان و آیدی</label>
                            <input type="text" name="titleSearch" placeholder="عنوان یا آیدی را وارد کنید" value="{{$title}}">
                        </div>
                        <button type="submit">اعمال</button>
                    </form>
                </div>
            </div>
        </div>
        @if (\Session::has('message'))
            <div class="alert">
                {!! \Session::get('message') !!}
            </div>
        @endif
        <div class="allTables">
            <div>
                <table>
                    <tr>
                        <th>آیدی</th>
                        <th>عنوان</th>
                        <th>عملیات</th>
                    </tr>
                    @foreach($discounts as $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>{{$item->title}}</td>
                            <td>
                                <div class="buttons">
                                    <button id="{{$item->id}}" class="editButton">ویرایش</button>
                                    <button id="{{$item->id}}" class="deleteButton">حذف</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
                {{ $discounts->links('admin.paginate') }}
            </div>
            <div>
                <form action="/admin/discount" class="createFilled" method="post">
                    @csrf
                    <div class="filledItem">
                        <label>عنوان*</label>
                        <input type="text" name="title" placeholder="عنوان را وارد کنید">
                        @error('title')
                        <div class="alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="filledItem">
                        <label>کد*</label>
                        <input type="text" name="code" placeholder="کد را وارد کنید">
                        @error('code')
                        <div class="alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="filledItem">
                        <label>درصد تخفیف* (1,99)</label>
                        <input type="text" name="percent" placeholder="درصد تخفیف را وارد کنید">
                        @error('percent')
                        <div class="alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="filledItem">
                        <label>تعداد استفاده*</label>
                        <input type="text" name="count" placeholder="تعداد را وارد کنید">
                        @error('count')
                        <div class="alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="filledItem">
                        <label>تاریخ انقضا*</label>
                        <input type="text" class="example1" placeholder="تاریخ را وارد کنید" name="day"/>
                    </div>
                    <div class="filledItem">
                        <label>محصول</label>
                        <select name="product_id">
                            @foreach ($products as $product)
                                <option value="">همه محصولات</option>
                                <option value="{{ $product->id }}">{{ $product->title }}</option>
                            @endforeach
                        </select>
                        @error('count')
                        <div class="alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="filledItem">
                        <label>وضعیت*</label>
                        <select name="status" id="status">
                            <option value="0">پیشنویس</option>
                            <option value="1" selected>منتشر شده</option>
                        </select>
                        @error('status')
                        <div class="alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="buttonForm">
                        <button type="submit">ثبت اطلاعات</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="popUp" style="display:none;">
            <div class="popUpItem">
                <div class="title">آیا از حذف کد تخفیف مطمئن هستید؟</div>
                <p>با حذف کد تخفیف اطلاعات کد تخفیف به طور کامل حذف میشوند</p>
                <div class="buttonsPop">
                    <form method="POST" action="" id="deletePost">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit">حذف شود</button>
                    </form>
                    <button id="cancelDelete">منصرف شدم</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts3')
    <script>
        $(document).ready(function(){
            var post = 0;
            $(".example1").persianDatepicker({
                showGregorianDate: true,
                formatPersian: false,
                months: ["فروردین", "اردیبهشت", "خرداد", "تیر", "مرداد", "شهریور", "مهر", "آبان", "آذر", "دی", "بهمن", "اسفند"],
                dowTitle: ["شنبه", "یکشنبه", "دوشنبه", "سه شنبه", "چهارشنبه", "پنج شنبه", "جمعه"],
                shortDowTitle: ["ش", "ی", "د", "س", "چ", "پ", "ج"],
                persianNumbers: true,
                responsive:true,
                isRTL: true,
                persianDigit: false,
                selectableMonths: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                selectedBefore: false,
                selectedDate: null,
                startDate: null,
                endDate: null,
                theme: 'default',
                alwaysShow: false,
                selectableYears: null,
                cellWidth: 25,
                cellHeight: 20,
                fontSize: 13,
                format: 'YYYY-MM-DD H:m:ss',
                observer: true,
                timePicker: {
                    enabled: true,
                    meridiem: {
                        enabled: true
                    },
                },
            });
            $("input[name='title']").val('');
            $("input[name='code']").val('');
            $("input[name='percent']").val('');
            $("input[name='count']").val('');
            $("input[name='day']").val('');
            $("select[name='product_id']").val('');
            $("select[name='status']").val('');
            $('.popUp').hide();
            $('.filterContent').hide();
            $('.filterTitle').click(function(){
                $('.filterContent').toggle();
            })
            $('#cancelDelete').click(function(){
                $('.popUp').hide();
                post = 0;
            })
            $('#deletePost').click(function(){
                $('.popUp').hide();
            });
            $('.buttons').on('click' , '.deleteButton' ,function(){
                post = this.id;
                $('.popUp').show();
                $('.buttonsPop form').attr('action' , '/admin/discount/' + post+'/delete');
            })
            $('.buttons').on('click' , '.editButton' ,function(){
                post = this.id;
                var form = {
                    "_token": "{{ csrf_token() }}",
                    discount:post,
                };
                $.ajax({
                    url: "/admin/discount/" + post + "/edit",
                    type: "get",
                    data: form,
                    success: function (data) {
                        $('.createFilled').attr('action' , '/admin/discount/' + post+'/edit');
                        $(".createFilled input[name='_method']").remove();
                        $('.createFilled').append(
                            $('@method('put')')
                        )
                        $('.buttonForm h4').remove();
                        $('.buttonForm').append(
                            $('<h4>لغو</h4>').on('click',function(ss){
                                post = 0;
                                $('.createFilled').attr('action' , '/admin/discount/');
                                $(".createFilled input[name='_method']").remove();
                                $(this).hide();
                                $("input[name='title']").val('');
                                $("input[name='code']").val('');
                                $("input[name='percent']").val('');
                                $("input[name='count']").val('');
                                $("input[name='day']").val('');
                                $("select[name='product_id']").val('');
                                $("select[name='status']").val('');
                            })
                        )
                        $("input[name='title']").val(data[0].title);
                        $("input[name='code']").val(data[0].code);
                        $("input[name='percent']").val(data[0].percent);
                        $("input[name='count']").val(data[0].count);
                        $("input[name='day']").val(data[1]);
                        $("select[name='product_id']").val(data[0].product_id);
                        $("select[name='status']").val(data[0].status);
                    },
                });
            })
        })
    </script>
@endsection

@section('jsScript')
    <script src="/js/jquery.toast.min.js"></script>
    <script src="/js/persian-date.min.js"></script>
    <script src="/js/persian-datepicker.min.js"></script>
@endsection

@section('links')
    <link rel="stylesheet" href="/css/persian-datepicker.min.css"/>
    <link rel="stylesheet" href="/css/jquery.toast.min.css"/>
@endsection
