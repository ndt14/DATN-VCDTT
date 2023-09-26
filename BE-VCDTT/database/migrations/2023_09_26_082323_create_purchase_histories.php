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
        Schema::create('purchase_histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('user_info');
            $table->string('tour_name');
            $table->string('tour_duration');
            $table->bigInteger('tour_child_price');
            $table->integer('child_count');
            $table->bigInteger('tour_adult_price');
            $table->integer('adult_count');
            $table->integer('tour_sale_percentage');
            $table->string('tour_start_destination');
            $table->string('tour_end_destination');
            $table->string('tour_location');
            $table->string('coupon_info');
            $table->integer('coupon_percentage');
            $table->integer('refund_percentage');
            $table->integer('coupon_fixed');
            $table->string('tour_start_time');
            $table->string('tour_end_time');
            $table->tinyInteger('payment_status')->default(1);
            $table->tinyInteger('purchase_status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_histories');
    }
};
