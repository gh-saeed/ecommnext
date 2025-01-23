<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Field;
use App\Models\FieldData;
use App\Models\Product;
use App\Models\User;
use App\Models\View;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request){
        $title = $request->title;
        $currentUrl = url()->current().'?title='.$title;
        if($request->title){
            $users = User::where(function ($query) use($title) {
                $query->where('name' , "LIKE" , "%{$title}%")
                    ->orWhere('number', $title)
                    ->orWhere('email', $title)
                    ->orWhere('id', $title);
            })->withCount(['wallet as walletUp' => function ($q) {
                $q->where('type' , 0)->select(DB::raw('sum(price)'));
            }])->withCount(['wallet as walletDown' => function ($q) {
                $q->where('type' , 1)->select(DB::raw('sum(price)'));
            }])->withCount(['pay' => function ($q) {
                $q->whereIn('status' , [100,20,50])->select(DB::raw('sum(price)'));
            }])->latest()->paginate(50)->setPath($currentUrl);
        }else{
            $users = User::withCount(['wallet as walletUp' => function ($q) {
                $q->where('status' , 100)->where('type' , 0)->select(DB::raw('sum(price)'));
            }])->withCount(['wallet as walletDown' => function ($q) {
                $q->where('status' , 100)->where('type' , 1)->select(DB::raw('sum(price)'));
            }])->withCount(['pay' => function ($q) {
                $q->whereIn('status' , [100,20,50])->select(DB::raw('sum(price)'));
            }])->latest()->paginate(50)->setPath($currentUrl);
        }
        return view('admin.user.index',compact('users','title'));
    }
    public function create(){
        $roles = Role::latest()->get();
        $permissions = Permission::latest()->get();
        return view('admin.user.create',compact('roles','permissions'));
    }
    public function edit(User $user){
        $users = User::where('id' , $user->id)->with('roles','permissions')->first();
        $roles = Role::latest()->get();
        $permissions = Permission::latest()->get();
        return view('admin.user.edit',compact('roles','permissions' , 'users'));
    }
    public function show(User $user){
        $views = View::latest()->where('user_id' , $user->id)->get();
        return view('admin.user.show',compact('views'));
    }
    public function update(User $user , Request $request){
        $request->validate([
            'name' => 'required',
        ]);
        $user->update([
            'name'=> $request->name,
            'email'=> $request->email,
            'number'=> $request->number,
            'admin'=> $request->admin,
            'suspension'=> $request->suspension,
            'password'=> $request->password ? Hash::make($request->password) : $user->password,
            'updated_at'=> Carbon::now(),
        ]);
        if($request->suspension){
            Product::where('user_id',$user->id)->update([
                'status' => 0
            ]);
        }
        if($request->role){
            $user->removeRole($request->role);
            $user->syncRoles($request->role);
        }
        if($request->permissions){
            foreach ($user->permissions as $permission) {
                $user->revokePermissionTo($permission->name);
            }
            foreach ($request->permissions as $permission) {
                $user->givePermissionTo($permission);
            }
        }
        return redirect('/admin/user')->with([
            'message' => 'کاربر '. $request->name .' با موفقیت ویرایش شد'
        ]);
    }
    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'password' => 'required',
        ]);
        $code = User::buildCode();
        $user = User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'number'=> $request->number,
            'suspension'=> $request->suspension,
            'referral'=> $code,
            'admin'=> $request->admin,
            'password'=> Hash::make($request->password),
        ]);
        if($request->role){
            $user->syncRoles($request->role);
        }
        if($request->permissions){
            foreach ($request->permissions as $permission) {
                $user->givePermissionTo($permission);
            }
        }
        return redirect('/admin/user')->with([
            'message' => 'کاربر '. $request->name .' با موفقیت اضافه شد'
        ]);
    }
    public function delete(User $user){
        $user->comments()->delete();
        $user->cart()->delete();
        $user->report()->delete();
        $user->ticket()->delete();
        $user->document()->delete();
        $user->permissions()->detach();
        $user->roles()->detach();
        $user->product()->update([
            'status' => 0,
        ]);
        $user->delete();
        return redirect()->back()->with([
            'message' => 'کاربر با موفقیت حذف شد'
        ]);
    }
}
