<?php

namespace App\Http\Controllers;

use App\Models\StockCard;
use App\Models\Product;
use App\Models\CurrentStock;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = CurrentStock::join('products','products.id','product_id')
            ->select('current_stock.*','products.name')
            ->get();
        return view('pages.stock.index', compact('data'));
    }

    public function detail($id)
    {
        $data = StockCard::join('products','products.id','product_id')
            ->select('stock_cards.*','products.name')
            ->where('product_id', $id)
            ->get();
        $out = TransactionItem::join('transactions','transactions.id','transaction_id')
            ->join('products','products.id','product_id')
            ->where('product_id', $id)->select('transaction_items.*','transactions.transaction_date','products.name')->get();
        return view('pages.stock.detail', compact('data','out'));
    }
}