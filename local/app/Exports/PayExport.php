<?php

namespace App\Exports;

use App\Models\Pay;
use App\Models\PayMeta;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PayExport implements FromView
{
    protected $invoices;

    public function __construct($invoices, $pay)
    {
        if(request()->is('/admin*')){
            if ($invoices == 'allPay'){
                $this->invoices = Pay::get();
            }
            if ($invoices == 'todayPay'){
                $this->invoices = Pay::whereDate('created_at',Carbon::today())->get();
            }
        }else{
            if ($invoices == 'allPay'){
                $this->invoices = Pay::whereHas('myPayMeta')->get();
            }
            if ($invoices == 'todayPay'){
                $this->invoices = Pay::whereHas('myPayMeta')->whereDate('created_at',Carbon::today())->get();
            }
        }
    }

    public function view(): View
    {
        $invoices = $this->invoices;
        return view('exports.pay',compact('invoices'));
    }
}
