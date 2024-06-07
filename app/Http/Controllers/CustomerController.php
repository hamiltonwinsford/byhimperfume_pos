<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    //index
    public function index()
    {
        $customers = Customer::paginate(10);
        return view('pages.customers.index', compact('customers'));
    }

    //create
    public function create()
    {
        return view('pages.customers.create');
    }

    //store
    public function store(Request $request)
    {
        try {
            //validate the request...
            $validator = Validator::make($request->all(),[
                'name' => 'required',
                'phone_number' => 'required',
                'email' => 'required',
                'address' => 'required',
                'birthdate' => 'required',
            ]);

            if($validator->fails()){
                return redirect()->back()
                ->withErrors($validator)
                ->withInput();
            }

            //store the request...
            $customer = new Customer;
            $customer->name = $request->name;
            $customer->phone_number = $request->phone_number;
            $customer->email = $request->email;
            $customer->address = $request->address;
            $customer->birthdate= $request->birthdate;

            $customer->save();

            return redirect()->route('customers.index')->with('success', 'Customer created successfully');
        } catch (\Exception $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }

    }

    //show
    public function show($id)
    {
        return view('pages.customers.show');
    }

    //edit
    public function edit($id)
    {
        $customer = Customer::find($id);
        return view('pages.customers.edit', compact('customer'));
    }

    //update
    public function update(Request $request, $id)
    {
        //validate the request...
        $request->validate([
            'name' => 'required',
            'phone_number' => 'required',
            'email' => 'required',
            'address' => 'required',
            'birthdate' => 'required',
        ]);

        //update the request...
        $customer = Customer::find($id);
        $customer->name = $request->name;
        $customer->phone_number = $request->phone_number;
        $customer->email = $request->email;
        $customer->address = $request->address;
        $customer->birthdate= $request->birthdate;

        $customer->save();
        return redirect()->route('customers.index')->with('success', 'Customer updated successfully');
    }

    //destroy
    public function destroy($id)
    {
        try {
            //code...
            //delete the request...
            $customer = Customer::find($id);
            $customer->delete();
            return redirect()->route('customers.index')->with('success', 'Customer deleted successfully');
        } catch (\Throwable $th) {
            //throw $th;
            if($th->errorInfo[1]===1451){
                return redirect()->back()->with('error', 'Terdapat produk dengan Customer ini!, Silahkan hapus produk terlebih dahulu');
            }
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
