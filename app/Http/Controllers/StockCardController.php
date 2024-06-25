<?php

namespace App\Http\Controllers;

use App\Models\StockCard;
use App\Models\Product;
use App\Models\Fragrance;
use App\Models\CurrentStock;
use App\Models\TransactionItem;
use App\Models\Branch;
use Illuminate\Http\Request;

class StockCardController extends Controller
{
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


    public function opname($id)
    {
        $stockCard = StockCard::with('product', 'branch', 'fragrance')->findOrFail($id);
        return view('pages.stockCard.opname', compact('stockCard'));
    }

    public function update(Request $request, $id)
    {
        $stockCard = StockCard::findOrFail($id);
        $stockCard->opening_stock_gram = $request->opening_stock_gram;
        $stockCard->stock_opname_start = $request->stock_opname_start;
        $stockCard->stock_opname_end = $request->stock_opname_end;
        $stockCard->save();

        return redirect()->route('stockcard.index')->with('success', 'Stock opname updated successfully.');
    }

}
