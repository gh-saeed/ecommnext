@extends('admin.master')

@section('tab' , 7)
@section('content')
    <div class="allPayPanel">
        <div class="topProductIndex">
            <div class="right">
                <a href="/admin">داشبورد</a>
                <span>/</span>
                <a href="/admin/pay">همه سفارشات</a>
            </div>
            <div class="allTopTableItem">
                <div class="groupEdits" style="display:none;">چاپ گروهی</div>
                <div class="filterItems">
                    <div class="filterTitle">
                        <i>
                            <svg class="icon">
                                <use xlink:href="#filter"></use>
                            </svg>
                        </i>
                        فیلتر اطلاعات
                    </div>
                    <form method="GET" action="/admin/pay" class="filterContent">
                        <div class="filterContentItem">
                            <label>فیلتر حامل و شماره سفارش و آیدی کاربر و نام کاربری و آیدی</label>
                            <input type="text" name="title" placeholder="مثال: 10" value="{{$title}}">
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
        @if(count($pined) >= 1)
            <div class="allTableContainer">
                <div class="titlePin">سفارشات پین شده</div>
                @foreach ($pined as $item)
                    <div class="postItem" id="{{$item->id}}">
                        <div class="postTop">
                            <div class="postTitle">
                                <div class="postImages">
                                    @foreach($item['payMeta']->slice(0, 3) as $post)
                                        <div class="postImage">
                                            @if($post->product)
                                                <img src="{{json_decode($post->product->image)[0]}}" alt="{{$post->product->title}}">
                                            @endif
                                        </div>
                                    @endforeach
                                    @if(count($item['payMeta']) >= 4)
                                        <div class="postMore">
                                            <i>
                                                <svg class="icon">
                                                    <use xlink:href="#more"></use>
                                                </svg>
                                            </i>
                                        </div>
                                    @endif
                                </div>
                                <ul>
                                    <li>
                                        <span>زمان ثبت :</span>
                                        <span>{{$item->created_at}}</span>
                                    </li>
                                    <li>
                                        <span>نام کاربری :</span>
                                        <span>{{$item->user->name}}</span>
                                    </li>
                                    <li>
                                        <span>نوع پرداخت :</span>
                                        @if($item->method == 0)
                                            <span>پرداخت از درگاه</span>
                                        @endif
                                        @if($item->method == 1)
                                            <span>پرداخت از کیف پول</span>
                                        @endif
                                    </li>
                                    <li>
                                        <span>درگاه :</span>
                                        @if($item->gate == 0)
                                            <span>زرینپال</span>
                                        @elseif($item->gate == 1)
                                            <span>زیبال</span>
                                        @elseif($item->gate == 2)
                                            <span>نکست پی</span>
                                        @elseif($item->gate == 3)
                                            <span>نکست پی</span>
                                        @elseif($item->gate == 4)
                                            <span>آیدی پی</span>
                                        @elseif($item->gate == 5)
                                            <span>به پرداخت ملت</span>
                                        @elseif($item->gate == 6)
                                            <span>سداد ملی</span>
                                        @elseif($item->gate == 7)
                                            <span>آسان پرداخت</span>
                                        @elseif($item->gate == 8)
                                            <span>پاسارگاد</span>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                            <div class="postOptions">
                                <a href="/admin/pay/invoice/{{$item->id}}" title="پرینت خرید">
                                    <svg class="icon">
                                        <use xlink:href="#print"></use>
                                    </svg>
                                </a>
                                <a href="/admin/pay?pin={{$item->id}}" title="{{$item->pin ? 'حذف پین' : 'پین کردن'}}">
                                    <svg class="icon">
                                        <use xlink:href="#pin"></use>
                                    </svg>
                                </a>
                                <a href="/admin/pay/{{$item->id}}" title="ویرایش خرید">
                                    <svg class="icon">
                                        <use xlink:href="#edit"></use>
                                    </svg>
                                </a>
                                <i title="حذف خرید" class="deletePay" id="{{$item->id}}">
                                    <svg class="icon">
                                        <use xlink:href="#trash"></use>
                                    </svg>
                                </i>
                            </div>
                        </div>
                        <div class="postBot">
                            <ul>
                                <li>
                                    <span>مبلغ پرداختی :</span>
                                    @if($item->status == 100)
                                        <span>{{ number_format($item->price) }} تومان</span>
                                    @endif
                                    @if($item->status == 0)
                                        <span>0</span>
                                    @endif
                                </li>
                                <li>
                                    <span>شماره سفارش :</span>
                                    <span>{{$item->property}}</span>
                                </li>
                                <li>
                                    <span>وضعیت پرداخت :</span>
                                    @if($item->status == 100)
                                        <span class="status100">پرداخت شده</span>
                                    @endif
                                    @if($item->status == 0)
                                        <span class="status0">پرداخت نشده</span>
                                    @endif
                                    @if($item->status == 1)
                                        <span class="status1">لغو شده</span>
                                    @endif
                                </li>
                            </ul>
                            <i class="checks1">
                                <svg class="icon">
                                    <use xlink:href="#uncheck1"></use>
                                </svg>
                            </i>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        <div class="allTableContainer">
            <div class="titlePin">سفارشات شما</div>
            @foreach ($pays as $item)
                <div class="postItem" id="{{$item->id}}">
                    <div class="postTop">
                        <div class="postTitle">
                            <div class="postImages">
                                @foreach($item['payMeta']->slice(0, 3) as $post)
                                <div class="postImage">
                                    @if($post->product)
                                        <img src="{{json_decode($post->product->image)[0]}}" alt="{{$post->product->title}}">
                                    @endif
                                </div>
                                @endforeach
                                @if(count($item['payMeta']) >= 4)
                                    <div class="postMore">
                                        <i>
                                            <svg class="icon">
                                                <use xlink:href="#more"></use>
                                            </svg>
                                        </i>
                                    </div>
                                @endif
                            </div>
                            <ul>
                                <li>
                                    <span>زمان ثبت :</span>
                                    <span>{{$item->created_at}}</span>
                                </li>
                                <li>
                                    <span>نام کاربری :</span>
                                    <span>{{$item->user->name}}</span>
                                </li>
                                <li>
                                    <span>نوع پرداخت :</span>
                                    @if($item->method == 0)
                                        <span>پرداخت از درگاه</span>
                                    @endif
                                    @if($item->method == 1)
                                        <span>پرداخت از کیف پول</span>
                                    @endif
                                </li>
                            </ul>
                        </div>
                        <div class="postOptions">
                            <a href="/admin/pay/invoice/{{$item->id}}" title="پرینت خرید">
                                <svg class="icon">
                                    <use xlink:href="#print"></use>
                                </svg>
                            </a>
                            <a href="/admin/pay?pin={{$item->id}}" title="{{$item->pin ? 'حذف پین' : 'پین کردن'}}">
                                <svg class="icon">
                                    <use xlink:href="#pin"></use>
                                </svg>
                            </a>
                            <a href="/admin/pay/{{$item->id}}" title="ویرایش خرید">
                                <svg class="icon">
                                    <use xlink:href="#edit"></use>
                                </svg>
                            </a>
                            <i title="حذف خرید" class="deletePay" id="{{$item->id}}">
                                <svg class="icon">
                                    <use xlink:href="#trash"></use>
                                </svg>
                            </i>
                        </div>
                    </div>
                    <div class="postBot">
                        <ul>
                            <li>
                                <span>مبلغ پرداختی :</span>
                                @if($item->status == 100)
                                    <span>{{ number_format($item->price) }} تومان</span>
                                @else
                                    <span>0</span>
                                @endif
                            </li>
                            <li>
                                <span>شماره سفارش :</span>
                                <span>{{$item->property}}</span>
                            </li>
                            <li>
                                <span>وضعیت ارسال :</span>
                                @if($item->deliver == 0)
                                    <span class="unActive">دریافت سفارش</span>
                                @endif
                                @if($item->deliver == 1)
                                    <span class="unActive">در انتظار بررسی</span>
                                @endif
                                @if($item->deliver == 2)
                                    <span class="unActive">بسته بندی شده</span>
                                @endif
                                @if($item->deliver == 3)
                                    <span class="unActive">تحویل پیک</span>
                                @endif
                                @if($item->deliver == 4)
                                    <span class="active">تحویل مشتری</span>
                                @endif
                            </li>
                            <li>
                                <span>وضعیت پرداخت :</span>
                                @if($item->status == 100)
                                    <span class="status100">پرداخت شده</span>
                                @elseif($item->status == 0)
                                    <span class="status0">پرداخت نشده</span>
                                @elseif($item->status == 1)
                                    <span class="status1">لغو شده</span>
                                @elseif($item->status == 2)
                                    <span class="status1">مرجوعی</span>
                                @endif
                            </li>
                        </ul>
                        <i class="checks1">
                            <svg class="icon">
                                <use xlink:href="#uncheck1"></use>
                            </svg>
                        </i>
                    </div>
                </div>
            @endforeach
        </div>
        {{ $pays->links('admin.paginate') }}
        <div class="popUp" style="display:none;">
            <div class="popUpItem">
                <div class="title">آیا از حذف سفارش مطمئن هستید؟</div>
                <p>با حذف سفارش اطلاعات سفارش به طور کامل حذف میشوند</p>
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
            var checked = 0;
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
            $('.allTableContainer .postItem').on('click' , '.deletePay' ,function(){
                post = this.id;
                $('.popUp').show();
                $('.buttonsPop form').attr('action' , '/admin/pay/' + post+'/delete');
            });
            $('.postItem').click(function(){
                if($(this).attr('class') == 'postItem checked'){
                    $(this).attr('class' , 'postItem');
                    $(this).find('.checks1 svg').remove();
                    $($(this).find('.checks1')[0]).append($(
                        `<svg class="icon">
                                <use xlink:href="#uncheck1"></use>
                            </svg>`
                    ));
                    checked = parseInt(checked) - 1;
                    if(checked == 0){
                        $('.groupEdits').hide();
                    }
                }else{
                    $(this).attr('class' , 'postItem checked');
                    checked = parseInt(checked) + 1;
                    $('.groupEdits').show();
                    $(this).find('.checks1 svg').remove();
                    $($(this).find('.checks1')[0]).append($(
                        `<svg class="icon">
                                <use xlink:href="#check1"></use>
                            </svg>`
                    ))
                }
            })
            $('.groupEdits').on('click' , function(){
                var products = [];
                $.each($('.allTableContainer .checked'),function(){
                    products.push($(this).attr('id'));
                })
                products.join(',');
                window.location.href = '/admin/invoice/group?pay='+products;
            });
        })
    </script>
@endsection

