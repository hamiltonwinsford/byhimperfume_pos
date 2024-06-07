<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PromotionBundle;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class PromotionBundleController extends Controller
{
    //index
    public function index()
    {
        $data = PromotionBundle::join('products as a','a.id','product_id')->join('products as b','b.id','other_product_id')->select('promotion_bundle.*','a.name as name_product_a','b.name as name_product_b')->paginate(10);
        return view('pages.promotionBundle.index', compact('data'));
    }

    //create
    public function create()
    {   
        $product = Product::get();
        return view('pages.promotionBundle.create', compact('product'));
    }

    //store
    public function store(Request $request)
    {
        //store the request...
        $data = new PromotionBundle;
        $data->name_promotion = $request->name_promotion;
        $data->product_id = $request->product_id;
        $data->other_product_id = $request->other_product_id;
        $data->price = $request->price;
        $data->from_date= $request->from_date;
        $data->to_date= $request->to_date;
        $data->save();

        if($data->save()){
            return redirect()->route('promotionBundle.index')->with('success', 'Promotions created successfully');
        }else{
            return redirect()->back()->with('error', 'Promotions created failded!');
        }

    }

    //show
    public function show($id)
    {
        return view('pages.promotionBundle.show');
    }

    //edit
    public function edit($id)
    {
        $data = PromotionBundle::find($id);
        $product = Product::get();
        return view('pages.promotionBundle.edit', compact('data','product'));
    }

    //update
    public function update(Request $request, $id)
    {
        //update the request...
        $data = PromotionBundle::find($id);
            $data->name_promotion = $request->name_promotion;
            $data->product_id = $request->product_id;
            $data->other_product_id = $request->other_product_id;
            $data->price = $request->price;
            $data->from_date= $request->from_date;
            $data->to_date= $request->to_date;

        $data->save();
        if($data->save()){
            return redirect()->route('promotionBundle.index')->with('success', 'Promotions created successfully');
        }else{
            return redirect()->back()->with('error', 'Promotions created failded!');
        }
    }

    //destroy
    public function destroy($id)
    {
        $data = PromotionBundle::find($id);
        $data->delete();
        return redirect()->route('promotionBundle.index')->with('success', 'Promotions deleted successfully');
    }
}
