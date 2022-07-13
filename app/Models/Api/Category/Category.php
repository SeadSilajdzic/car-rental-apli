<?php

namespace App\Models\Api\Category;

use App\Models\Api\Car\Car;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'parent_id'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    // ===== Public constants
    public const VALIDATION_RULES = [
        'name' => 'required|string',
        'parent_id' => 'nullable',
    ];

    // ===== Helper functions
    public static function categoryResponse($message, $status) {
        return response([
            'message' => $message
        ], $status);
    }

    public static function eagerLoad($category) {
        return $category->load([
            'cars' => function($query) {
                $query->select(['id', 'brand_id', 'category_id', 'model'])->with(['brand' => function($brandQuery) {
                    $brandQuery->select(['id', 'name'])->get();
                }])->get();
            },
            'categories'
        ]);
    }

    public static function getCategories() {
        return Category::select(['id', 'name', 'parent_id'])->withCount(['cars', 'categories'])->get();
    }

    public static function categoryValuesArray($request) {
        $data = $request->validated();
        if($data['parent_id'] == 0 || !isset($data['parent_id'])) {
            $parentId = null;
        } else {
            $parentId = $data['parent_id'];
        }
        return [
            'name' => $data['name'],
            'parent_id' => $parentId
        ];
    }

    public static function reAssociateDataAndRemoveCategory($category) {
        // Load relations to secure data
        $category->load('cars', 'categories');

        // Check if default backup category exists
        $parent = Category::where('name', 'Unsigned parent category')->first();

        // If default category doesnt exists - create it
        if (!isset($parent)) {
            $parent = Category::create([
                'parent_id' => null,
                'name' => 'Unsigned parent category'
            ]);
        }

        // Check if fetched model is parent category
        if($category->parent_id == null) {
            // If category is parent and has categories
            if(count($category->categories) > 0) {
                // Loop through its subcategories
                foreach($category->categories as $subCategory) {
                    // Assign subcategories to other parent to save data
                    $subCategory->update([
                        'parent_id' => $parent->id
                    ]);
                }
            }
        } elseif($category->name == 'Unsigned parent category') {
            // If user wants to remove the default category - return Unauthorized Response
            $message = 'This category cant be removed since it is the default one!';
            return Category::categoryResponse($message, 401);
        } else {
            // If not parent check number of cars - associate
            if(count($category->cars) > 0) {
                foreach($category->cars as $car) {
                    $car->update([
                        'category_id' => $parent->id
                    ]);
                }
            }
        }

        return $category;
    }

    // ===== Relationships
    public function categories() {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function cars() {
        return $this->hasMany(Car::class);
    }
}
