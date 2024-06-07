<?php

namespace App\Http\Controllers;

use App\Models\Seed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SeedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $seed = Seed::paginate(10);
        return view('pages.seed.index', compact('seed'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.seed.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            //validate the request...
            $validator = Validator::make($request->all(), [
                'seed_code' => 'required',
                'seed_name' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            //store the request...
            $data = new Seed();
            $data->seed_code = $request->seed_code;
            $data->seed_name = $request->seed_name;
            $data->descriptions = $request->descriptions;
            $data->density = $request->density;
            $data->dispenser_weight = $request->dispenser_weight;
            $data->total_ml = $request->total_ml;
            $data->total_gram = $request->total_gram;

            $data->save();

            return redirect()->route('seeds.index')->with('success', 'Seed created successfully');
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
        $data = Seed::findOrFail($id);
        return view('pages.seed.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // update the request...
        $data = Seed::find($id);
        $data->seed_code = $request->seed_code;
        $data->seed_name = $request->seed_name;
        $data->descriptions = $request->descriptions;
        $data->density = $request->density;
        $data->dispenser_weight = $request->dispenser_weight;
        $data->total_ml = $request->total_ml;
        $data->total_gram = $request->total_gram;
        $data->save();
        return redirect()->route('seeds.index')->with('success', 'Seed updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Seed::find($id);
        $data->delete();

        return redirect()->route('seeds.index')->with('success', 'Seed deleted successfully');
    }
}
