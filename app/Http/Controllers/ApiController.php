<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Product;
use App\Models\Fragrance;
use App\Models\Category;
use App\Models\Bottle;
use App\Models\Bundle;
use App\Models\OtherProduct;
use App\Models\Cart;
use App\Models\CurrentStock;
use App\Models\Customer;
use App\Models\Branch;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\FirstStock;
use App\Models\Opname;
use App\Models\StockCard;
use App\Models\Restock;
use App\Models\Promotion;
use App\Models\PromotionBundle;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB; //tambahan

class ApiController extends Controller
{

    public function login(Request $request)
    {
        $data = User::where('email', $request->email)->where('role', 'user')->first();
        if (!empty($data)) {
            if (Hash::check($request->password, $data->password)) {
                return returnAPI(200, 'Success', $data);
            }else{
                return returnAPI(201, 'The password you entered is incorrect.!');
            }
        }else{
            return returnAPI(201, 'Email not registered.!');
        }
    }

    public function updatePassword(Request $request)
    {
        $data = User::where('id', $request->id)->first();
        $data->password = Hash::make($request->password);
        $data->save();

        return returnAPI(200, 'Update password successfuly.!');
    }

    public function getProfile(Request $request)
    {
        $id = $request->get('id');
        $data   = User::where('id', $request->id)->first();

        return returnAPI(200, 'Success', $data);
    }

    public function getPromotion(Request $request)
    {
        $data   = Promotion::where('start_date', '<=', date('Y-m-d'))->where('end_date', '>=', date('Y-m-d'))->get();

        return returnAPI(200, 'Success', $data);
    }

    public function getPromotionBundle(Request $request)
    {
        DB::enableQueryLog();
        $data   = PromotionBundle::where('from_date', '<=', date('Y-m-d'))->where('to_date', '>=', date('Y-m-d'))->get();
        $query = DB::getQueryLog();

        return returnAPI(200, 'Success', $data);
    }

    public function addCustomer(Request $request)
    {
        $cek = Customer::where('phone_number', $request->phone_number)->first();
        if(empty($cek)){
            $data = new Customer;
            $data->name = $request->name;
            $data->phone_number = $request->phone_number;
            $data->save();
        }else{
            $data = $cek;
        }

        return returnAPI(200, 'Success', $data);
    }

    public function searchCustomer(Request $request)
    {
        $phone_number = $request->phone_number;

        $data = Customer::where('phone_number', $phone_number)->get();

        return returnAPI(200, 'Success', $data);
    }

    public static function autonumber(){
        $q=DB::table('issue')->select(DB::raw('MAX(RIGHT("no_ticket",5)) as kd_max'));
        $prx=date('dmY');
        if($q->count()>0)
        {
            foreach($q->get() as $k)
            {
                $tmp = ((int)$k->kd_max)+1;
                $kd = $prx.sprintf("%06s", $tmp);
            }
        }
        else
        {
            $kd = $prx."000001";
        }

        return $kd;
    }

    public function getProduct(Request $request)
    {
        $products = Product::where('branch_id', $request->branch_id)->get();
        foreach ($products as $key => $value) {
            $foto = asset('upload/image/'.$value->image);
            $products[$key]->foto_path = $foto;
        }

        // Mengambil data bundle dan menggabungkan produk dalam setiap bundle
            $bundles = Bundle::with(['items.product', 'items.bottle'])
            ->get()
            ->map(function($bundle) {
            $bundle->products = $bundle->items->map(function($item) {
                return [
                    'product_id' => $item->product->id,
                    'product_name' => $item->product->name,
                    'product_description' => $item->product->description,
                    'product_image' => asset('upload/image/'.$item->product->image),
                    'product_price' => $item->product->price,
                    'product_stock' => $item->product->stock,
                    'bundle_quantity' => $item->quantity,
                    'bundle_discount' => $item->discount,
                    'bottle_id' => $item->bottle->id,
                    'bottle_name' => $item->bottle->bottle_name,
                    'bottle_size' => $item->bottle->bottle_size,
                    'bottle_type' => $item->bottle->bottle_type,
                ];
            });
            return $bundle;
            });

        // Menggabungkan data produk dan bundle dalam satu array
        $data = [
        'products' => $products,
        'bundles' => $bundles
        ];

        return returnAPI(200, 'Success', $data);
    }

    public function getCategory(Request $request)
    {
        $data   = Category::get();
        return returnAPI(200, 'Success', $data);
    }

