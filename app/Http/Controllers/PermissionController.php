<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    //index
    public function index()
    {
        return view('pages.role-permission.permission.index');
    }

    //create
    public function create()
    {
        return view('pages.role-permission.permission.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => [
                'required',
                'unique:permissions,name'
            ],
        ]);

        Permission::create([
            'name' => $request->name
        ]);

        return redirect('permission')->with('status','Permission created successfully');
    }

    //update
    public function update()
    {
        return view('pages.role-permission.permission.update');
    }

    //delete
    public function destroy()
    {
        return view('');
    }
}
