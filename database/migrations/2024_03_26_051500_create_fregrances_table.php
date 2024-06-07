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
        Schema::create('fragrances', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('concentration')->nullable();
            $table->foreignId('bottle_id')->constrained('products');
            $table->integer('gram')->nullable();
            $table->integer('mililiter')->nullable();
            $table->double('pump_weight')->nullable();
            $table->double('bottle_weight')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fregrances');
    }
};
