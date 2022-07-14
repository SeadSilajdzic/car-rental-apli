<?php

namespace App\Http\Controllers\Api\User;

use App\Exports\RentedCars;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserRequests\StoreUserRequest;
use App\Http\Requests\Api\UserRequests\UpdateUserRequest;
use App\Models\Api\User\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return User|Collection
     */
    public function index()
    {
        return User::select(['id', 'name', 'email'])->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserRequest $request
     * @return string
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create(User::userValuesArray($request));
        $message = 'New user, ' . $user->name . ' has been added';
        return User::userResponse($message, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return User
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return string
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update(User::userValuesArray($request));
        $message = $user->name . 's info has been updated';
        return User::userResponse($message, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return Response
     */
    public function destroy(User $user)
    {
        $message = $user->name . ' has been removed';
        $user->delete();
        return User::userResponse($message, 200);
    }
}
