<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type');
            $table->tinyInteger('num_person');
            $table->integer('price_day');
            $table->boolean('isRental')->default(0);

            $table->foreignId('img_id')->references('id')->on('images')->onDelete('cascade');
            $table->foreignId('office_id')->references('id')->on('car_offices')->onDelete('cascade');
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
};
