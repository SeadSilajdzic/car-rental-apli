<?php

namespace App\Models\Api\Car;

use App\Models\Api\Brand\Brand;
use App\Models\Api\Category\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'brand_id',
        'category_id',
        'registration_license',
        'model',
        'slug',
        'price',
        'manufacture_date',
        'description',
        'fuel_capacity',
        'number_of_seats',
        'truck_volume'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    // Public constants
    public const VALIDATION_RULES = [
        'brand_id' => 'required|integer',
        'category_id' => 'required|integer',
        'registration_license' => 'required|string',
        'model' => 'required|string',
        'slug' => 'nullable|string',
        'price' => 'required|integer',
        'manufacture_date' => 'required|date',
        'description' => 'required|string',
        'fuel_capacity' => 'nullable|integer',
        'number_of_seats' => 'nullable|integer',
        'truck_volume' => 'nullable|integer'
    ];

    // Helper functions
    public static function carsWithRelations() {
        return Car::select(['id', 'model', 'slug', 'registration_license', 'category_id', 'brand_id', 'manufacture_date', 'price', 'description', 'fuel_capacity', 'number_of_seats', 'truck_volume'])
            ->orderByDesc('id')
            ->with(['category' => function($query) {
                $query->select('id', 'name', 'parent_id');
            }, 'brand' => function($query) {
                $query->select('id', 'name');
            }])
            ->get();
    }

    public static function carResponse($message, $status) {
        return response([
            'message' => $message
        ], $status);
    }

    public static function carValuesArray($request) {
        $data = $request->validated();
        $brand = Brand::where('id', $data['brand_id'])->first();
        $model = $data['model'];
        $regLicense = $data['registration_license'];
        $slug = str_replace(' ', '_', strtolower($brand->name . '_' . $model . '_' . $regLicense));
        return [
            'brand_id' => $brand->id,
            'category_id' => $data['category_id'],
            'registration_license' => $regLicense,
            'model' => $model,
            'slug' => $slug,
            'price' => $data['price'],
            'manufacture_date' => $data['manufacture_date'],
            'description' => $data['description'],
        ];
    }

    // Relationships
    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function brand() {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }
}
