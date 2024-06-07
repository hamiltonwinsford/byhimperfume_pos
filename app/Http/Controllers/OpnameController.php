<?php

namespace App\Http\Controllers;

use App\Models\Opname;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OpnameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Opname::join('products','products.id','product_id')->select('opname.*','products.name')->paginate(10);
        return view('pages.opname.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $product = Product::get();
        return view('pages.opname.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            //validate the request...
            $validator = Validator::make($request->all(), [
                'product_id' => 'required',
                'stock' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            //store the request...
            $data = new Opname();
            $data->product_id = $request->product_id;
            $data->g_to_ml = $request->g_to_ml;
            $data->ml_to_g = $request->ml_to_g;

            $data->save();

            return redirect()->route('opname.index')->with('success', 'Data created successfully');
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
        $data = Opname::findOrFail($id);
        $product = Product::get();
        return view('pages.opname.edit', compact('data','product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // update the request...
        $data = Opname::find($id);
        $data->product_id = $request->product_id;
        $data->g_to_ml = $request->g_to_ml;
        $data->ml_to_g = $request->ml_to_g;
        $data->save();
        return redirect()->route('opname.index')->with('success', 'Data updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Opname::find($id);
        $data->delete();

        return redirect()->route('opname.index')->with('success', 'Data deleted successfully');
    }
}
