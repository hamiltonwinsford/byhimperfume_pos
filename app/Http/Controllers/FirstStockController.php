<?php

namespace App\Http\Controllers;

use App\Models\FirstStock;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FirstStockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = FirstStock::join('products','products.id','product_id')->select('first_stock.*','products.name')->paginate(10);
        return view('pages.first_stock.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $product = Product::get();
        return view('pages.first_stock.create', compact('product'));
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
            $data = new FirstStock();
            $data->product_id = $request->product_id;
            $data->stock = $request->stock;

            $data->save();

            return redirect()->route('first_stock.index')->with('success', 'Data created successfully');
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
        $data = FirstStock::findOrFail($id);
        $product = Product::get();
        return view('pages.first_stock.edit', compact('data','product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // update the request...
        $data = FirstStock::find($id);
        $data->product_id = $request->product_id;
        $data->stock = $request->stock;
        $data->save();
        return redirect()->route('first_stock.index')->with('success', 'Data updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = FirstStock::find($id);
        $data->delete();

        return redirect()->route('first_stock.index')->with('success', 'Data deleted successfully');
    }
}
