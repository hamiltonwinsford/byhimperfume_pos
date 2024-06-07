<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //index
    public function index()
    {
        $categories = Category::paginate(10);
        return view('pages.categories.index', compact('categories'));
    }

    //create
    public function create()
    {
        return view('pages.categories.create');
    }

    //store
    public function store(Request $request)
    {
        // dd($request->all());
        try {
            //validate the request...
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'fragrances_status' => 'required|in:0,1',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            //store the request...
            $category = new Category;
            $category->name = $request->name;
            $category->description = $request->description;
            $category->fragrances_status = $request->fragrances_status;

            //save image
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $image->storeAs('public/categories', $category->id . '.' . $image->getClientOriginalExtension());
                $category->image = 'storage/categories/' . $category->id . '.' . $image->getClientOriginalExtension();
            }
            $category->save();

            return redirect()->route('categories.index')->with('success', 'Category created successfully');
        } catch (\Exception $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    //show
    public function show($id)
    {
        return view('pages.categories.show');
    }

    //edit
    public function edit($id)
    {
        $category = Category::find($id);
        return view('pages.categories.edit', compact('category'));
    }

    //update
    public function update(Request $request, $id)
    {
        //validate the request...
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'fragrances_status' => 'required|in:0,1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        //update the request...
        $category = Category::find($id);
        $category->name = $request->name;
        $category->description = $request->description;
        $category->fragrances_status = $request->fragrances_status;

        //save image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/categories', $category->id . '.' . $image->getClientOriginalExtension());
            $category->image = 'storage/categories/' . $category->id . '.' . $image->getClientOriginalExtension();
            $category->save();
        }
        $category->save();
        return redirect()->route('categories.index')->with('success', 'Category updated successfully');
    }

    //destroy
    public function destroy($id)
    {
        try {
            //code...
            //delete the request...
            $category = Category::find($id);
            $category->delete();
            return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
        } catch (\Throwable $th) {
            //throw $th;
            if ($th->errorInfo[1] === 1451) {
                return redirect()->back()->with('error', 'Terdapat produk dengan Category ini!, Silahkan hapus produk terlebih dahulu');
            }
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
