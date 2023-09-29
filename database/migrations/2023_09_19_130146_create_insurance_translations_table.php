<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('insurance_translations', function (Blueprint $table) {
            // mandatory fields
            $table->id();
            $table->string('locale')->index();

            // Foreign key to the main model
            $table->unique(['insurance_id', 'locale','name']);
            $table->foreignId('insurance_id')->references('id')->on('insurances')->onDelete('cascade');

            // Actual fields you want to translate
            $table->string('name');
            $table->string('notes')->nullable();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('insurance_translations');
    }
};
