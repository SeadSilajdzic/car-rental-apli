<?php

namespace App\Http\Requests\Api\CarRequests;

use App\Models\Api\Car\RentCar;
use Illuminate\Foundation\Http\FormRequest;

class StoreRentCarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return RentCar::VALIDATION_RULES;
    }
}
