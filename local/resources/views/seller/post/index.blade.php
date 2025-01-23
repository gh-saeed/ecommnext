@extends('seller.master')

@section('tab',$tab)
@section('content')
    <div class="allProduct">
        <div class="topProductIndex">
            <div class="right">
                <a href="/seller">داشبورد</a>
                <span>/</span>
                <a href="/seller/product">همه محصول ها</a>
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
                    <form method="GET" action="/seller/product" class="filterContent" style="display: none;z-index: 10">
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
        <div class="productItems">
            @foreach($products as $item)
                <div id="{{$item->id}}" class="postItem newTr">
                    <div class="postTop">
                        <div class="postTitle">
                            <div class="postImages">
                                @foreach(json_decode($item->image) as $image)
                                    @if($loop->index <= 1)
                                        <div class="postImage">
                                            <img src="{{$image}}" alt="{{$item->title}}">
                                        </div>
                                    @endif
                                    @if($loop->index == 2)
                                        <div class="postMore">
                                            <i>
                                                <svg class="icon">
                                                    <use xlink:href="#more"></use>
                                                </svg>
                                            </i>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <ul class="alerts">
                                <li>
                                    <span>عنوان :</span>
                                    <span>{{$item->title}}</span>
                                </li>
                                <li>
                                    <span>کد محصول :</span>
                                    <span>{{$item->product_id}}</span>
                                </li>
                            </ul>
                        </div>
                        <div class="postOptions">
                            <a href="/seller/product/{{$item->id}}/show" target="_blank" title="آمارگیری محصول">آمارگیری</a>
                            <a href="/product/{{$item->slug}}" target="_blank" title="پیشنمایش محصول">پیشنمایش</a>
                            <a href="/seller/product/{{$item->id}}/edit" target="_blank" title="ویرایش محصول">ویرایش</a>
                            <a href="/seller/product/{{$item->id}}/copy" target="_blank" title="کپی محصول">کپی</a>
                        </div>
                    </div>
                    <div class="postBot">
                        <ul>
                            <li>
                                <span>موجودی :</span>
                                <span>{{$item->count}}</span>
                            </li>
                            <li>
                                <span>قیمت :</span>
                                <span>{{number_format($item->price)}} تومان</span>
                            </li>
                            <li>
                                <span>تخفیف :</span>
                                @if($item->off >= 1)
                                    <span>%{{$item->off}}</span>
                                @else
                                    <span>-</span>
                                @endif
                            </li>
                            <li>
                                <span>دسته بندی :</span>
                                @if(count($item->category) >= 1)
                                    <span>{{$item->category()->pluck('name')->first()}}</span>
                                @endif
                            </li>
                            <li>
                                <span>زمان ثبت :</span>
                                <span>{{$item->created_at}}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            @endforeach
            {{ $products->links('admin.paginate') }}
        </div>
    </div>
@endsection


@section('scripts3')
    <script>
        $(document).ready(function(){
            $('.filterContent').hide();
            $('.filterTitle').click(function(){
                $('.filterContent').toggle();
            })
        })
    </script>
@endsection
