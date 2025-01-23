<?php

namespace App\Exports;

use App\Models\Product;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;

class PostExport implements FromCollection
{
    protected $invoices;

    public function __construct($invoices)
    {
        if ($invoices == 'allProduct'){
            $this->invoices = Product::all();
        }
        if ($invoices == 'todayProduct'){
            $this->invoices = Product::whereDate('created_at',Carbon::today())->get();
        }
    }

    public function collection()
    {
        return $this->invoices ;
    }
}
