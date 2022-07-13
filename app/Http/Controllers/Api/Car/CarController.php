<?php

namespace App\Http\Controllers\Api\Car;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CarRequests\StoreCarRequest;
use App\Http\Requests\Api\CarRequests\UpdateCarRequest;
use App\Models\Api\Brand\Brand;
use App\Models\Api\Car\Car;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $currency
     * @return Response
     */
    public function index($currency = null)
    {
        if($currency !== null) {
            $response = Http::get('https://api.fastforex.io/fetch-one?from=USD&to='. $currency .'&api_key=e2eb3fbb08-414f59e7c2-reyc8r');
            $currencyResponse = $response->json('result');
            foreach($currencyResponse as $key => $value) {
                $currencyValue = $value;
            }
            return Car::carsWithRelations($currencyValue);
        }

        return Car::carsWithRelations();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCarRequest $request
     * @return Response
     */
    public function store(StoreCarRequest $request)
    {
        $car = Car::create(Car::carValuesArray($request));
        $message = 'Car model ' . $car->model . ' has been created';
        return Car::carResponse($message, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Car $car
     * @return Car
     */
    public function show(Car $car)
    {
        $car->load(['category' => function($query) {
            $query->select('id', 'name', 'parent_id');
        }, 'brand' => function($query) {
            $query->select('id', 'name');
        }]);
        return $car;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCarRequest $request
     * @param Car $car
     * @return bool
     */
    public function update(UpdateCarRequest $request, Car $car)
    {
        $car->update(Car::carValuesArray($request));
        $message = $car->model . ' - ' . $car->registration_license . ' has been updated';
        return Car::carResponse($message, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Car $car
     * @return string
     */
    public function destroy(Car $car)
    {
        $message = 'Car ' . $car->model . ' - ' . $car->manufacture_date . ' has been deleted.';
        $car->delete();
        return Car::carResponse($message, 200);
    }

    /**
     * @param $brand
     * @param $model
     * @param $fromPrice
     * @param $toPrice
     * @return mixed
     */
    public function searchCars($brand, $model, $fromPrice, $toPrice) {
        $brand = Brand::where('name', 'like', '%' . $brand . '%')->first();
        return Car::where('brand_id', $brand->id)->where('model', 'like', '%' . $model . '%')->where('price', '>', $fromPrice)->andWhere('price', '<', $toPrice)->get();
    }
}
