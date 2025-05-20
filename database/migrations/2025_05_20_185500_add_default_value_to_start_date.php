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
        Schema::table('pet_treatment', function (Blueprint $table) {
            $table->date('start_date')->default(now())->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pet_treatment', function (Blueprint $table) {
            $table->date('start_date')->default(null)->change();
        });
    }
};
