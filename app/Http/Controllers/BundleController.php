<?php
namespace App\Http\Controllers;

use App\Models\Bundle;
use App\Models\BundleItem;
use App\Models\Product;
use App\Models\Bottle;
use App\Models\Branch;
use App\Models\CurrentStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        $branch = Branch::find($branchId);
        if (!$branch) {
            return response()->json(['error' => 'Branch not found'], 404);
        }

        $products = Product::where('branch_id', $branchId)->get();
        return response()->json($products);
    }

    public function getVariants()
    {
        $variants = Bottle::select('variant')->distinct()->pluck('variant');
        return response()->json($variants);
    }

    public function getBottleSizesByVariant($variant)
    {
        $bottles = Bottle::where('variant', $variant)->get();
        $bottles_size= $bottles->pluck('bottle_size');
        return response()->json($bottles);
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.bottle_id' => 'required|exists:bottles,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.discount_percent' => 'nullable|numeric|min:0|max:100',
        ]);

        // Buat bundle baru dan simpan
        $bundle = new Bundle();
        $bundle->name = $request->name;
        $bundle->description = $request->description;
        $bundle->start_date = $request->start_date;
        $bundle->end_date = $request->end_date;
        $bundle->price = 0; // Inisialisasi harga sementara
        $bundle->save(); // Simpan bundle terlebih dahulu

        $items = $request->items; // Array of items
        $totalPrice = 0;

        foreach ($items as $item) {
            $bottle = Bottle::find($item['bottle_id']);
            // Tambahkan logging untuk memeriksa nilai dari bottle_id
            if (!$bottle) {
                Log::error("Bottle not found with id: " . $item['bottle_id']);
                return redirect()->back()->withErrors(['error' => 'Bottle not found with id: ' . $item['bottle_id']]);
            }
            $discountedPrice = $bottle->harga_ml * ((100 - $item['discount_percent']) / 100);
            $totalPrice += $discountedPrice;

            $bundleItem = new BundleItem();
            $bundleItem->bundle_id = $bundle->id; // Menggunakan bundle_id dari bundle yang sudah disimpan
            $bundleItem->product_id = $item['product_id'];
            $bundleItem->bottle_id = $item['bottle_id'];
            $bundleItem->quantity = $item['quantity'];
            $bundleItem->discount = $item['discount_percent'];

            $currentStock = CurrentStock::where('product_id', $item['product_id'])->first();

            if($bottle->variant === "edt"){
                $qty = $bottle->bottle_size * 0.7;
            }
            elseif($bottle->variant === "edp"){
                $qty = $bottle->bottle_size * 0.5;
            }
            elseif($bottle->variant === "perfume"){
                $qty = $bottle->bottle_size * 0.3;
            }
            elseif($bottle->variant === "full_perfume"){
                $qty = $bottle->bottle_size;
            }

            $currentStock->current_stock -= $qty * $item['quantity'];

            $bundleItem->save();
            $currentStock->save();
        }

        // Update harga total bundle
        $bundle->price = $totalPrice;
        $bundle->save();

        return redirect()->route('bundles.index')->with('success', 'Bundle created successfully');
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
        return view('pages.bundles.edit', compact('bundle', 'products', 'bottles'));
    }

    public function update(Request $request, Bundle $bundle)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.bottle_id' => 'required|exists:bottles,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.discount_percent' => 'nullable|numeric|min:0|max:100',
        ]);

        // Update data bundle
        $bundle->update($request->only('name', 'description', 'start_date', 'end_date'));

        // Kembalikan stok item sebelum menghapus
        foreach ($bundle->items as $item) {
            $currentStock = CurrentStock::where('product_id', $item->product_id)->first();
            $bottle = Bottle::find($item->bottle_id);

            if($bottle->variant === "edt"){
                $qty = $bottle->bottle_size * 0.7;
            }
            elseif($bottle->variant === "edp"){
                $qty = $bottle->bottle_size * 0.5;
            }
            elseif($bottle->variant === "perfume"){
                $qty = $bottle->bottle_size * 0.3;
            }
            elseif($bottle->variant === "full_perfume"){
                $qty = $bottle->bottle_size;
            }

            $currentStock->current_stock += $qty * $item->quantity;
            $currentStock->save();
        }

        // Hapus item lama
        $bundle->items()->delete();

        // Tambahkan item baru
        $totalPrice = 0;
        foreach ($request->items as $itemData) {
            $bottle = Bottle::find($itemData['bottle_id']);
            $discountedPrice = $bottle->harga_ml * ((100 - $itemData['discount_percent']) / 100);
            $totalPrice += $discountedPrice;

            $bundleItem = new BundleItem();
            $bundleItem->bundle_id = $bundle->id;
            $bundleItem->product_id = $itemData['product_id'];
            $bundleItem->bottle_id = $itemData['bottle_id'];
            $bundleItem->quantity = $itemData['quantity'];
            $bundleItem->discount = $itemData['discount_percent'];

            $currentStock = CurrentStock::where('product_id', $itemData['product_id'])->first();
            if ($bottle->variant === "edt") {
                $qty = $bottle->bottle_size * 0.7;
            } elseif ($bottle->variant === "edp") {
                $qty = $bottle->bottle_size * 0.5;
            } elseif ($bottle->variant === "perfume") {
                $qty = $bottle->bottle_size * 0.3;
            } elseif ($bottle->variant === "full_perfume") {
                $qty = $bottle->bottle_size;
            }
            $currentStock->current_stock -= $qty * $itemData['quantity'];

            $bundleItem->save();
            $currentStock->save();
        }

        // Update harga total bundle
        $bundle->price = $totalPrice;
        $bundle->save();

        return redirect()->route('bundles.index')->with('success', 'Bundle updated successfully');
    }

    public function destroy(Bundle $bundle)
    {
        $bundle->items()->delete();
        $bundle->delete();
        return redirect()->route('bundles.index')->with('success', 'Bundle deleted successfully');
    }
}
