<?php

namespace App\Http\Controllers;

use App\Helpers\GoToHelper;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $brands = Brand::paginate(10);
        return view('pages.brand.index', compact('brands'));
    }

    public function create(Request $request)
    {
        return view('pages.brand.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return GoToHelper::validator($validator, $validator->errors()->first());
        }

        $checkBrand = Brand::where('name', $request->name)->first();

        if ($checkBrand) {
            return GoToHelper::error('Brand already exists');
        }

        $inputs = [
            'code' => Str::upper(Str::random(3)) . date('YmdHis'),
            'name' => $request->name,
        ];

        DB::transaction(function () use ($request, $inputs) {
            Brand::create($inputs);
        });

        return GoToHelper::success('Brand created successfully', 'masters.brands.index');
    }

    public function update(Request $request)
    {
        $brandCode = $request->query('ref', 0);
        $brand = Brand::where('code', $brandCode)->first();

        if (!$brand) {
            return GoToHelper::error('Brand not found');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return GoToHelper::validator($validator, $validator->errors()->first());
        }

        $inputs = [
            'name' => $request->name,
        ];

        DB::transaction(function () use ($brand, $inputs) {

            $brand->update($inputs);
        });

        return GoToHelper::success('User updated successfully', 'masters.brands.edit', ['ref' => $brand->code]);
    }

    public function delete(Request $request)
    {
        $brandCode = $request->query('ref', 0);
        $brand = Brand::where('code', $brandCode)->first();

        if (!$brand) {
            return GoToHelper::error('User not found');
        }

        DB::beginTransaction();
        try {
            $brand->update(['deleted_by' => auth()->user()->id]);
            $brand->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return GoToHelper::error('An error occurred while deleting the user');
        }

        return GoToHelper::success('Brand deleted successfully', 'masters.brands.index');
    }

    public function edit(Request $request)
    {
        $brandCode = $request->query('ref', 0);
        $brand = Brand::where('code', $brandCode)->first();

        if (!$brand) {
            return back()->with('error', 'Brand not found');
        }

        return view('pages.brand.edit', compact('brand'));
    }
}
