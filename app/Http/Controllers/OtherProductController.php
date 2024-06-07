<?php

namespace App\Http\Controllers;

use App\Models\OtherProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OtherProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = OtherProduct::paginate(10);
        return view('pages.other_product.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.other_product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            //validate the request...
            $validator = Validator::make($request->all(), [
                'product_name' => 'required',
                'product_price' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            //store the request...
            $data = new OtherProduct();
            $data->product_name = $request->product_name;
            $data->product_price = $request->product_price;
            $data->product_description = $request->product_description;

            $l_file = '';
            if (isset($request->image)) {
                $s_file    = $request->file('image');
                $extention = $s_file->extension();
                $l_file    = $request->user_id."_".date('YmdHis').'.'.$extention;
                $s_file->move(public_path('upload/image'), $l_file);

                $data->image     = $l_file;
            }

            $data->save();

            return redirect()->route('other_product.index')->with('success', 'Other Product created successfully');
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
        $data = OtherProduct::findOrFail($id);
        return view('pages.other_product.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // update the request...
        $data = OtherProduct::find($id);
        $data->product_name = $request->product_name;
        $data->product_price = $request->product_price;
        $data->product_description = $request->product_description;

        $l_file = '';
        if (isset($request->image)) {
            $s_file    = $request->file('image');
            $extention = $s_file->extension();
            $l_file    = $request->user_id."_".date('YmdHis').'.'.$extention;
            $s_file->move(public_path('upload/image'), $l_file);

            $data->image     = $l_file;
        }

        $data->save();
        return redirect()->route('other_product.index')->with('success', 'Other Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = OtherProduct::find($id);
        $data->delete();

        return redirect()->route('other_product.index')->with('success', 'Other Product deleted successfully');
    }
}
