<?php

use App\Models\Instrument;
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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Instrument::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->string('certificate_number');
            $table->string('type');
            $table->string('path')
                ->nullable();
            $table->string('status');
            $table->date('expiration_date');
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
        Schema::dropIfExists('certificates');
    }
};
