<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    //index
    public function index(Request $request)
    {
        //get all users with pagination
        $users = User::with('branch') // Memuat relasi
            ->when($request->input('name'), function ($query, $name) {
                $query->where('name', 'like', '%' . $name . '%')
                    ->orWhere('email', 'like', '%' . $name . '%');
            })
            ->paginate(10);

        return view('pages.users.index', compact('users'));
    }

    //create
    public function create()
    {
        $branch = Branch::get();
        return view('pages.users.create', compact('branch'));
    }

    //store
    public function store(Request $request)
    {
        //validate the request
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'branch' => 'required',
            'role' => 'required|in:admin,user',
        ]);

        //store the request
        $user = new User;
        $user->name = $request -> name;
        $user->email = $request -> email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        if(!empty($request->branch_id)){
            $user->branch_id = $request->branch_id;
        }
        dd($user);
        $user->save();
        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    //show
    public function show($id)
    {
        return view('pages.users.show');
    }

    //edit
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $branch = Branch::get();
        return view('pages.users.edit', compact('user','branch'));
    }

    //update
    public function update(Request $request, $id)
    {
        //validate the request...
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required|in:admin,staff,user',
        ]);

        // update the request...
        $user = User::find($id);
        $user->name = $request ->name;
        $user->email = $request ->email;
        $user->role = $request->role;
        if(!empty($request->branch_id)){
            $user->branch_id = $request->branch_id;
        }
        // if password is not empty
        if ($request->password){
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    //destroy
    public function destroy($id)
    {
        // delete the request...
        $user = User::find($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}
