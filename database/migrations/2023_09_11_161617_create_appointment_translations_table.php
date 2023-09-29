<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('appointment_translations', function (Blueprint $table) {
            // mandatory fields
            $table->id();
            $table->string('locale')->index();

            // Foreign key to the main model
            $table->unique(['appointment_id', 'locale']);
            $table->foreignId('appointment_id')->references('id')->on('appointments')->onDelete('cascade');

            // Actual fields you want to translate
            $table->string('name');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('appointment_translations');
    }
};
