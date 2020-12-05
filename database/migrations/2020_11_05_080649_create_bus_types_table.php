<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bus_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->enum('vehicle_type',['bus','train','private']);
            $table->unsignedInteger('left_column_spam')->default(2);
            $table->unsignedInteger('left_row_spam')->default(15);
            $table->unsignedInteger('right_column_spam')->default(2);
            $table->unsignedInteger('right_row_spam')->default(15);
            $table->unsignedInteger('back_seat')->default(5);
            //$table->foreignId('company_id');
            //$table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->unsignedInteger('capacity');
            $table->timestamps();
        });
    }

    /**f
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bus_types');
    }
}
