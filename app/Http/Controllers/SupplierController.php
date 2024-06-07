<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Supplier::paginate(10);
        return view('pages.supplier.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            //validate the request...
            $validator = Validator::make($request->all(), [
                'name_supplier' => 'required',
                'no_telp_supplier' => 'required',
                'address_supplier' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            //store the request...
            $data = new Supplier();
            $data->name_supplier = $request->name_supplier;
            $data->no_telp_supplier = $request->no_telp_supplier;
            $data->address_supplier = $request->address_supplier;

            $data->save();

            return redirect()->route('supplier.index')->with('success', 'Supplier created successfully');
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
        $data = Supplier::findOrFail($id);
        return view('pages.supplier.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // update the request...
        $data = Supplier::find($id);
        $data->name_supplier = $request->name_supplier;
        $data->no_telp_supplier = $request->no_telp_supplier;
        $data->address_supplier = $request->address_supplier;
        $data->save();
        return redirect()->route('supplier.index')->with('success', 'Supplier updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Supplier::find($id);
        $data->delete();

        return redirect()->route('supplier.index')->with('success', 'Supplier deleted successfully');
    }
}
