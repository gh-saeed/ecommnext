@extends('seller.master')

@section('tab' , 3)
@section('content')
    <div class="allPayPanel">
        <div class="topProductIndex">
            <div class="right">
                <a href="/seller/dashboard">{{__('messages.dashboard')}}</a>
                <span>/</span>
                <a href="/seller/pay">{{__('messages.all_order1')}}</a>
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
                        {{__('messages.filter_info')}}
                    </div>
                    <form method="GET" action="/seller/pay" class="filterContent">
                        <div class="filterContentItem">
                            <label>فیلتر شماره سفارش و آیدی</label>
                            <input type="text" name="title" placeholder="فیلتر شماره سفارش و آیدی" value="{{$title}}">
                        </div>
                        <button type="submit">{{__('messages.action')}}</button>
                    </form>
                </div>
            </div>
        </div>
        @if (\Session::has('message'))
            <div class="alert">
                {!! \Session::get('message') !!}
            </div>
        @endif
        <div class="allTableContainer">
            @foreach ($pays as $item)
                <div class="postItem" id="{{$item->property}}">
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
                                </li>
                            </ul>
                        </div>
                        <div class="postOptions">
                            <a href="/seller/pay/invoice/{{$item->property}}" title="پرینت سفارش">
                                <svg class="icon">
                                    <use xlink:href="#print"></use>
                                </svg>
                            </a>
                            <a href="/seller/pay/{{$item->property}}" title="مشاهده سفارش">
                                <svg class="icon">
                                    <use xlink:href="#edit"></use>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="postBot">
                        <ul>
                            <li>
                                <span>مبلغ پرداختی :</span>
                                @if($item->status == 100)
                                    <span>{{ number_format($item->myPayMeta()->where('cancel', 0)->sum(DB::raw('price + carrier_price'))) }} تومان</span>
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
    </div>
@endsection

@section('scripts3')
    <script>
        $(document).ready(function(){
            var checked = 0;
            $('.filterContent').hide();
            $('.filterTitle').click(function(){
                $('.filterContent').toggle();
            })
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
                window.location.href = '/seller/pay/group?pay='+products;
            });
        })
    </script>
@endsection

