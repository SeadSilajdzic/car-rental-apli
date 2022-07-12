<?php

namespace App\Http\Controllers\Api\Car;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CarRequests\StoreCarRequest;
use App\Http\Requests\Api\CarRequests\UpdateCarRequest;
use App\Models\Api\Car\Car;
use Illuminate\Http\Response;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
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
}
