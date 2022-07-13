<?php

namespace App\Http\Controllers\Api\Brand;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\BrandRequests\StoreBrandRequest;
use App\Http\Requests\Api\BrandRequests\UpdateBrandRequest;
use App\Models\Api\Brand\Brand;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Brand|Collection
     */
    public function index()
    {
        return Brand::getBrands();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreBrandRequest $request
     * @return Response
     */
    public function store(StoreBrandRequest $request)
    {
        $brand = Brand::create(Brand::brandValuesArray($request));
        $message = 'Brand ' . $brand->name . ' has been created';
        return Brand::brandResponse($message, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Brand $brand
     * @return Brand
     */
    public function show(Brand $brand)
    {
        return $brand;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateBrandRequest $request
     * @param Brand $brand
     * @return void
     */
    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        $brand->update(Brand::brandValuesArray($request));
        $message = 'Brand updated: ' . $brand->name;
        return Brand::brandResponse($message, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Brand $brand
     * @return void
     */
    public function destroy(Brand $brand)
    {
        $message = 'Brand ' . $brand->name . ' has been removed';
        $brand->delete();
        return Brand::brandResponse($message, 200);
    }
}
