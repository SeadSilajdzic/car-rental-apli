<?php

namespace App\Models\Api\Brand;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    // ===== Helper functions
    public static function getBrands() {
        return Brand::select(['id', 'name'])->get();
    }

    public static function brandResponse($message, $status) {
        return response([
            'message' => $message
        ], $status);
    }

    public static function brandValuesArray($request) {
        $data = $request->validated();
        return [
            'name' => $data['name']
        ];
    }

    // ===== Public constants
    public const VALIDATION_RULES = [
        'name' => 'required|string'
    ];
}
