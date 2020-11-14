<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('startCityID');
            $table->unsignedBigInteger('dropOfCityID');
            $table->foreignId('busType_id');
            $table->foreignId('company_id');
            $table->string('side_number');
            $table->unsignedFloat('price');
            $table->unsignedFloat('travel_km');
            $table->unsignedInteger('travel_minutes');

            $table->string('travel_pickup_time');
            $table->foreign('busType_id')->references('id')->on('bus_types')->onDelete('cascade');

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');

            $table->date('Gregorian');
            $table->date('local');
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
        Schema::dropIfExists('travel');
    }
}