    public function getBottle(Request $request)
    {
        $data   = Bottle::get();
        return returnAPI(200, 'Success', $data);
    }

    public function getOtherProduct(Request $request)
    {
        $data   = OtherProduct::get();

        foreach ($data as $key => $value) {
            $foto = asset('upload/image/'.$value->image);
            $data[$key]->foto_path = $foto;
        }

        return returnAPI(200, 'Success', $data);
    }

    public function searchProduct(Request $request)
    {
        $name = $request->name;

        $data = Product::where('name', 'like', "%$name%")->get();
        foreach ($data as $key => $value) {
            $foto = asset('upload/image/'.$value->image);
            $data[$key]->foto_path = $foto;
        }

        return returnAPI(200, 'Success', $data);
    }

    public function searchBottle(Request $request)
    {
        $name = $request->name;

        $data = Bottle::where('bottle_name', 'like', "%$name%")->get();

        return returnAPI(200, 'Success', $data);
    }

    public function searchBottleSize(Request $request)
    {
        $size = $request->size;

        $data = Bottle::where('bottle_size', $size)->get();

        return returnAPI(200, 'Success', $data);
    }

    public function productByCategory(Request $request)
    {
        $categoryId = $request->category_id;

        $data = Product::where('category_id', $categoryId)->where('branch_id', $request->branch_id)->get();
        foreach ($data as $key => $value) {
            $foto = asset('upload/image/'.$value->image);
            $data[$key]->foto_path = $foto;
        }

        return returnAPI(200, 'Success', $data);
    }

    public function getCurrentStock(Request $request)
    {
        $data   = CurrentStock::join('products as p','p.id','product_id')->select('current_stock.*','p.name')->get();
        return returnAPI(200, 'Success', $data);
    }

    public function getCurrentStockByBranch(Request $request)
    {
        try {
            $branch = $request->branch_id;
            $data = CurrentStock::join('products as p', 'p.id', '=', 'current_stock.product_id')
                ->where('p.branch_id', $branch)
                ->select('current_stock.*', 'p.name')
                ->get();

            if ($data->isEmpty()) {
                return returnAPI(404, 'No current stock found for the given branch', $data);
            }

            return returnAPI(200, 'Success', $data);
        } catch (\Exception $e) {
            return returnAPI(500, 'An error occurred while fetching the current stock', ['error' => $e->getMessage()]);
        }
    }

