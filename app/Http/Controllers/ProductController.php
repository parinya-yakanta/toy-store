<?php

namespace App\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Helpers\GoToHelper;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with([
            'category' => function ($query) {
                $query->withTrashed();
            },
            'brand' => function ($query) {
                $query->withTrashed();
            },
            ])->get();
        return view('pages.product.index', compact('products'));
    }

    public function show()
    {
        return view('pages.product.show');
    }

    public function create()
    {
        if (auth()->user()->role != 'admin') {
            return back()->with('error', 'You are not authorized to access this page');
        }

        $brands = Brand::get();
        $categories = Category::get();
        return view('pages.product.create', compact('brands', 'categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'original_price' => 'required',
            'price' => 'required',
            'discount' => 'required',
            'stock' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:8192',
            'weight' => 'required',
            'dimension' => 'required',
            'category_id' => 'required',
            'brand_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $inputs = [
            'code' => "PR" . Str::upper(Str::random(5)) . time(),
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'name' => $request->name,
            'description' => $request->description,
            'original_price' => $request->original_price,
            'price' => $request->price,
            'discount' => $request->discount,
            'stock' => $request->stock,
            'weight' => $request->weight,
            'dimension' => $request->dimension,
            'user_id' => auth()->user()->id,
        ];

        if ($request->hasFile('image')) {
            $inputs['image'] = CommonHelper::saveFile($request->file('image'), 'products', 1);
        }

        DB::beginTransaction();
        try {
            Product::create($inputs);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return GoToHelper::error('An error occurred while creating the product');
        }

        return GoToHelper::success('Product created successfully', 'products.index');
    }

    public function edit(Request $request)
    {
        if (auth()->user()->role != 'admin') {
            return back()->with('error', 'You are not authorized to access this page');
        }

        $code = $request->query('ref', 0);
        $product = Product::where('code', $code)->first();

        if (!$product) {
            return GoToHelper::error('Product not found');
        }


        $brands = Brand::get();
        $categories = Category::get();

        return view('pages.product.edit', compact('product', 'brands', 'categories'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'original_price' => 'required',
            'price' => 'required',
            'discount' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:8192',
            'weight' => 'required',
            'dimension' => 'required',
            'category_id' => 'required',
            'brand_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $code = $request->query('ref', 0);
        $product = Product::where('code', $code)->first();

        if (!$product) {
            return GoToHelper::error('Product not found');
        }

        if ($request->input('stock') < $product->stock) {
            return GoToHelper::error('Stock cannot be less than the current stock');
        }

        $inputs = [
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'name' => $request->name,
            'description' => $request->description,
            'original_price' => $request->original_price,
            'price' => $request->price,
            'stock' => $request->stock,
            'discount' => $request->discount,
            'weight' => $request->weight,
            'dimension' => $request->dimension,
            'user_id' => auth()->user()->id,
        ];

        if ($request->hasFile('image')) {

            $inputs['image'] = CommonHelper::saveFile($request->file('image'), 'products', 1);
        }

        DB::beginTransaction();
        try {
            $product->update($inputs);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return GoToHelper::error('An error occurred while updating the product');
        }

        return GoToHelper::success('Product updated successfully', 'products.edit', ['ref' => $product->code]);
    }

    public function delete(Request $request)
    {
        $code = $request->query('ref', 0);
        $product = Product::where('code', $code)->first();

        if (!$product) {
            return GoToHelper::error('Product not found');
        }

        DB::beginTransaction();
        try {
            $product->update(['deleted_by' => auth()->user()->id]);
            $product->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return GoToHelper::error('An error occurred while deleting the product');
        }

        return GoToHelper::success('Product deleted successfully', 'products.index');
    }
}
