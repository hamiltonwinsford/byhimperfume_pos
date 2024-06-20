<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;


class HomeController extends Controller
{
    //index
    public function index(Request $request)
    {
        $staff = User::where('role', '!=', 'admin')->count();
        $customer = Customer::count();
        $supplier = Supplier::count();
        $product = Product::count();

        $startOfWeek = Carbon::now()->startOfWeek(Carbon::SUNDAY);
        $endOfWeek = Carbon::now()->endOfWeek(Carbon::SATURDAY);

        $transactions = Transaction::whereBetween('transaction_date', [$startOfWeek, $endOfWeek])->get();
        //debugCode($transactions);

        $lastTransaction = Transaction::join('customers','customers.id','customer_id')->select('transactions.*','customers.name')->orderBy('created_at','desc')->limit(5)->get();
        return view('pages.dashboard', compact('staff','customer','supplier','product','lastTransaction'));
    }

    public function getWeeklyTransactions()
    {
        // Mendapatkan tanggal hari ini
        $today = Carbon::now();

        // Mengambil data transaksi dalam bulan ini
        $transactions = Transaction::whereMonth('transaction_date', $today->month)
                                   ->whereYear('transaction_date', $today->year)
                                   ->get()
                                   ->groupBy(function($date) {
                                       return Carbon::parse($date->transaction_date)->startOfWeek(Carbon::SUNDAY)->format('Y-m-d');
                                   });
        // Menyiapkan data untuk chart
        $chartData = [];
        foreach ($transactions as $week => $weekTransactions) {
            $weekTotal = $weekTransactions->sum('total_amount');
            $chartData[] = [
                'week_start' => $week,
                'total' => $weekTotal
            ];
        }

        return response()->json($chartData);
    }

    public function getDailyTransactions()
    {
        // Mendapatkan tanggal hari ini
        $today = Carbon::now();

        // Mengambil data transaksi dalam bulan ini
        $transactions = Transaction::whereMonth('transaction_date', $today->month)
                                   ->whereYear('transaction_date', $today->year)
                                   ->get()
                                   ->groupBy(function($date) {
                                       return Carbon::parse($date->transaction_date)->format('Y-m-d');
                                   });

        // Menyiapkan data untuk chart
        $chartData = [];
        foreach ($transactions as $day => $dayTransactions) {
            $dayTotal = $dayTransactions->sum('total_amount');
            $chartData[] = [
                'day' => $day,
                'total' => $dayTotal
            ];
        }

        return response()->json($chartData);
    }


    public function report(Request $request)
    {
        $data = Transaction::join('users','users.id','user_id')
            ->join('customers','customers.id','customer_id')
            ->join('branches','branches.id','transactions.branch_id')
            ->select('transactions.*', 'users.name', 'customers.name as name_customer','branches.name as name_branch')
            ->orderBy('transactions.created_at','desc')
            ->get();
            //->paginate(10);

        return view('pages.report', compact('data'));
    }

    public function detail(Request $request, $id)
    {
        $data = Transaction::join('users','users.id','user_id')
            ->join('customers','customers.id','customer_id')
            ->join('branches','branches.id','transactions.branch_id')
            ->select('transactions.*', 'users.name', 'customers.name as name_customer','branches.name as name_branch')
            ->where('transactions.id', $id)->first();
       $detail = TransactionItem::join('products','products.id','product_id')->select('transaction_items.*','products.name')->where('transaction_id', $id)->get();

        return view('pages.detail_transaction', compact('data','detail'));
    }
}
