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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('name');
            $table->decimal('area', 10, 2)
                ->nullable();
            $table->string('location')->nullable();
            $table->string('property_type')
                ->nullable();
            $table->string('car_code')
                ->nullable();
            $table->boolean('is_active')
                ->default(true);
            $table->string('status')
                ->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
