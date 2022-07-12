<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserRequests\StoreUserRequest;
use App\Models\Api\User\User;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @param StoreUserRequest $request
     * @return ResponseFactory|Response
     */
    public function register(StoreUserRequest $request) {
        $user = User::create(User::userValuesArray($request));
        $token = $user->createToken('authentificationToken')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response($response);
    }

    /**
     * @param Request $request
     * @return ResponseFactory|Response
     */
    public function login(Request $request) {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $user = User::where('email', $data['email'])->first();

        if(!$user || Hash::check($data['password'], bcrypt($user->password))) {
            return response([
                'messaage' => 'Credentials do not match'
            ], 401);
        }

        $token = $user->createToken('authentificationToken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    /**
     * @return string
     */
    public function logout() {
        $user = auth()->user();

        $user->tokens()->delete();
        return 'User is logged out';
    }
}
