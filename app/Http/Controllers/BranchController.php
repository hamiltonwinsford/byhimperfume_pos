<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $branches = Branch::paginate(10);
        return view('pages.branches.index', compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.branches.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            //validate the request...
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'address' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            //store the request...
            $category = new Branch();
            $category->name = $request->name;
            $category->address = $request->address;

            $category->save();

            return redirect()->route('branches.index')->with('success', 'Branch created successfully');
        } catch (\Exception $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Branch::findOrFail($id);
        return view('pages.branches.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // update the request...
        $data = Branch::find($id);
        $data->name = $request->name;
        $data->address = $request->address;
        $data->save();
        return redirect()->route('branches.index')->with('success', 'Branch updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Branch::find($id);
        $data->delete();
        return redirect()->route('branches.index')->with('success', 'Branch deleted successfully');
    }
}
