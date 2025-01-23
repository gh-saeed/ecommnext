<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Counseling;
use App\Models\News;
use App\Models\Pay;
use App\Models\PayMeta;
use App\Models\Product;
use App\Models\Report;
use App\Models\Ticket;
use App\Models\User;
use App\Models\View;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PanelController extends Controller
{
    public function index(){
        $startDayEn = verta()->startDay()->formatGregorian('Y-m-d H:i:s');
        $endDayEn = verta()->endDay()->formatGregorian('Y-m-d H:i:s');
        $todayUser = User::whereBetween('created_at', [$startDayEn, $endDayEn])->count();
        $allPay = Pay::where('status' , 100)->count();
        $todayPay = PayMeta::whereBetween('created_at', [$startDayEn, $endDayEn])->where('status' , 100)->count();
        $allComment = Report::whereBetween('created_at', [$startDayEn, $endDayEn])->count();
        $todayComment = Comment::whereBetween('created_at', [$startDayEn, $endDayEn])->count();
        $allEmpty = Product::where('count' , 0)->count();
        $allIncome = PayMeta::whereBetween('created_at', [$startDayEn, $endDayEn])->where('status' , 100)->sum('price');
        $allView = View::count();
        $todayView = View::whereBetween('created_at', [$startDayEn, $endDayEn])->count();

        $year2 =verta()->year;
        $farvardin = Verta::parse($year2 . ' فروردین 1')->formatGregorian('Y-m-d H:i:s');
        $ordibehesht = Verta::parse($year2 . ' اردیبهشت 1')->formatGregorian('Y-m-d H:i:s');
        $khordad = Verta::parse($year2 . ' خرداد 1')->formatGregorian('Y-m-d H:i:s');
        $tir = Verta::parse($year2 . ' تیر 1')->formatGregorian('Y-m-d H:i:s');
        $mordad = Verta::parse($year2 . ' مرداد 1')->formatGregorian('Y-m-d H:i:s');
        $shahrivar = Verta::parse($year2 . ' شهریور 1')->formatGregorian('Y-m-d H:i:s');
        $mehr = Verta::parse($year2 . ' مهر 1')->formatGregorian('Y-m-d H:i:s');
        $aban = Verta::parse($year2 . ' آبان 1')->formatGregorian('Y-m-d H:i:s');
        $azar = Verta::parse($year2 . ' آذر 1')->formatGregorian('Y-m-d H:i:s');
        $dey = Verta::parse($year2 . ' دی 1')->formatGregorian('Y-m-d H:i:s');
        $bahman = Verta::parse($year2 . ' بهمن 1')->formatGregorian('Y-m-d H:i:s');
        $esfand = Verta::parse($year2 . ' اسفند 1')->formatGregorian('Y-m-d H:i:s');

        $deyPay = PayMeta::whereBetween('created_at', [$dey, $bahman])->where('status' , 100)->where('cancel',1)->sum('price');
        $bahmanPay = PayMeta::whereBetween('created_at', [$bahman, $esfand])->where('status' , 100)->where('cancel',1)->sum('price');
        $esfandPay = PayMeta::whereBetween('created_at', [$esfand, $farvardin])->where('status' , 100)->where('cancel',1)->sum('price');
        $farvardinPay = PayMeta::whereBetween('created_at', [$farvardin, $ordibehesht])->where('status' , 100)->where('cancel',1)->sum('price');
        $ordibeheshtPay = PayMeta::whereBetween('created_at', [$ordibehesht, $khordad])->where('status' , 100)->where('cancel',1)->sum('price');
        $khordadPay = PayMeta::whereBetween('created_at', [$khordad, $tir])->where('status' , 100)->where('cancel',1)->sum('price');
        $tirPay = PayMeta::whereBetween('created_at', [$tir, $mordad])->where('status' , 100)->where('cancel',1)->sum('price');
        $mordadPay = PayMeta::whereBetween('created_at', [$mordad, $shahrivar])->where('status' , 100)->where('cancel',1)->sum('price');
        $shahrivarPay = PayMeta::whereBetween('created_at', [$shahrivar, $mehr])->where('status' , 100)->where('cancel',1)->sum('price');
        $mehrPay = PayMeta::whereBetween('created_at', [$mehr, $aban])->where('status' , 100)->where('cancel',1)->sum('price');
        $abanPay = PayMeta::whereBetween('created_at', [$aban, $azar])->where('status' , 100)->where('cancel',1)->sum('price');
        $azarPay = PayMeta::whereBetween('created_at', [$azar, $dey])->where('status' , 100)->where('cancel',1)->sum('price');


        $taskChart0 = PayMeta::where('cancel' ,0)->count();
        $taskChart2 = PayMeta::where('cancel' ,1)->count();
        $projectChart0 = PayMeta::where('deliver' ,1)->count();
        $projectChart1 = PayMeta::where('deliver' ,2)->count();
        $projectChart2 = PayMeta::where('deliver' ,3)->count();
        $projectChart3 = PayMeta::where('deliver' ,4)->count();

        $statusProduct0 = Product::where('count' , '>=' , 10)->count();
        $statusProduct1 = Product::whereBetween('count', [1, 10])->count();
        $statusProduct2 = Product::where('count' , 0)->count();

        return view('admin.panel',compact(
            'todayUser',
            'allPay',
            'todayPay',
            'allComment',
            'todayComment',
            'allEmpty',
            'allIncome',
            'allView',
            'todayView',
            'deyPay',
            'bahmanPay',
            'esfandPay',
            'farvardinPay',
            'ordibeheshtPay',
            'khordadPay',
            'tirPay',
            'mordadPay',
            'shahrivarPay',
            'mehrPay',
            'abanPay',
            'azarPay',
            'taskChart0',
            'taskChart2',
            'projectChart0',
            'projectChart1',
            'projectChart2',
            'projectChart3',
            'statusProduct0',
            'statusProduct1',
            'statusProduct2',
        ));
    }
    public function online(){
        $pages = Cache::has('user-check')?Cache::get('user-check'):[];
        return view('admin.online',compact('pages'));
    }
    public function checkUser(){
        return Cache::has('user-check')?array_reverse(Cache::get('user-check')):[];
    }
    public function learn(){
        return view('admin.learn');
    }
    public function update(){
        return view('admin.update');
    }
}
