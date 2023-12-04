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
        Schema::table('tours_to_categories', function (Blueprint $table) {
            //
            $table->bigInteger('id_cate_before')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tours_to_categories', function (Blueprint $table) {
            //
        });
    }
};
