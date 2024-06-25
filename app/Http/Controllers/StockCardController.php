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
        if (empty($request->branch_id)) {
            $data = StockCard::with('product', 'branch', 'fragrance')->get();
        } else {
            $data = StockCard::with('product', 'branch', 'fragrance')
                            ->where('branch_id', $request->branch_id)
                            ->get();
        }

        $branches = Branch::all();
        return view('pages.stockCard.index', compact('data', 'branches'));
    }

    
}
