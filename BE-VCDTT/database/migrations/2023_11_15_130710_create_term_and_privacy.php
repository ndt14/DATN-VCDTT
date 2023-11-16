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
        Schema::create('term_and_privacy', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->string('type')->nullable()->comment('1: term, 2: privacy, 3: other');
            $table->longText('content')->nullable();
            $table->tinyInteger('status')->default(2)->comment('1: active, 2: unActive');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('term_and_privacy');
    }
};
