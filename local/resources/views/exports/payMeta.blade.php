<table>
    <thead>
    <tr>
        <th>محصول</th>
        <th>شماره سفارش</th>
        <th>رنگ</th>
        <th>سایز</th>
        <th>مبلغ سفارش</th>
        <th>وضعیت انصراف</th>
        <th>هزینه ارسال</th>
        <th>نوع ارسال</th>
        <th>نام کاربر</th>
        <th>شماره کاربر</th>
        <th>استان کاربر</th>
        <th>شهر کاربر</th>
        <th>آدرس کاربر</th>
        <th>کد پستی</th>
    </tr>
    </thead>
    <tbody>
    @foreach($invoices as $invoice)
        <tr>
            <td>
                {{$invoice->product->title}}
            </td>
            <td>
                {{$invoice->pay->property}}
            </td>
            <td>
                {{$invoice->color}}
            </td>
            <td>
                {{$invoice->size}}
            </td>
            <td>
                {{$invoice->price}}
            </td>
            <td>
                @if($invoice->cancel)
                    لغو شده
                @else
                    لغو نشده
                @endif
            </td>
            <td>
                {{$invoice->carrier_price}}
            </td>
            <td>
                {{$invoice->carrier_name}}
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
        </tr>
    @endforeach
    </tbody>
</table>
