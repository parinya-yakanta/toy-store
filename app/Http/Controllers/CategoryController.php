<?php

namespace App\Http\Controllers;

use App\Helpers\GoToHelper;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::paginate(10);
        return view('pages.category.index', compact('categories'));
    }

    public function create(Request $request)
    {
        return view('pages.category.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return GoToHelper::validator($validator, $validator->errors()->first());
        }

        $checkCategory = Category::where('name', $request->name)->first();

        if ($checkCategory) {
            return GoToHelper::error('Category already exists');
        }

        $inputs = [
            'code' => Str::upper(Str::random(3)) . date('YmdHis'),
            'name' => $request->name,
        ];

        DB::transaction(function () use ($request, $inputs) {
            Category::create($inputs);
        });

        return GoToHelper::success('Category created successfully', 'masters.categories.index');
    }

    public function update(Request $request)
    {
        $categoryCode = $request->query('ref', 0);
        $category = Category::where('code', $categoryCode)->first();

        if (!$category) {
            return GoToHelper::error('Category not found');
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

        DB::transaction(function () use ($category, $inputs) {

            $category->update($inputs);
        });

        return GoToHelper::success('User updated successfully', 'masters.categories.edit', ['ref' => $category->code]);
    }

    public function delete(Request $request)
    {
        $categoryCode = $request->query('ref', 0);
        $category = Category::where('code', $categoryCode)->first();

        if (!$category) {
            return GoToHelper::error('User not found');
        }

        DB::beginTransaction();
        try {
            $category->update(['deleted_by' => auth()->user()->id]);
            $category->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return GoToHelper::error('An error occurred while deleting the user');
        }

        return GoToHelper::success('Category deleted successfully', 'masters.categories.index');
    }

    public function edit(Request $request)
    {
        $categoryCode = $request->query('ref', 0);
        $category = Category::where('code', $categoryCode)->first();

        if (!$category) {
            return back()->with('error', 'Category not found');
        }

        return view('pages.category.edit', compact('category'));
    }
}
