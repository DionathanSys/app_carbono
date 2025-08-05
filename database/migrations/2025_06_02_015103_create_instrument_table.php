<?php

use App\Models\Property;
use App\Models\User;
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
        Schema::create('instruments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(Property::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->string('type');
            $table->decimal('amount', 10, 2);
            $table->string('unit')
                ->nullable();
            $table->decimal('value', 10, 2)
                ->nullable();
            $table->string('description')
                ->nullable();
            $table->string('status');
            $table->boolean('is_active')
                ->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instruments');
    }
};
