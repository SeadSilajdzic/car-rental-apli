<?php

namespace App\Console\Commands;

use App\Exports\RentedCars;
use App\Models\Api\Car\RentCar;
use App\Models\Api\User\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CSVWeeklyCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weekly:csv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will export weekly report of the rented cars in CSV format';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return BinaryFileResponse
     */
    public function handle()
    {
        return Excel::download(new RentedCars, 'rentedCars-'.Carbon::today().'.csv');
    }
}
