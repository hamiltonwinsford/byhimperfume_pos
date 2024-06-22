<?php
namespace App\Http\Controllers;

use App\Models\Bundle;
use App\Models\BundleItem;
use App\Models\Product;
use App\Models\Bottle;
use App\Models\Branch;
use App\Models\CurrentStock;
use Illuminate\Http\Request;

class BundleController extends Controller
{
    public function index()
    {
        $bundles = Bundle::with('items.product', 'items.bottle')->get();
        return view('pages.bundles.index', compact('bundles'));
    }

    public function create()
    {
        $products = Product::all();
        $branches = Branch::all();
        $bottles = Bottle::all();
        return view('pages.bundles.create', compact('branches', 'bottles'));
    }

    public function getProductsByBranch($branchId)
    {
        $products = Product::where('branch_id', $branchId)->get();
        return response()->json($products);
    }

    public function store(Request $request)
    {
        $bundle = new Bundle();
        $bundle->name = $request->name;
        $bundle->description = $request->description;

        $items = $request->items; // Array of items
        $totalPrice = 0;

        foreach ($items as $item) {
            $product = Product::find($item['product_id']);
            $discountedPrice = $product->price * ((100 - $item['discount_percent']) / 100);
            $totalPrice += $discountedPrice * $item['quantity'];
        }

        $bundle->price = $totalPrice;
        $bundle->save();

        foreach ($items as $item) {
            $bundleItem = new BundleItem();
            $bundleItem->bundle_id = $bundle->id;
            $bundleItem->product_id = $item['product_id'];
            $bundleItem->bottle_id = $item['bottle_id'];
            $bundleItem->quantity = $item['quantity'];
            $bundleItem->discount_percent = $item['discount_percent'];
            $bundleItem->save();

            $currentStock = CurrentStock::where('product_id', $item['product_id'])->first();
            $currentStock->current_stock -= $item['bottle_size'] * $item['quantity'];
            $currentStock->save();
        }

        return redirect()->route('pages.bundles.index')->with('success', 'Bundle created successfully');
    }

    public function show(Bundle $bundle)
    {
        $bundle->load('items.product', 'items.bottle');
        return view('bundles.show', compact('bundle'));
    }

    public function edit(Bundle $bundle)
    {
        $products = Product::all();
        $bottles = Bottle::all();
        $bundle->load('items.product', 'items.bottle');
        return view('bundles.edit', compact('bundle', 'products', 'bottles'));
    }

    public function update(Request $request, Bundle $bundle)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.bottle_id' => 'nullable|exists:bottle,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $bundle->update($request->only('name', 'description', 'discount_percent'));

        $bundle->items()->delete();

        foreach ($request->items as $item) {
            $bundle->items()->create($item);
        }

        return redirect()->route('bundles.index')->with('success', 'Bundle updated successfully');
    }

    public function destroy(Bundle $bundle)
    {
        $bundle->items()->delete();
        $bundle->delete();
        return redirect()->route('bundles.index')->with('success', 'Bundle deleted successfully');
    }
}
