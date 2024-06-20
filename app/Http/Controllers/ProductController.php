<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Fragrance;
use App\Models\StockCard;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductImport;

class ProductController extends Controller
{
    // index
    public function index(Request $request)
    {
        if(empty($request->branch_id)){
            $products = Product::get();

        }else{
            $products = Product::where('branch_id', $request->branch_id)->get();
        }
        $branches = Branch::all();
        return view('pages.products.index', compact('products','branches'));
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
                $fragrance->gram_to_ml = $request->gram_to_ml;
                $fragrance->ml_to_gram = $request->ml_to_gram;
                $fragrance->gram = $request->gram;
                $fragrance->mililiter = $request->milliliter;
                $fragrance->pump_weight = $request->pump_weight;
                $fragrance->bottle_weight = $request->bottle_weight;
                $fragrance->product_id = $product->id;
                $fragrance->save();

                // Insert into StockCard table
                $stockCard = new StockCard;
                $stockCard->product_id = $product->id;
                $stockCard->branch_id = $request->branch_id;
                $stockCard->fragrance_id = $fragrance->id;
                $stockCard->opening_stock_gram = $request->gram;
                $stockCard->save();
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
        //return view('pages.products.show');
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
                $s_file = $request->file('image');
                $extension = $s_file->getClientOriginalExtension();
                $l_file = $request->user_id . "_" . date('YmdHis') . '.' . $extension;
                $s_file->move(public_path('upload/image'), $l_file);

                $product->image = 'upload/image/' . $l_file;
            }

            $product->save();

            $fragrance = Fragrance::where('product_id', $id)->first();
            if ($fragrance) {
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

                    $fragrance->name = $request->fragrances_name;
                    $fragrance->gram_to_ml = $request->gram_to_ml;
                    $fragrance->ml_to_gram = $request->ml_to_gram;
                    $fragrance->gram = $request->gram;
                    $fragrance->mililiter = $request->milliliter;
                    $fragrance->pump_weight = $request->pump_weight;
                    $fragrance->bottle_weight = $request->bottle_weight;
                    $fragrance->total_weight = $request->total_weight;
                    $fragrance->product_id = $product->id;
                    $fragrance->save();

                    // Insert into StockCard table
                    $stockCard = new StockCard;
                    $stockCard->product_id = $product->id;
                    $stockCard->branch_id = $request->branch_id;
                    $stockCard->fragrance_id = $fragrance->id;
                    $stockCard->opening_stock_gram = $request->gram;
                    $stockCard->save();

                } else {
                    $fragrance->delete();
                }
            } else {
                $fragrance = new Fragrance();
                $fragrance->name = $request->fragrances_name;
                $fragrance->total_weight = $request->total_weight;
                $fragrance->gram_to_ml = $request->gram_to_ml;
                $fragrance->ml_to_gram = $request->ml_to_gram;
                $fragrance->gram = $request->gram;
                $fragrance->mililiter = $request->milliliter;
                $fragrance->pump_weight = $request->pump_weight;
                $fragrance->bottle_weight = $request->bottle_weight;
                $fragrance->product_id = $product->id;
                $fragrance->save();

                // Insert into StockCard table
                $stockCard = new StockCard;
                $stockCard->product_id = $product->id;
                $stockCard->branch_id = $request->branch_id;
                $stockCard->fragrance_id = $fragrance->id;
                $stockCard->opening_stock_gram = $request->gram;
                $stockCard->save();
            }

            DB::commit();

            return redirect()->route('products.index')->with('success', 'Product updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    // import products
    public function importForm()
    {
        return view('products.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx',
        ]);

        try {
            Excel::import(new ProductImport, $request->file('file'));
            return redirect()->route('products.index')->with('success', 'Products imported successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error importing products: ' . $e->getMessage());
        }
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function destroy($id)
    {
        // Cari produk berdasarkan id
        $product = Product::find($id);

        if ($product) {
            // Hapus semua baris terkait di tabel fragrances
            DB::table('fragrances')->where('product_id', $id)->delete();

            // Hapus produk
            $product->delete();

            return redirect()->route('products.index')->with('success', 'Product deleted successfully');
        }

        return redirect()->route('products.index')->with('error', 'Product not found');
    }

}
