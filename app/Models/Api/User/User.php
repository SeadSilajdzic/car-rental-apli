<?php

namespace App\Models\Api\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
//        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Public constants
    public const VALIDATION_RULES = [
        'name' => 'required|string',
        'email' => 'required|email',
        'password' => 'required|string|confirmed|min:6'
    ];

    // Helper functions
    public static function userResponse($message, $status) {
        return response([
            'message' => $message
        ], $status);
    }

    public static function userValuesArray($request) {
        $data = $request->validated();
        return [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ];
    }
}
