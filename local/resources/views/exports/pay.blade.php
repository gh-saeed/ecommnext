<table>
    <thead>
    <tr>
        <th>شماره سفارش</th>
        <th>مبلغ پرداختی</th>
        <th>هزینه ارسال</th>
        <th>نام کاربر</th>
        <th>شماره کاربر</th>
        <th>استان کاربر</th>
        <th>شهر کاربر</th>
        <th>آدرس کاربر</th>
        <th>کد پستی</th>
        <th>زمان ثبت</th>
        <th>محصولات</th>
    </tr>
    </thead>
    <tbody>
    @foreach($invoices as $invoice)
        <tr>
            <td>
                {{$invoice->property}}
            </td>
            <td>
                @if(request()->is('/admin*'))
                    {{$invoice->payMeta()->where('cancel',0)->sum(DB::raw('price + carrier_price'))}}
                @else
                    {{$invoice->myPayMeta()->where('cancel',0)->sum(DB::raw('price + carrier_price'))}}
                @endif
            </td>
            <td>
                @if(request()->is('/admin*'))
                    {{$invoice->payMeta()->where('cancel',0)->sum('carrier_price')}}
                @else
                    {{$invoice->myPayMeta()->where('cancel',0)->sum('carrier_price')}}
                @endif
            </td>
            <td>
                @if(count($invoice->address) >= 1)
                    {{$invoice->address[0]->name}}
                @else
                    -
                @endif
            </td>
            <td>
                @if(count($invoice->address) >= 1)
                    {{$invoice->address[0]->number}}
                @else
                    -
                @endif
            </td>
            <td>
                @if(count($invoice->address) >= 1)
                    {{$invoice->address[0]->state}}
                @else
                    -
                @endif
            </td>
            <td>
                @if(count($invoice->address) >= 1)
                    {{$invoice->address[0]->city}}
                @else
                    -
                @endif
            </td>
            <td>
                @if(count($invoice->address) >= 1)
                    {{$invoice->address[0]->address}}
                @else
                    -
                @endif
            </td>
            <td>
                @if(count($invoice->address) >= 1)
                    {{$invoice->address[0]->post}}
                @else
                    -
                @endif
            </td>
            <td>
                {{$invoice->created_at}}
            </td>
            <td>
                @if(request()->is('/admin*')){
                    @foreach($invoice->payMeta as $item)
                        @if($item->product)
                            @if($loop->index != 0)
                                |---|
                            @endif
                            {{$item->product->title}}
                        @else
                        @endif
                    @endforeach
                @else
                    @foreach($invoice->myPayMeta()->where('cancel',0)->get() as $item)
                        @if($item->product)
                            @if($loop->index != 0)
                                |---|
                            @endif
                            {{$item->product->title}}
                        @else
                        @endif
                    @endforeach
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
