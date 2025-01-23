<?php

namespace App\Exports;

use App\Models\PayMeta;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PayMetaExport implements FromView
{
    protected $invoices;

    public function __construct($invoices)
    {
        if(request()->is('/admin*')){
            if ($invoices == 'allPayMeta'){
                $this->invoices = PayMeta::has('product')->get();
            }
            if ($invoices == 'todayPayMeta'){
                $this->invoices = PayMeta::has('product')->whereDate('created_at',Carbon::today())->get();
            }
        }else{
            $products = Product::where('user_id',auth()->id())->pluck('id');
            if ($invoices == 'allPayMeta'){
                $this->invoices = PayMeta::has('product')->whereIn('product_id',$products)->get();
            }
            if ($invoices == 'todayPayMeta'){
                $this->invoices = PayMeta::has('product')->whereIn('product_id',$products)->whereDate('created_at',Carbon::today())->get();
            }
        }
    }

    public function view(): View
    {
        $invoices = $this->invoices;
        return view('exports.payMeta',compact('invoices'));
    }
}
