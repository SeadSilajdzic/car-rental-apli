<?php

namespace App\Http\Controllers\Api\Car;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CarRequests\StoreRentCarRequest;
use App\Mail\RentCarMail;
use App\Mail\RentCarRemovedMail;
use App\Models\Api\Car\RentCar;
use App\Models\Api\User\User;
use Illuminate\Http\Response;

class RentCarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return RentCar::rentedCarsWithRelations();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRentCarRequest $request
     * @return Response
     */
    public function store(StoreRentCarRequest $request)
    {
        $user = auth()->user();
        $carRent = RentCar::create(RentCar::rentCarValuesArray($request));
        $message = 'Car rent ' . $carRent->registration_license . ' has been created';
        \Mail::to($user->email)->send(new RentCarMail($user, $carRent));
        return RentCar::rentedCarsResponse($message, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param RentCar $rent
     * @return RentCar
     */
    public function show(RentCar $rent)
    {
        return $rent;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param RentCar $rent
     * @return RentCar
     */
    public function destroy(RentCar $rent)
    {
        $user = User::where('id', $rent->user_id)->first();
        $message = 'Rent appointment ' . $rent->id . ' has been removed';
        \Mail::to($user->email)->send(new RentCarRemovedMail($user, $rent));
        $rent->delete();
        return RentCar::rentedCarsResponse($message, 200);
    }
}
