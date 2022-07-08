<?php

namespace App\Models\Api\Category;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function categories() {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }
}
