@extends('admin.master')

@section('tab',1)
@section('content')
    <div class="allProduct">
        <div class="topProductIndex">
            <div class="right">
                <a href="/admin">داشبورد</a>
                <span>/</span>
                <a href="/admin/product">فرم تغییر پیشرفته</a>
            </div>
            <div class="allTopTableItem">
                <div></div>
                <div class="filterItems">
                    <div class="filterTitle">
                        <i>
                            <svg class="icon">
                                <use xlink:href="#filter"></use>
                            </svg>
                        </i>
                        فیلتر اطلاعات
                    </div>
                    <form method="GET" action="/admin/product" class="filterContent">
                        <div class="filterContentItem">
                            <label>فیلتر عنوان و آیدی</label>
                            <input type="text" name="title" placeholder="عنوان یا آیدی را وارد کنید" value="{{$title}}">
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
        <div class="allData">
            <table class="changeT">
                <tr class="trT">
                    <th>عنوان</th>
                    <th>پیوند(slug)</th>
                    <th>موجودی</th>
                    <th>قیمت پایه</th>
                    <th>تخفیف</th>
                    <th>امتیاز</th>
                    <th>وزن</th>
                    <th>وضعیت</th>
                    <th>زمان آماده سازی</th>
                    <th>زمان تحویل</th>
                    <th>ویترین</th>
                    <th>اصل</th>
                    <th>استعلام اجباری</th>
                    <th>توضیحات</th>
                </tr>
                @foreach($products as $item)
                    <tr id="{{$item->id}}">
                        <td>
                            <textarea name="title">{{$item->title}}</textarea>
                        </td>
                        <td>
                            <textarea name="slug">{{$item->slug}}</textarea>
                        </td>
                        <td>
                            <textarea name="count">{{$item->count}}</textarea>
                        </td>
                        <td>
                            <textarea name="offPrice">{{$item->offPrice}}</textarea>
                        </td>
                        <td>
                            <textarea name="off">{{$item->off}}</textarea>
                        </td>
                        <td>
                            <textarea name="score">{{$item->score}}</textarea>
                        </td>
                        <td>
                            <textarea name="weight">{{$item->weight}}</textarea>
                        </td>
                        <td>
                            <select name="status">
                                <option value="0" {{$item->status == 0? 'selected':''}}>پیشنویس</option>
                                <option value="1" {{$item->status == 1? 'selected':''}}>منتشر شده</option>
                            </select>
                        </td>
                        <td>
                            <textarea name="prepare">{{$item->prepare}}</textarea>
                        </td>
                        <td>
                            <textarea name="time">{{$item->time}}</textarea>
                        </td>
                        <td>
                            <input type="checkbox" name="showcase" {{$item->showcase == 1? 'checked':''}}>
                        </td>
                        <td>
                            <input type="checkbox" name="original" {{$item->original == 1? 'checked':''}}>
                        </td>
                        <td>
                            <input type="checkbox" name="inquiry" {{$item->inquiry == 1? 'checked':''}}>
                        </td>
                        <td>
                            <textarea name="body" placeholder="توضیحات">{{$item->body}}</textarea>
                        </td>
                    </tr>
                @endforeach
            </table>
            <div class="floatButton">ذخیره</div>
        </div>
        {{ $products->links('admin.paginate') }}
    </div>
@endsection

@section('scripts3')
    <script>
        $(document).ready(function(){
            $('.filterContent').hide();
            $('.filterTitle').click(function(){
                $('.filterContent').toggle();
            })
            $('.floatButton').click(function (){
                var products = [];
                $(".allData tr").each(function(){
                    if($(this).find("input").length >= 1){
                        var product = {
                            id : this.id,
                            title : '',
                            slug : '',
                            count : '',
                            offPrice : '',
                            off : '',
                            score : '',
                            weight : '',
                            maxCart : '',
                            status : '',
                            showcase : '',
                            original : '',
                            inquiry : '',
                            body : '',
                            prepare : '',
                            time : '',
                        }
                        $(this).find("select").each(function(){
                            if (this.name == 'status') {
                                product.status = this.value;
                            }
                        })
                        $(this).find("input").each(function(){
                            if (this.name == 'showcase') {
                                product.showcase = $(this).is(":checked");
                            }
                            if (this.name == 'original') {
                                product.original = $(this).is(":checked");
                            }
                            if (this.name == 'inquiry') {
                                product.inquiry = $(this).is(":checked");
                            }
                        })
                        $(this).find("textarea").each(function(){
                            if (this.name == 'title') {
                                product.title = this.value;
                            }
                            if (this.name == 'slug') {
                                product.slug = this.value;
                            }
                            if (this.name == 'count') {
                                product.count = this.value;
                            }
                            if (this.name == 'offPrice') {
                                product.offPrice = this.value;
                            }
                            if (this.name == 'off') {
                                product.off = this.value;
                            }
                            if (this.name == 'score') {
                                product.score = this.value;
                            }
                            if (this.name == 'weight') {
                                product.weight = this.value;
                            }
                            if (this.name == 'body') {
                                product.body = this.value;
                            }
                            if (this.name == 'prepare') {
                                product.prepare = this.value;
                            }
                            if (this.name == 'time') {
                                product.time = this.value;
                            }
                        })
                        products.push(product);
                    }
                });

                var form = {
                    "_token": "{{ csrf_token() }}",
                    products:JSON.stringify(products),
                };

                $.ajax({
                    url: "/admin/product/change",
                    type: "post",
                    data: form,
                    success: function (data) {
                        $.toast({
                            text: "تغییر محصولات انجام شد", // Text that is to be shown in the toast
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
                });
            })
        })
    </script>
@endsection
