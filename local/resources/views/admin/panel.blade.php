@extends('admin.master')

@section('tab',0)
@section('content')
    <div class="allDashboard">
        <div class="showOnline">
            <div class="right">
                <div class="count">{{count(Cache::get('user-check')?Cache::get('user-check'):1)}}<span>کاربر</span> </div>
                <div class="title">کاربرانی که در این لحظه در سایتتان هستند</div>
            </div>
            <div class="left">
                <a href="/admin/online" target="_blank">مشاهده لحظه ای</a>
            </div>
        </div>
        <div class="widgets">
            <div class="widget">
                <h3>ثبت نام امروز</h3>
                <h4>{{number_format($todayUser)}}</h4>
            </div>
            <div class="widget">
                <h3>تعداد بازدید ها</h3>
                <h4>{{$allView}}</h4>
            </div>
            <div class="widget">
                <h3>بازدید امروز</h3>
                <h4>{{$todayView}}</h4>
            </div>
            <div class="widget">
                <h3>گزارشات امروز</h3>
                <h4>{{number_format($allComment)}}</h4>
            </div>
            <div class="widget">
                <h3>دیدگاه امروز</h3>
                <h4>{{number_format($todayComment)}}</h4>
            </div>
            <div class="widget">
                <h3>سفارشات امروز</h3>
                <h4>{{number_format($todayPay)}}</h4>
            </div>
            <div class="widget">
                <h3>محصولات تمام شده</h3>
                <h4>{{number_format($allEmpty)}}</h4>
            </div>
            <div class="widget">
                <h3>درآمد امروز</h3>
                <h4>{{number_format($allIncome)}} تومان </h4>
            </div>
        </div>
        <div class="chartsPie">
            <figure class="pieCharts">
                <div id="pieChart1"></div>
            </figure>
            <figure class="pieCharts">
                <div id="pieChart2"></div>
            </figure>
        </div>
        <div class="chartsData">
            <figure class="chartData">
                <div id="pieChart3"></div>
            </figure>
            <div class="allTables">
                <h4>آخرین مشتریان</h4>
                <div class="allData">
                    <table class="invoiceT">
                        <tr>
                            <th>نام کاربر</th>
                            <th>شماره تماس</th>
                            <th>ایمیل</th>
                            <th>وضعیت</th>
                            <th>زمان ثبت</th>
                        </tr>
                        @foreach(\App\Models\User::latest()->take(4)->get() as $item)
                            <tr>
                                <td>{{$item->name}}</td>
                                <td>{{$item->number}}</td>
                                <td>{{$item->email}}</td>
                                <td>
                                    @if($item->isOnline())
                                        آنلاین
                                    @else
                                        آفلاین
                                    @endif
                                </td>
                                <td>{{$item->created_at}}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="listsData">
            <div class="allTables">
                <h4>آخرین سفارشات</h4>
                <div class="allData">
                    <table class="contractsT">
                        <tr>
                            <th>شناسه</th>
                            <th>مشتری</th>
                            <th>مبلغ</th>
                            <th>وضعیت پرداخت</th>
                            <th>شماره سفارش</th>
                            <th>تعداد محصول</th>
                        </tr>
                        @foreach(\App\Models\Pay::latest()->take(4)->get() as $item)
                            <tr>
                                <td>#{{$item->id}}</td>
                                @if($item->user)
                                    <td>{{$item->user->name}}</td>
                                @else
                                    <td>-</td>
                                @endif
                                <td>{{number_format($item->price)}} تومان</td>
                                <td>
                                    @if($item->status == 100)
                                        <span class="status100">پرداخت شده</span>
                                    @endif
                                    @if($item->status == 50)
                                        <span class="status50">پرداخت بیعانه</span>
                                    @endif
                                    @if($item->status == 0)
                                        <span class="status0">پرداخت نشده</span>
                                    @endif
                                    @if($item->status == 20)
                                        <span class="status20">در حال پرداخت</span>
                                    @endif
                                    @if($item->status == 10)
                                        <span class="status10">پرداخت اقساطی</span>
                                    @endif
                                    @if($item->status == 1)
                                        <span class="status1">لغو شده</span>
                                    @endif
                                </td>
                                <td>{{$item->property}}</td>
                                <td>{{$item->payMeta()->count()}}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            <div class="allTables">
                <h4>آخرین رویداد</h4>
                <div class="allData">
                    <table class="eventT">
                        <tr>
                            <th>نام کاربر</th>
                            <th>عنوان</th>
                            <th>توضیحات</th>
                            <th>زمان</th>
                        </tr>
                        @foreach(\App\Models\Event::latest()->take(4)->get() as $item)
                            <tr>
                                <td>
                                    @if($item->customer)
                                        {{$item->customer->name}}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{$item->title}}</td>
                                <td>{{$item->body}}</td>
                                <td>{{$item->created_at}}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts3')
    <script>
        $(document).ready(function(){
            var taskChart0 = {!! json_encode($taskChart0, JSON_HEX_TAG) !!};
            var taskChart2 = {!! json_encode($taskChart2, JSON_HEX_TAG) !!};
            var projectChart0 = {!! json_encode($projectChart0, JSON_HEX_TAG) !!};
            var projectChart1 = {!! json_encode($projectChart1, JSON_HEX_TAG) !!};
            var projectChart2 = {!! json_encode($projectChart2, JSON_HEX_TAG) !!};
            var projectChart3 = {!! json_encode($projectChart3, JSON_HEX_TAG) !!};
            var statusProduct0 = {!! json_encode($statusProduct0, JSON_HEX_TAG) !!};
            var statusProduct1 = {!! json_encode($statusProduct1, JSON_HEX_TAG) !!};
            var statusProduct2 = {!! json_encode($statusProduct2, JSON_HEX_TAG) !!};
            Highcharts.chart('pieChart1', {
                colors: Highcharts.map(Highcharts.getOptions().colors, function (color) {
                    return {
                        radialGradient: {
                            cx: 0.5,
                            cy: 0.3,
                            r: 0.7
                        },
                        stops: [
                            [0, color],
                            [1, Highcharts.color(color).brighten(-0.3).get('rgb')] // darken
                        ]
                    };
                }),
                chart: {
                    type: 'pie',
                    style: {
                        fontFamily: 'irsans'
                    },
                    options3d: {
                        enabled: true,
                        alpha: 45
                    }
                },
                title: {
                    text: 'وضعیت انصراف سفارشات',
                    align: 'center'
                },
                subtitle: {
                    text: 'تمام وضعیت های پرداخت',
                    align: 'center'
                },
                plotOptions: {
                    pie: {
                        innerSize: 100,
                        depth: 45
                    }
                },
                series: [{
                    name: 'تعداد',
                    data: [
                        ['تایید شده', taskChart0],
                        ['لغو شده', taskChart2],
                    ]
                }]
            });
            Highcharts.chart('pieChart2', {
                colors: Highcharts.map(Highcharts.getOptions().colors, function (color) {
                    return {
                        radialGradient: {
                            cx: 0.5,
                            cy: 0.3,
                            r: 0.7
                        },
                        stops: [
                            [0, color],
                            [1, Highcharts.color(color).brighten(-0.3).get('rgb')] // darken
                        ]
                    };
                }),
                chart: {
                    type: 'pie',
                    style: {
                        fontWeight: 300,
                        fontFamily: 'irsans',
                    },
                    options3d: {
                        enabled: true,
                        alpha: 45
                    },
                },
                title: {
                    text: 'وضعیت تحویل محصولات',
                    align: 'center'
                },
                subtitle: {
                    text: 'تمام وضعیت های تحویل',
                    align: 'center'
                },
                plotOptions: {
                    pie: {
                        innerSize: 100,
                        depth: 45
                    }
                },
                series: [{
                    name: 'تعداد',
                    data: [
                        ['در انتظار بررسی', projectChart0],
                        ['بسته بندی شده', projectChart1],
                        ['تحویل پیک', projectChart2],
                        ['تکمیل شده', projectChart3],
                    ]
                }]
            });
            Highcharts.chart('pieChart3', {
                colors: Highcharts.map(Highcharts.getOptions().colors, function (color) {
                    return {
                        radialGradient: {
                            cx: 0.5,
                            cy: 0.3,
                            r: 0.7
                        },
                        stops: [
                            [0, color],
                            [1, Highcharts.color(color).brighten(-0.3).get('rgb')] // darken
                        ]
                    };
                }),
                chart: {
                    type: 'pie',
                    style: {
                        fontWeight: 300,
                        fontFamily: 'irsans',
                    },
                    options3d: {
                        enabled: true,
                        alpha: 45
                    },
                },
                title: {
                    text: 'وضعیت موجودی محصولات',
                    align: 'center'
                },
                subtitle: {
                    text: 'تمام وضعیت های تحویل',
                    align: 'center'
                },
                plotOptions: {
                    pie: {
                        innerSize: 100,
                        depth: 45
                    }
                },
                series: [{
                    name: 'تعداد',
                    data: [
                        ['موجود', statusProduct0],
                        ['رو به اتمام', statusProduct1],
                        ['تمام شده', statusProduct2],
                    ]
                }]
            });
        })
    </script>
@endsection

@section('jsScript')
    <script src="/js/highcharts/highcharts.min.js"></script>
    <script src="/js/highcharts/highcharts-3d.min.js"></script>
    <script src="/js/highcharts/exporting.min.js"></script>
    <script src="/js/highcharts/export-data.min.js"></script>
    <script src="/js/highcharts/accessibility.min.js"></script>
@endsection
