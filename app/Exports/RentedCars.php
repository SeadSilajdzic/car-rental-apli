<?php

namespace App\Exports;

use App\Models\Api\Car\RentCar;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RentedCars implements FromCollection, WithCustomCsvSettings, WithHeadings
{
    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';'
        ];
    }

    public function headings(): array
    {
        return ['Rent ID', 'Car license', 'Days', 'Start Date', 'Due Date', 'Client'];
    }

    /**
    * @return Collection
    */
    public function collection()
    {
        return RentCar::select(['id', 'registration_license', 'date_range', 'date_from', 'date_to', 'user_id'])->get();
    }
}
