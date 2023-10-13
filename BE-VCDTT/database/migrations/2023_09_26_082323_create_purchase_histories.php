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
            $table->bigInteger('user_id')->nullable();
            // $table->string('user_info')->nullable();

            // hotfix
            $table->string('name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone_number')->nullable();
            $table->string('address')->nullable();
            $table->tinyInteger('gender')->nullable();

            $table->string('user_name')->nullable();
            $table->string('tour_name')->nullable();
            $table->string('tour_duration')->nullable();
            $table->bigInteger('tour_child_price')->nullable();
            $table->integer('child_count')->nullable();
            $table->bigInteger('tour_adult_price')->nullable();
            $table->integer('adult_count')->nullable();
            $table->integer('tour_sale_percentage')->nullable();
            $table->string('tour_start_destination')->nullable();
            $table->string('tour_end_destination')->nullable();
            $table->string('tour_location')->nullable();
            $table->string('coupon_info')->nullable();
            $table->integer('coupon_percentage')->nullable();
            $table->integer('refund_percentage')->nullable();
            $table->integer('coupon_fixed')->nullable();
            $table->string('tour_start_time')->nullable();
            $table->string('tour_end_time')->nullable();
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
