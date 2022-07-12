<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CategoryRequests\StoreCategoryRequest;
use App\Http\Requests\Api\CategoryRequests\UpdateCategoryRequest;
use App\Models\Api\Category\Category;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return Category::select(['id', 'name', 'parent_id'])->withCount(['cars', 'categories'])->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCategoryRequest $request
     * @return Response
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create(Category::categoryValuesArray($request));
        $message = 'Category ' . $category->name . ' has been created';
        return Category::categoryResponse($message, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return Category
     */
    public function show(Category $category)
    {
        return Category::eagerLoad($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCategoryRequest $request
     * @param Category $category
     * @return Response
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update(Category::categoryValuesArray($request));
        $message = 'Category updated: ' . $category->name;
        return Category::categoryResponse($message, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return Category
     */
    public function destroy(Category $category)
    {
        Category::reAssociateDataAndRemoveCategory($category);
        $message = "Category " . $category->name . ' has been removed';
        $category->delete();
        return Category::categoryResponse($message, 200);
    }
}