    public function restock(Request $request)
    {
        // Validasi request
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'total_weight' => 'required|numeric',
        ]);

        // Ambil data fragrance berdasarkan product_id
        $fragrance = Fragrance::where('product_id', $request->product_id)->first();
        if (!$fragrance) {
            return response()->json(['message' => 'Fragrance not found'], 404);
        }

        // Ambil data current stock berdasarkan product_id
        $current = CurrentStock::where('product_id', $request->product_id)->first();
        if (!$current) {
            // Jika tidak ada current stock, buat entri baru
            $current = new CurrentStock();
            $current->product_id = $request->product_id;
            $current->current_stock = 0; // Atur nilai awal quantity
        }

        // Hitung berat dispenser
        $dispenser_weight = $fragrance->bottle_weight + $fragrance->pump_weight;
        $in = $request->total_weight;
        $real_gram = $in - ($dispenser_weight + $current->current_stock_gram);
        $real_ml = $real_gram * $fragrance->ml_to_gram;

        // Data untuk response
        $data = [
            'in' => $in,
            'ml_to_gram' => $fragrance->ml_to_gram,
            'gram_to_ml' => $fragrance->gram_to_ml,
            'dispenser_weight' => $dispenser_weight,
            'current_stock_before_add' => $current->current_stock,
            'current_stock_gram_before_add' => $current->current_stock_gram,
            'real_g' => $real_gram,
            'real_ml' => $real_ml,
            'restock_date' => date('Y-m-d'),
        ];

        // Buat entri restock baru
        $us = new Restock;
        $us->product_id = $request->product_id;
        $us->fragrances_id = $fragrance->id;
        $us->mililiters = $real_ml;
        $us->gram = $real_gram;
        $us->restock_date = date('Y-m-d H:i:s');
        $us->save();

        // Update atau buat entri current stock
        $current->current_stock += $real_ml;
        $current->current_stock_gram += $real_gram;
        $current->save();

        $data['current_stock_after'] = $current->current_stock;
        $data['current_stock_gram_after'] = $current->current_stock_gram;

        return response()->json(['status' => 200, 'message' => 'success', 'data' => $data]);
    }

    public function addStockOpname(Request $request)
    {
        $opname = Opname::where('product_id', $request->product_id)->first();
        $awal = FirstStock::where('product_id', $request->product_id)->first();
        $branch = TransactionItem::join('transactions as t','t.id', 'transaction_id')->where('product_id', $request->product_id)->first();
        $current = CurrentStock::where('product_id', $request->product_id)->first();
        $in = $request->total_weight;
        $month = date('m');
        $out = TransactionItem::where('product_id', $request->product_id)->whereMonth('created_at', $month)->sum('quantity');
        $calc_g = ($awal->stock +  $in) - ($out * $opname->ml_to_g);
        $calc_ml = $calc_g * $opname->ml_to_g;
        $real_g = $awal->stock;
        $real_ml = $real_g * $opname->ml_to_g;
        $data = array(
            'awal'  => $awal->stock,
            'in'    => $in,
            'out'   => $out,
            'calc_g' => $calc_g,
            'calc_ml' => $calc_ml,
            'real_g' => $current->current_stock + $real_g,
            'real_ml' => $real_ml,
            'stock_opname_date' => date('Y-m-d'),
        );

        $us = new StockCard;
        $us->product_id = $request->product_id;
        $us->branch_id = $branch->branch_id;
        $us->stock_in = $in;
        $us->stock_out = $out;
        $us->calc_g = $calc_g;
        $us->calc_ml = $calc_ml;
        $us->real_g = $real_g;
        $us->real_ml = $current->current_stock + $real_ml;
        $us->stock_opname_date = date('Y-m-d');
        $us->save();


        $current->current_stock = $current->current_stock + $real_ml;
        $current->save();

        return returnAPI(200, 'Success', $data);
    }

    /*============================ POS =========================*/

    public function getCart(Request $request)
    {
            $cart = Cart::join('products', 'cart.product_id', 'products.id')
            ->select('cart.*', 'products.name', 'products.price','products.id as prod_id', 'harga_ml', 'variant')
            ->leftJoin('bottle', 'bottle.id', '=', 'cart.bottle_id')
            ->where('user_id', $request->user_id)
            ->get()->all();
        return returnAPI(200, 'Success', $cart);
    }

    public function addToCart(Request $request)
    {
        $bottle = Bottle::where('bottle_size', $request->bottle_size)
                        ->where('variant', $request->variant)
                        ->select('id','harga_ml', 'variant')
                        ->first();

        // Cek apakah bottle ditemukan
        if (!$bottle) {
            return returnAPI(404, 'Bottle not found', null);
        }

        $cart = new Cart;
        $cart->product_id   = $request->product_id;
        $cart->branch_id    = $request->branch_id;
        $cart->user_id      = $request->user_id;
        $cart->bottle_id    = $bottle->id;
        $cart->save();

        $data = [
            'product_id' => $cart->product_id,
            'branch_id' => $cart->branch_id,
            'user_id' => $cart->user_id,
            'price' => $bottle->harga_ml,
            'variant'=> $bottle->variant,
            'bottle_id' => $bottle->id,
            'updated_at' => $cart->updated_at,
            'created_at' => $cart->created_at,
            'id' => $cart->id
        ];

        return returnAPI(200, 'Success', $data);
    }

    public function bundleToCart(Request $request)
    {
        // Pastikan data yang diterima dalam format yang benar
        if (!isset($request->items) || !is_array($request->items)) {
            return returnAPI(400, 'Invalid data format', null);
        }

        $cartItems = [];

        foreach ($request->items as $item) {
            $bottle = Bottle::where('id', $item['bottle_id'])->first();

            // Cek apakah bottle ditemukan
            if (!$bottle) {
                return returnAPI(404, 'Bottle not found for product_id: ' . $item['product_id'], null);
            }

            $cart = new Cart;
            $cart->product_id = $item['product_id'];
            $cart->branch_id = $request->branch_id;
            $cart->user_id = $request->user_id;
            $cart->bottle_id = $bottle->id;
            $cart->discount = $item['discount'];

            // Hitung harga setelah diskon
            $harga = $bottle->harga_ml;
            $cart->price_after_discount = $harga - ($harga * ($item['discount'] / 100));

            $cart->save();

            $cartItems[] = [
                'id' => $cart->id,
                'product_id' => $cart->product_id,
                'branch_id' => $cart->branch_id,
                'user_id' => $cart->user_id,
                'discount'=> $cart->discount,
                'bottle_id' => $bottle->id,
                'price' => $cart->price_after_discount,
                'variant' => $bottle->variant,
                'updated_at' => $cart->updated_at,
                'created_at' => $cart->created_at,
            ];
        }

        return returnAPI(200, 'Success', $cartItems);
    }

    public function updateCart(Request $request)
    {
        $cart = Cart::where('id', $request->cart_id)->first();
        $cart->qty = $request->qty;
        $cart->save();

        return returnAPI(200, 'Success', $cart);
    }

    public function deleteCart(Request $request)
    {
        $data = Cart::where('id', $request->id)->delete();

        return returnAPI(200, 'Success', $data);
    }

    public function checkHarga(Request $request)
    {

        $data = Product::where('id', $request->product_id)->first();

        $harga = $data->price * $request->qty;

        return returnAPI(200, 'Success', $harga);
    }

    public function checkout(Request $request)
    {

        try {
            $cekCart = Cart::where('user_id', $request->user_id)->get()->all();
            $branch = Branch::join('users','users.branch_id','branches.id')->select('branches.*')->where('users.id', $request->user_id)->first();

            if(!empty($request->discount)){
                $discount = $request->discount;
            } else {
                $discount = 0;
            }

            $tr = new Transaction;
            $tr->user_id = $request->user_id;
            $tr->transaction_number = "INV/".date('Ymd')."/".rand(000,999);
            $tr->transaction_date = date('Y-m-d');
            $tr->branch_id = $branch->id;
            $tr->discount = $discount;
            $tr->save();

            $jml_qty = 0;
            $tot_price = 0;
            foreach($cekCart as $key => $value){

                $cekPrduct = Product::where('id', $value->product_id)->first();
                $bottle = Bottle::where('id', $value->bottle_id)->first();

                $dt = new TransactionItem;
                $dt->transaction_id = $tr->id;
                $dt->product_id = $value->product_id;
                $dt->quantity = $bottle->bottle_size;
                $dt->price = $cekPrduct->price*$bottle->bottle_size;
                $dt->subtotal = $bottle->harga_ml;
                $dt->save();

                $tot_price += $bottle->harga_ml;
                $currentStock = CurrentStock::where('product_id', $value->product_id)->first();
                if($bottle->variant === "edt"){
                    $qty = $bottle->bottle_size * 0.7;
                }
                elseif($bottle->variant === "edp"){
                    $qty = $bottle->bottle_size * 0.5;
                }
                elseif($bottle->variant === "perfume"){
                    $qty = $bottle->bottle_size * 0.3;
                }
                if($bottle->variant === "full_perfume"){
                    $qty = $bottle->bottle_size;
                }
                $currentStock->current_stock = $currentStock->current_stock - $qty;
                $currentStock->save();
            }

            $tot_price = $tot_price-($tot_price*($discount/100));

            $cekCus = Customer::where('phone_number', $request->phone_number)->first();
            if(empty($cekCus)){
                $cus = new Customer;
                $cus->name = $request->name_customer;
                $cus->phone_number = $request->phone_number;
                $cus->save();
                $customer_id = $cus->id;
            } else {
                $customer_id = $cekCus->id;
            }

            $cekTr = Transaction::where('id', $tr->id)->first();
            $cekTr->total_amount = $tot_price;
            $cekTr->customer_id = $customer_id;
            $cekTr->save();

            Cart::where('user_id', $request->user_id)->delete();

            return returnAPI(200, 'Success', $tr);
        } catch (Exception $e) {
            Log::error('Error in checkout: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function getHistoryTransactions(Request $request)
    {
        $data   = Transaction::select('transactions.*','customers.name as name_customer')->leftJoin('customers','customers.id', 'customer_id')->where('branch_id', $request->branch_id)->get();
        return returnAPI(200, 'Success', $data);
    }

    public function getHistoryTransactionsByDate(Request $request)
    {
        $data   = Transaction::select('transactions.*','customers.name as name_customer')
            ->leftJoin('customers','customers.id', 'customer_id')
            ->where('branch_id', $request->branch_id)
            ->where('transaction_date', '>=', $request->start_date)
            ->where('transaction_date', '<=', $request->end_date)
            ->get();
        return returnAPI(200, 'Success', $data);
    }
}
