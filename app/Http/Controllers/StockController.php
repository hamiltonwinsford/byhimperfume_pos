<?php

namespace App\Http\Controllers;

use App\Models\StockCard;
use App\Models\Product;
use App\Models\Branch;
use App\Models\CurrentStock;
use App\Models\TransactionItem;
use App\Models\Fragrance;
use App\Models\Restock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = CurrentStock::join('products', 'products.id', '=', 'current_stock.product_id')
                            ->join('branches', 'branches.id', '=', 'products.branch_id')
                            ->join('fragrances', 'products.id', '=', 'fragrance_id.product_id')
                            ->select('current_stock.*', 'products.name as product_name', 'branches.name as branch_name', 'fragrances.pump_weight as pump_weight', 'fragrances.bottle_weight as bottle_weight')
                            ->get();

        foreach ($data as $item) {
            $item->currentWeightWithBottle = $item->pump_weight + $item->bottle_weight;
        }

        return view('pages.stock.index', compact('data'));
    }

    public function detail($id)
    {
        $data = Restock::join('products', 'products.id', '=', 'restocks.product_id')
            ->where('product_id', $id)
            ->select('products.name', 'restocks.mililiters', 'restocks.gram', 'restocks.restock_date')
            ->get();

        $out = TransactionItem::join('transactions','transactions.id','transaction_id')
            ->join('products','products.id','product_id')
            ->where('product_id', $id)->select('transaction_items.*','transactions.transaction_date','products.name')->get();
        return view('pages.stock.detail', compact('data','out'));
    }
}
