<?php

namespace App\Models\Api\Car;

use App\Models\Api\Category\Category;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentCar extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'registration_license',
        'date_range',
        'date_from',
        'date_to',
        'total_rent_price'
    ];

    // ===== Public constants
    public const VALIDATION_RULES = [
        'category_id' => 'required|integer',
        'registration_license' => 'required|string',
        'date_range' => 'nullable|integer',
        'date_from' => 'required|date',
        'date_to' => 'required|date',
        'total_rent_price' => 'nullable'
    ];

    // ===== Helper functions
    public static function rentedCarsWithRelations() {
        return self::select([
            'id',
            'user_id',
            'category_id',
            'registration_license',
            'date_range',
            'date_from',
            'date_to',
            'total_rent_price'])->with(['category' => function($query) {
            $query->select(['id', 'name'])->get();
        }])->get();
    }

    public static function rentedCarsResponse($message, $status) {
        return response([
            'message' => $message
        ], $status);
    }

    public static function rentCarValuesArray($request) {
        $data = $request->validated();
        $findCar = Car::where('registration_license', $data['registration_license'])->first();
        if(isset($findCar) && $findCar->isAvailable == 1) {
            $car = $findCar;
        } else {
            $car = null;
        }
        if(isset($car)) {
            $dateRange = self::subtractDates($data['date_from'], $data['date_to']);
            $totalPrice = $dateRange * $car->price;

            $car->isAvailable = 0;
            $car->save();

            return [
                'user_id' => auth()->user()->id,
                'category_id' => $data['category_id'],
                'registration_license' => $data['registration_license'],
                'date_range' => $dateRange,
                'date_from' => $data['date_from'],
                'date_to' => $data['date_to'],
                'total_rent_price' => $totalPrice
            ];
        } else {
            $message = 'Car with that registration license does not exist or car is already rented. Please try again!';
            return abort('404', $message);
        }
    }

    public static function subtractDates($from, $to) {
        $dateFrom = Carbon::parse($from);
        $dateTo = Carbon::parse($to);

        return $dateFrom->diffInDays($dateTo, true);
    }

    // ===== Relationships
    public function category() {
        return $this->belongsTo(Category::class);
    }
}
