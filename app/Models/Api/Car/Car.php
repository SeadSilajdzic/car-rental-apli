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

    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function brand() {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }
}
