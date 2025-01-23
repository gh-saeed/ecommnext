<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request){
        $status = $request->status;
        $currentUrl = url()->current().'?status='.$request->status;
        if($status != 2 && $status != '' || $status === 0){
            $reports = Report::where('status' , $status)->latest()->paginate(30)->setPath($currentUrl);
        }else{
            $reports = Report::latest()->paginate(30)->setPath($currentUrl);
        }
        return view('admin.report.index' , compact('reports'));
    }
    public function edit(Report $report){
        return view('admin.report.edit' , compact('report'));
    }
    public function update(Report $report , Request $request){
        $request->validate([
            'body' => 'required',
        ]);
        $report->update([
            'data' => $request->body,
            'status' => $request->status,
        ]);
        return 'success';
    }
    public function delete(Report $report){
        $report->delete();
        return redirect()->back()->with([
            'message' => 'گزارش با موفقیت حذف شد'
        ]);
    }
}
