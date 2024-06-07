<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promotion;
use Illuminate\Support\Facades\Validator;

class PromotionsController extends Controller
{
    //index
    public function index()
    {
        $data = Promotion::paginate(10);
        return view('pages.promotions.index', compact('data'));
    }

    //create
    public function create()
    {
        return view('pages.promotions.create');
    }

    //store
    public function store(Request $request)
    {
        try {
            //validate the request...
            $validator = Validator::make($request->all(),[
                'name' => 'required',
                'description' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'discount_percent' => 'required',
            ]);

            if($validator->fails()){
                return redirect()->back()
                ->withErrors($validator)
                ->withInput();
            }

            //store the request...
            $data = new Promotion;
            $data->name = $request->name;
            $data->description = $request->description;
            $data->start_date = $request->start_date;
            $data->end_date = $request->end_date;
            $data->discount_percent= $request->discount_percent;

            $data->save();

            return redirect()->route('promotions.index')->with('success', 'Promotions created successfully');
        } catch (\Exception $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }

    }

    //show
    public function show($id)
    {
        return view('pages.promotions.show');
    }

    //edit
    public function edit($id)
    {
        $data = Promotion::find($id);
        return view('pages.promotions.edit', compact('data'));
    }

    //update
    public function update(Request $request, $id)
    {
        //validate the request...
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'discount_percent' => 'required',
        ]);

        //update the request...
        $data = Promotion::find($id);
        $data->name = $request->name;
        $data->description = $request->description;
        $data->start_date = $request->start_date;
        $data->end_date = $request->end_date;
        $data->discount_percent= $request->discount_percent;

        $data->save();
        return redirect()->route('promotions.index')->with('success', 'Promotions updated successfully');
    }

    //destroy
    public function destroy($id)
    {
        try {
            //code...
            //delete the request...
            $data = Promotion::find($id);
            $data->delete();
            return redirect()->route('promotions.index')->with('success', 'Promotions deleted successfully');
        } catch (\Throwable $th) {
            //throw $th;
            if($th->errorInfo[1]===1451){
                return redirect()->back()->with('error', 'Terdapat produk dengan Promotions ini!, Silahkan hapus produk terlebih dahulu');
            }
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
