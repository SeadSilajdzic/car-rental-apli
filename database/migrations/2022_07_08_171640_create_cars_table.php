<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained('brands')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('registration_license')->unique();
            $table->string('model');
            $table->string('slug');
            $table->boolean('isAvailable')->comment('0 Cant be rented / 1 can be rented');
            $table->decimal('price');
            $table->string('manufacture_date');
            $table->text('description');
            $table->integer('fuel_capacity')->nullable();
            $table->integer('number_of_seats')->nullable();
            $table->integer('truck_volume')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cars');
    }
}
