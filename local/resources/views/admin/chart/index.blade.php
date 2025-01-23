@extends('admin.master')

@section('tab',12)
@section('content')
    <div class="allDashboard">
        <div class="widgets">
            <div class="widget">
                <h3>تعداد ثبت نام
                    @if($date == 0)
                        <span>امروز</span>
                    @elseif($date == 1)
                        <span>دیروز</span>
                    @elseif($date == 2)
                        <span>این هفته</span>
                    @elseif($date == 3)
                        <span>این ماه</span>
                    @elseif($date == 4)
                        <span>امسال</span>
                    @endif
                </h3>
                <h4>{{number_format($user1)}}</h4>
            </div>
            <div class="widget">
                <h3>
                    تعداد سفارش
                    @if($date == 0)
                        <span>امروز</span>
                    @elseif($date == 1)
                        <span>دیروز</span>
                    @elseif($date == 2)
                        <span>این هفته</span>
                    @elseif($date == 3)
                        <span>این ماه</span>
                    @elseif($date == 4)
                        <span>امسال</span>
                    @endif
                </h3>
                <h4>{{number_format($pay1)}}</h4>
            </div>
            <div class="widget">
                <h3>
                    میزان درآمد
                    @if($date == 0)
                        <span>امروز</span>
                    @elseif($date == 1)
                        <span>دیروز</span>
                    @elseif($date == 2)
                        <span>این هفته</span>
                    @elseif($date == 3)
                        <span>این ماه</span>
                    @elseif($date == 4)
                        <span>امسال</span>
                    @endif
                </h3>
                <h4>{{number_format($income1)}} تومان </h4>
            </div>
            <div class="widget">
                <h3>
                    تعداد دیدگاه
                    @if($date == 0)
                        <span>امروز</span>
                    @elseif($date == 1)
                        <span>دیروز</span>
                    @elseif($date == 2)
                        <span>این هفته</span>
                    @elseif($date == 3)
                        <span>این ماه</span>
                    @elseif($date == 4)
                        <span>امسال</span>
                    @endif
                </h3>
                <h4>{{number_format($comment1)}}</h4>
            </div>
            <div class="widget">
                <h3>
                    تعداد تیکت
                    @if($date == 0)
                        <span>امروز</span>
                    @elseif($date == 1)
                        <span>دیروز</span>
                    @elseif($date == 2)
                        <span>این هفته</span>
                    @elseif($date == 3)
                        <span>این ماه</span>
                    @elseif($date == 4)
                        <span>امسال</span>
                    @endif
                </h3>
                <h4>{{number_format($tickets1)}}</h4>
            </div>
            <div class="widget">
                <h3>
                    تعداد بازدید
                    @if($date == 0)
                        <span>امروز</span>
                    @elseif($date == 1)
                        <span>دیروز</span>
                    @elseif($date == 2)
                        <span>این هفته</span>
                    @elseif($date == 3)
                        <span>این ماه</span>
                    @elseif($date == 4)
                        <span>امسال</span>
                    @endif
                </h3>
                <h4>{{number_format($views1)}}</h4>
            </div>
        </div>
        <div class="allPayChartTops">
            <div class="title">
                پرفروش ترین محصولات
                @if($date == 0)
                    امروز
                @elseif($date == 1)
                    دیروز
                @elseif($date == 2)
                    این هفته
                @elseif($date == 3)
                    این ماه
                @elseif($date == 4)
                    امسال
                @endif
            </div>
            <div class="items">
                @foreach($tops as $item)
                <div class="allPayChartTopsItem">
                    <h2>#{{ $loop->iteration }}</h2>
                    <a href="/product/{{$item->slug}}" class="pic">
                        <img alt="{{$item->title}}" src="{{json_decode($item->image)[0]}}">
                    </a>
                    <a href="/product/{{$item->slug}}">{{ $item->title }}</a>
                    <div class="allDashboardWidgetOptionMid">
                        <div class="allDashboardWidgetOptionMidItem">
                            <div class="allDashboardWidgetOptionMidItemTitle">
                                <h5>کل خرید این محصول</h5>
                                <span>{{ $item->pay_meta_count }}</span>
                            </div>
                            <div class="allDashboardWidgetOptionMidItemSize">
                                <div style="width : 100%" class="allDashboardWidgetOptionMidItemSizeFill"></div>
                            </div>
                        </div>
                        <div class="allDashboardWidgetOptionMidItem">
                            <div class="allDashboardWidgetOptionMidItemTitle">
                                <h5>
                                    خرید
                                    @if($date == 0)
                                        امروز
                                    @elseif($date == 1)
                                        دیروز
                                    @elseif($date == 2)
                                        این هفته
                                    @elseif($date == 3)
                                        این ماه
                                    @elseif($date == 4)
                                        امسال
                                    @endif
                                </h5>
                                <span>{{ $item->payMeta2 }}</span>
                            </div>
                            <div class="allDashboardWidgetOptionMidItemSize">
                                <div style="width : {{$item->pay_meta_count == 0 ? 0 :($item->payMeta2 * 100) / $item->pay_meta_count}}%" class="allDashboardWidgetOptionMidItemSizeFill"></div>
                            </div>
                        </div>
                        <div class="allDashboardWidgetOptionMidItem">
                            <div class="allDashboardWidgetOptionMidItemTitle">
                                <h5>باقیمانده این محصول</h5>
                                <span>{{ $item->count }}</span>
                            </div>
                            <div class="allDashboardWidgetOptionMidItemSize">
                                <div style="width : {{$item->pay_meta_count == 0 ? 0 :($item->count * 100) / ($item->count + $item->pay_meta_count)}}%" class="allDashboardWidgetOptionMidItemSizeFill"></div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="allPayChartTops">
            <div class="title">
                پربازدید ترین محصولات
                @if($date == 0)
                    امروز
                @elseif($date == 1)
                    دیروز
                @elseif($date == 2)
                    این هفته
                @elseif($date == 3)
                    این ماه
                @elseif($date == 4)
                    امسال
                @endif
            </div>
            <div class="items">
                @foreach($views as $item)
                <div class="allPayChartTopsItem">
                    <h2>#{{ $loop->iteration }}</h2>
                    <a href="/product/{{$item->slug}}" class="pic">
                        <img alt="{{$item->title}}" src="{{json_decode($item->image)[0]}}">
                    </a>
                    <a href="/product/{{$item->slug}}">{{ $item->title }}</a>
                    <div class="allDashboardWidgetOptionMid">
                        <div class="allDashboardWidgetOptionMidItem">
                            <div class="allDashboardWidgetOptionMidItemTitle">
                                <h5>کل بازدید این محصول</h5>
                                <span>{{ $item->view_count }}</span>
                            </div>
                            <div class="allDashboardWidgetOptionMidItemSize">
                                <div style="width : 100%" class="allDashboardWidgetOptionMidItemSizeFill"></div>
                            </div>
                        </div>
                        <div class="allDashboardWidgetOptionMidItem">
                            <div class="allDashboardWidgetOptionMidItemTitle">
                                <h5>
                                     بازدید
                                    @if($date == 0)
                                        امروز
                                    @elseif($date == 1)
                                        دیروز
                                    @elseif($date == 2)
                                        این هفته
                                    @elseif($date == 3)
                                        این ماه
                                    @elseif($date == 4)
                                        امسال
                                    @endif
                                </h5>
                                <span>{{ $item->view2 }}</span>
                            </div>
                            <div class="allDashboardWidgetOptionMidItemSize">
                                <div style="width : {{$item->view_count == 0 ? 0 :($item->view2 * 100) /$item->view_count}}%" class="allDashboardWidgetOptionMidItemSizeFill"></div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="charts">
            <canvas id="myChart1"></canvas>
        </div>
        <div class="charts">
            <canvas id="myChart2"></canvas>
        </div>
        <div class="charts">
            <canvas id="myChart3"></canvas>
        </div>
    </div>
