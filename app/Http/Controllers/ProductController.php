<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Fragrance;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    // index
    public function index(Request $request)
    {
        // Get all products with pagination and search functionality
        $products = Product::when($request->input('name'), function ($query, $name) {
            $query->where('name', 'like', '%' . $name . '%');
        })->paginate(10);

        return view('pages.products.index', compact('products'));
    }


    // create
    public function create()
    {
        $categories = DB::table('categories')->get();
        $branches = Branch::all();
        return view('pages.products.create', compact('categories', 'branches'));
    }

    // store
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'description' => 'required',
                'price' => 'required|numeric',
                'category_id' => 'required',
                'branch_id' => 'required',
                'status' => 'required|boolean',
                'is_favorite' => 'required|boolean',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            DB::beginTransaction();

            $product = new Product;
            $product->fill($request->only(['name', 'description', 'price', 'category_id', 'status', 'is_favorite', 'branch_id']));

            if ($product->category->fragrances_status == Category::STATUS_FRAGRANCE) {
                $product->stock = 1;
            } else {
                $validator = Validator::make($request->all(), [
                    'stock' => 'required|numeric',
                ]);

                if ($validator->fails()) {
                    return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
                }

                $product->stock = $request->stock;
            }

            $l_file = '';
            if (isset($request->image)) {
                $s_file    = $request->file('image');
                $extention = $s_file->extension();
                $l_file    = $request->user_id."_".date('YmdHis').'.'.$extention;
                $s_file->move(public_path('upload/image'), $l_file);

                $product->image     = $l_file;
            }

            $product->save();

            if ($product->category->fragrances_status == Category::STATUS_FRAGRANCE) {
                $fragranceValidator = Validator::make($request->all(), [
                    'fragrances_name' => 'required',
                    'total_weight' => 'required',
                ]);

                if ($fragranceValidator->fails()) {
                    return redirect()->back()
                        ->withErrors($fragranceValidator)
                        ->withInput();
                }

                $fragrance = new Fragrance();
                $fragrance->name = $request->fragrances_name;
                $fragrance->total_weight = $request->total_weight;
                /*$fragrance->concentration = $request->concentration;
                $fragrance->gram = $request->gram;
                $fragrance->mililiter = $request->milliliter;
                $fragrance->pump_weight = $request->pump_weight;
                $fragrance->bottle_weight = $request->bottle_weight;*/
                $fragrance->product_id = $product->id;
                $fragrance->save();
            }
            DB::commit();

            return redirect()->route('products.index')->with('success', 'Product created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    // show
    public function show($id)
    {
        return view('pages.products.show');
    }

    // edit
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = DB::table('categories')->get();
        $branches = Branch::all();
        return view('pages.products.edit', compact('product', 'categories', 'branches'));
    }

    // update
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'description' => 'required',
                'price' => 'required|numeric',
                'category_id' => 'required',
                'branch_id' => 'required',
                'status' => 'required|boolean',
                'is_favorite' => 'required|boolean',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            DB::beginTransaction();
            $product = Product::find($id);
            $product->fill($request->only(['name', 'description', 'price', 'category_id', 'status', 'is_favorite', 'branch_id']));


            if ($product->category->fragrances_status == Category::STATUS_FRAGRANCE) {
                $product->stock = 1;
            } else {
                $validator = Validator::make($request->all(), [
                    'stock' => 'required|numeric',
                ]);

                if ($validator->fails()) {
                    return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
                }

                $product->stock = $request->stock;
            }

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imagePath = $image->storeAs('public/products', $product->id . '.' . $image->getClientOriginalExtension());
                $product->image = 'storage/' . $imagePath;
            }

            $product->save();

            $fragrance = Fragrance::where('product_id', $id)->first();
            if ($fragrance) {
                if ($product->category->fragrances_status == Category::STATUS_FRAGRANCE) {
                    $fragranceValidator = Validator::make($request->all(), [
                        //'fragrances_name' => 'required',
                        //'concentration' => 'required',
                        //'gram' => 'required',
                        //'milliliter' => 'required',
                        //'pump_weight' => 'required',
                        //'bottle_weight' => 'required',
                    ]);

                    if ($fragranceValidator->fails()) {
                        return redirect()->back()
                            ->withErrors($fragranceValidator)
                            ->withInput();
                    }


                    $fragrance->name = $request->fragrances_name;
                    $fragrance->concentration = $request->concentration;
                    $fragrance->gram = $request->gram;
                    $fragrance->mililiter = $request->milliliter;
                    $fragrance->pump_weight = $request->pump_weight;
                    $fragrance->bottle_weight = $request->bottle_weight;
                    $fragrance->total_weight = $request->total_weight;
                    $fragrance->product_id = $product->id;
                    $fragrance->save();
                } else {
                    $fragrance->delete();
                }
            }else{
                $fragrance = new Fragrance();
                $fragrance->name = $request->fragrances_name;
                $fragrance->total_weight = $request->total_weight;
                /*$fragrance->concentration = $request->concentration;
                $fragrance->gram = $request->gram;
                $fragrance->mililiter = $request->milliliter;
                $fragrance->pump_weight = $request->pump_weight;
                $fragrance->bottle_weight = $request->bottle_weight;*/
                $fragrance->product_id = $product->id;
                $fragrance->save();
            }

            DB::commit();

            return redirect()->route('products.index')->with('success', 'Product updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    // destroy
    public function destroy($id)
    {
        // delete the request...
        $product = Product::find($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }
}
