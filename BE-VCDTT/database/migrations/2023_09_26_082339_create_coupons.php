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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            // $table->decimal('discount', 5, 2);
            $table->text('description')->nullable();
            $table->string('start_date')->nullable();
            $table->date('expiration_date')->nullable();
            $table->bigInteger('tour_id')->nullable();
            $table->bigInteger('cate_id')->nullable();
            $table->integer('percentage_price')->nullable();
            $table->integer('fixed_price')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
