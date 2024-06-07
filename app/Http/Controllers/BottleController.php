<?php

namespace App\Http\Controllers;

use App\Models\Bottle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BottleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Bottle::paginate(10);
        return view('pages.bottle.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.bottle.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            //validate the request...
            $validator = Validator::make($request->all(), [
                'bottle_name' => 'required',
                'bottle_size' => 'required',
                'bottle_type' => 'required',
                'harga_ml' => 'required',
                'variant' => 'required'
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            //store the request...
            $data = new Bottle();
            $data->bottle_name = $request->bottle_name;
            $data->bottle_size = $request->bottle_size;
            $data->bottle_type = $request->bottle_type;
            $data->harga_ml = $request->harga_ml;
            $data->variant = $request->variant;

            $data->save();

            return redirect()->route('bottle.index')->with('success', 'Bottle created successfully');
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
        $data = Bottle::findOrFail($id);
        return view('pages.bottle.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // update the request...
        $data = Bottle::find($id);
        $data->bottle_name = $request->bottle_name;
        $data->bottle_size = $request->bottle_size;
        $data->bottle_type = $request->bottle_type;
        $data->harga_ml = $request->harga_ml;
        $data->variant = $request->variant;
        $data->save();
        return redirect()->route('bottle.index')->with('success', 'Bottle updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Bottle::find($id);
        $data->delete();

        return redirect()->route('bottle.index')->with('success', 'Bottle deleted successfully');
    }
}
