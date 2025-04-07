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
        Schema::create('people_vehicle', function (Blueprint $table) {
            $table->foreignId('people_id')->constrained()->onDelete('cascade');
            $table->foreignId('vehicles_id')->constrained()->onDelete('cascade');
            $table->primary(['people_id', 'vehicles_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people_vehicle');
    }
};
