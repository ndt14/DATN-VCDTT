<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('duration');
            $table->bigInteger('child_price');
            $table->bigInteger('adult_price');
            $table->integer('sale_percentage');
            $table->string('start_destination');
            $table->string('end_destination');
            $table->integer('tourist_count');
            $table->string('details');
            $table->string('location');
            $table->string('exact_location');
            //store id of images table
            $table->bigInteger('main_img');
            $table->tinyInteger('status');
            $table->bigInteger('view_count');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};
