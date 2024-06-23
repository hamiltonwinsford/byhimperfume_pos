<?php

namespace App\Http\Controllers;

use App\Models\StockCard;
use App\Models\Product;
use App\Models\Branch;
use Illuminate\Http\Request;

class StockCardController extends Controller
{
    //index
    // public function index()
    // {
    //     $data = StockCard::join('products','products.id','product_id')
    //         ->select('stock_cards.*','products.name')
    //         ->get();
    //     return view('pages.stockCard.index', compact('data'));
    // }

    // index
    public function index(Request $request)
    {
        if(empty($request->branch_id)){
            $data = Product::get();

        }else{
            $data = Product::where('branch_id', $request->branch_id)->get();
        }
        $branches = Branch::all();
        return view('pages.stockCard.index', compact('products','branches'));
    }

    // public function detail($id)
    // {
    //     $data = StockCard::join('products','products.id','product_id')
    //         ->select('stock_cards.*','products.name')
    //         ->where('product_id', $id)
    //         ->get();
    //     $out = TransactionItem::join('transactions','transactions.id','transaction_id')
    //         ->join('products','products.id','product_id')
    //         ->where('product_id', $id)->select('transaction_items.*','transactions.transaction_date','products.name')->get();
    //     return view('pages.stock.detail', compact('data','out'));
    // }
}
