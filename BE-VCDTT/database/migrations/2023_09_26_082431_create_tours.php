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
            $table->string('name')->nullable();
            $table->string('duration')->nullable();
            $table->bigInteger('child_price')->nullable();
            $table->bigInteger('adult_price')->nullable();
            $table->integer('sale_percentage')->nullable();
            $table->string('start_destination')->nullable();
            $table->string('end_destination')->nullable();
            $table->integer('tourist_count')->nullable();
            $table->string('details')->nullable();
            $table->string('location')->nullable();
            $table->string('exact_location')->nullable();
            $table->text('pathway')->nullable();
            $table->text('main_img')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->bigInteger('view_count')->default(0);
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
