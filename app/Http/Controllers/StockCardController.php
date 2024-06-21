<?php

namespace App\Http\Controllers;

use App\Models\StockCard;

class StockCardController extends Controller
{
    //index
    public function index()
    {
        $data = StockCard::join('products','products.id','product_id')
            ->select('stock_cards.*','products.name')
            ->get();
        return view('pages.stockCard.index', compact('data'));
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