@endsection

@section('scripts3')
    <script>
        var farvardinPay = {!! json_encode($farvardinPay, JSON_HEX_TAG) !!};
        var ordibeheshtPay = {!! json_encode($ordibeheshtPay, JSON_HEX_TAG) !!};
        var khordadPay = {!! json_encode($khordadPay, JSON_HEX_TAG) !!};
        var tirPay = {!! json_encode($tirPay, JSON_HEX_TAG) !!};
        var mordadPay = {!! json_encode($mordadPay, JSON_HEX_TAG) !!};
        var shahrivarPay = {!! json_encode($shahrivarPay, JSON_HEX_TAG) !!};
        var mehrPay = {!! json_encode($mehrPay, JSON_HEX_TAG) !!};
        var abanPay = {!! json_encode($abanPay, JSON_HEX_TAG) !!};
        var azarPay = {!! json_encode($azarPay, JSON_HEX_TAG) !!};
        var deyPay = {!! json_encode($deyPay, JSON_HEX_TAG) !!};
        var bahmanPay = {!! json_encode($bahmanPay, JSON_HEX_TAG) !!};
        var esfandPay = {!! json_encode($esfandPay, JSON_HEX_TAG) !!};
        const labels = [
            'فروردین',
            'اردیبهشت',
            'خرداد',
            'تیر',
            'مرداد',
            'شهریور',
            'مهر',
            'آبان',
            'آذر',
            'دی',
            'بهمن',
            'اسفند',
        ];
        const data = {
            labels: labels,
            datasets: [{
                label: 'تعداد سفارش ماهیانه',
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: [
                    farvardinPay,
                    ordibeheshtPay,
                    khordadPay,
                    tirPay,
                    mordadPay,
                    shahrivarPay,
                    mehrPay,
                    abanPay,
                    azarPay,
                    deyPay,
                    bahmanPay,
                    esfandPay,
                ],
            }]
        };
        const config = {
            type: 'line',
            data: data,
            options: {
                plugins: {
                    legend: {
                        labels: {
                            font: {
                                size: 14,
                                family: 'irsans'
                            },
                        }
                    }
                }
            }
        };
        const myChart = new Chart(
            document.getElementById('myChart1'),
            config
        );

        var farvardinPrice = {!! json_encode($farvardinPrice, JSON_HEX_TAG) !!};
        var ordibeheshtPrice = {!! json_encode($ordibeheshtPrice, JSON_HEX_TAG) !!};
        var khordadPrice = {!! json_encode($khordadPrice, JSON_HEX_TAG) !!};
        var tirPrice = {!! json_encode($tirPrice, JSON_HEX_TAG) !!};
        var mordadPrice = {!! json_encode($mordadPrice, JSON_HEX_TAG) !!};
        var shahrivarPrice = {!! json_encode($shahrivarPrice, JSON_HEX_TAG) !!};
        var mehrPrice = {!! json_encode($mehrPrice, JSON_HEX_TAG) !!};
        var abanPrice = {!! json_encode($abanPrice, JSON_HEX_TAG) !!};
        var azarPrice = {!! json_encode($azarPrice, JSON_HEX_TAG) !!};
        var deyPrice = {!! json_encode($deyPrice, JSON_HEX_TAG) !!};
        var bahmanPrice = {!! json_encode($bahmanPrice, JSON_HEX_TAG) !!};
        var esfandPrice = {!! json_encode($esfandPrice, JSON_HEX_TAG) !!};
        const labels2 = [
            'فروردین',
            'اردیبهشت',
            'خرداد',
            'تیر',
            'مرداد',
            'شهریور',
            'مهر',
            'آبان',
            'آذر',
            'دی',
            'بهمن',
            'اسفند',
        ];
        const data2 = {
            labels: labels2,
            datasets: [{
                label: 'درآمد ماهیانه',
                backgroundColor: 'rgba(60,217,1)',
                borderColor: 'rgb(60,217,1)',
                data: [
                    farvardinPrice,
                    ordibeheshtPrice,
                    khordadPrice,
                    tirPrice,
                    mordadPrice,
                    shahrivarPrice,
                    mehrPrice,
                    abanPrice,
                    azarPrice,
                    deyPrice,
                    bahmanPrice,
                    esfandPrice,
                ],
            }]
        };
        const config2 = {
            type: 'line',
            data: data2,
            options: {
                plugins: {
                    legend: {
                        labels: {
                            font: {
                                size: 14,
                                family: 'irsans'
                            },
                        }
                    }
                }
            }
        };
        const myChart2 = new Chart(
            document.getElementById('myChart2'),
            config2
        );

        var farvardinUser = {!! json_encode($farvardinUser, JSON_HEX_TAG) !!};
        var ordibeheshtUser = {!! json_encode($ordibeheshtUser, JSON_HEX_TAG) !!};
        var khordadUser = {!! json_encode($khordadUser, JSON_HEX_TAG) !!};
        var tirUser = {!! json_encode($tirUser, JSON_HEX_TAG) !!};
        var mordadUser = {!! json_encode($mordadUser, JSON_HEX_TAG) !!};
        var shahrivarUser = {!! json_encode($shahrivarUser, JSON_HEX_TAG) !!};
        var mehrUser = {!! json_encode($mehrUser, JSON_HEX_TAG) !!};
        var abanUser = {!! json_encode($abanUser, JSON_HEX_TAG) !!};
        var azarUser = {!! json_encode($azarUser, JSON_HEX_TAG) !!};
        var deyUser = {!! json_encode($deyUser, JSON_HEX_TAG) !!};
        var bahmanUser = {!! json_encode($bahmanUser, JSON_HEX_TAG) !!};
        var esfandUser = {!! json_encode($esfandUser, JSON_HEX_TAG) !!};
        const labels3 = [
            'فروردین',
            'اردیبهشت',
            'خرداد',
            'تیر',
            'مرداد',
            'شهریور',
            'مهر',
            'آبان',
            'آذر',
            'دی',
            'بهمن',
            'اسفند',
        ];
        const data3 = {
            labels: labels3,
            datasets: [{
                label: 'تعداد ثبت نام ماهیانه',
                backgroundColor: 'rgb(1,127,217)',
                borderColor: 'rgb(1,127,217)',
                data: [
                    farvardinUser,
                    ordibeheshtUser,
                    khordadUser,
                    tirUser,
                    mordadUser,
                    shahrivarUser,
                    mehrUser,
                    abanUser,
                    azarUser,
                    deyUser,
                    bahmanUser,
                    esfandUser,
                ],
            }]
        };
        const config3 = {
            type: 'line',
            data: data3,
            options: {
                plugins: {
                    legend: {
                        labels: {
                            font: {
                                size: 14,
                                family: 'irsans'
                            },
                        }
                    }
                }
            }
        };
        const myChart3 = new Chart(
            document.getElementById('myChart3'),
            config3
        );
    </script>
@endsection

@section('jsScript')
    <script src="/js/chart.js"></script>
@endsection
