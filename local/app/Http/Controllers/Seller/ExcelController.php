<?php

namespace App\Http\Controllers\Seller;

use App\Exports\CommentExport;
use App\Exports\NewsExport;
use App\Exports\PayExport;
use App\Exports\PayMetaExport;
use App\Exports\PostExport;
use App\Exports\UserExport;
use App\Http\Controllers\Controller;
use App\Imports\BlogImport;
use App\Imports\ProductImport;
use App\Imports\UserImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function index(){
        return view('seller.excel.index');
    }
    public function import(){
        return view('seller.excel.import');
    }
    public function import_product(Request $request){
        $file = $request->image;
        $import = new ProductImport();
        Excel::import($import, $file);
        return 'success';
    }
    public function getExcel($data , Request $request){
        if($data == 'seller'){
            return Excel::download(new UserExport('seller' , $request->seller), 'seller.xlsx');
        }
        if($data == 'pay'){
            return Excel::download(new PayExport('pay' , $request->pay), 'pay.xlsx');
        }
        if($data == 'allPay'){
            return Excel::download(new PayExport('allPay',''), 'pays.xlsx');
        }
        if($data == 'todayPay'){
            return Excel::download(new PayExport('todayPay',''), 'todayPays.xlsx');
        }
        if($data == 'allPayMeta'){
            return Excel::download(new PayMetaExport('allPayMeta',''), 'payMetas.xlsx');
        }
        if($data == 'todayPayMeta'){
            return Excel::download(new PayMetaExport('todayPayMeta',''), 'todayPayMetas.xlsx');
        }
        if($data == 'allProduct'){
            return Excel::download(new PostExport('allProduct',''), 'products.xlsx');
        }
        if($data == 'todayProduct'){
            return Excel::download(new PostExport('todayProduct',''), 'todayProducts.xlsx');
        }
    }
}
