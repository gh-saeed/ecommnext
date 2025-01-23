<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Company;
use App\Models\Document;
use App\Models\Genuine;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SellerController extends Controller
{
    public function index(Request $request){
        $title = $request->title;
        $currentUrl = url()->current().'?title='.$title;
        if($request->title){
            $users = User::whereHas('document', function ($qs) {
                $qs->where('status',2);
            })->latest()->paginate(50)->setPath($currentUrl);
        }else{
            $users = User::whereHas('document', function ($qs) {
                $qs->where('status',2);
            })->with(['document' => function ($q) {
                $q->where('status' , 2);
            }])->latest()->paginate(50)->setPath($currentUrl);
        }
        return view('admin.seller.index',compact('users' , 'title'));
    }
    public function document(){
        $documents = Document::with('user')->paginate(50);
        return view('admin.seller.document',compact('documents'));
    }
    public function edit(Document $document){
        $documents = Document::latest()->where('id',$document->id)->with(["user" => function($q){
            $q->with('genuine' , 'company','category');
        }])->first();
        $category = Category::where('type' , 2)->select(['name','id'])->get();
        return view('admin.seller.edit',compact('documents','category'));
    }
    public function deleteDoc(Document $document){
        $document->delete();
        return redirect()->back()->with([
            'message' => 'مدرک پاک شد'
        ]);
    }
    public function update(Request $request , Document $document){
        $user = User::where('id' , $document->user_id)->first();
        $request->validate([
            'name' => 'required|unique:users,name,'.$user->id.',id',
            'slug' => 'required|unique:users,slug,'.$user->id.',id',
        ]);
        $document->update([
            'status' => $request->status
        ]);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'number' => $request->number,
            'slug' => $request->slug,
            'seller' => $request->seller,
            'city' => $request->city1,
            'state' => $request->state1,
        ]);
        if ($request->seller == 2){
            if ($user->company){
                $user->company()->update([
                    'name' => $request->companyName,
                    'type' => $request->type,
                    'registration' => $request->registrationNumber,
                    'NationalID' => $request->nationalID,
                    'economicCode' => $request->economicCode,
                    'signer' => $request->signatureOwners,
                    'residenceAddress' => $request->residenceAddress,
                ]);
            }
            else{
                Company::create([
                    'name' => $request->companyName,
                    'type' => $request->type,
                    'registration' => $request->registrationNumber,
                    'NationalID' => $request->nationalID,
                    'economicCode' => $request->economicCode,
                    'signer' => $request->signatureOwners,
                    'residenceAddress' => $request->residenceAddress,
                    'user_id' => $user->id,
                ]);
            }
        }
        elseif($request->seller == 1){
            if ($user->genuine){
                $user->genuine()->update([
                    'name'=>$request->firstName,
                    'post'=>$request->post,
                    'gender'=>$request->gender,
                    'landlinePhone'=>$request->landlinePhone,
                    'code'=>$request->code,
                    'residenceAddress' => $request->residenceAddress,
                ]);
            }
            else{
                $userMeta = Genuine::create([
                    'name'=>$request->name,
                    'post'=>$request->post,
                    'landlinePhone'=>$request->landlinePhone,
                    'gender'=>$request->gender,
                    'code'=>$request->code,
                    'residenceAddress' => $request->residenceAddress,
                    'user_id' => auth()->user()->id
                ]);
            }
        }
        Auth::user()->category()->detach();
        Auth::user()->category()->sync($request->category);
        return redirect('/admin/sellers')->with([
            'message' => 'با موفقیت ثبت شد.'
        ]);
    }

    public function delete(User $user){
        $user->revokePermissionTo('فروشنده');
        return redirect()->back()->with([
            'message' => 'کاربر '.$user->name.' با موفقیت از بخش فروشندگان حذف شد.'
        ]);
    }
}
