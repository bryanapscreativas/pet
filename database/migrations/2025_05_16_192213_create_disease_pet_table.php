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
        Schema::create('disease_pet', function (Blueprint $table) {
            $table->id();
            $table->foreignUlid('pet_id')->constrained()->onDelete('cascade');
            $table->foreignId('disease_id')->constrained()->onDelete('cascade');
            $table->text('treatment')->nullable();
            $table->date('diagnosis_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->unique(['pet_id', 'disease_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disease_pet');
    }
};
