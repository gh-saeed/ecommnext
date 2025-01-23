<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index(Request $request){
        $title = $request->title;
        $currentUrl = url()->current().'?title='.$title;
        if($title){
            $roles = Role::where(function ($query) use($title) {
                $query->where('name', $title)
                    ->orWhere('id', $title);
            })->select(['name' , 'id'])->latest()->paginate(50)->setPath($currentUrl);
        }else{
            $roles = Role::select(['name' , 'id'])->latest()->paginate(50)->setPath($currentUrl);
        }
        return view('admin.taxonomy.index.role' , compact('roles','title'));
    }
    public function store(Request $request){
        $request->validate([
            'name' => 'required|max:220',
        ]);
        $post = Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);
        return redirect()->back()->with([
            'message' => 'مقام با موفقیت اضافه شد'
        ]);
    }
    public function edit(Role $role){
        return $role;
    }
    public function update(Role $role , Request $request){
        $request->validate([
            'name' => 'required|max:220',
        ]);
        $role->update([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);
        return redirect()->back()->with([
            'message' => 'مقام ' . $request->name . ' با موفقیت ویرایش شد'
        ]);
    }
    public function delete(Role $role){
        $role->users()->detach();
        $role->delete();
        return redirect()->back()->with([
            'message' => 'مقام با موفقیت حذف شد'
        ]);
    }
}
