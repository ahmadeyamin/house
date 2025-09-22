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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vendor_id')->nullable()->constrained('vendors')->cascadeOnDelete();
            $table->string('name'); // cement, rod, sand, paint, etc.
            $table->string('unit')->nullable(); // kg, bag, piece, sqft
            $table->decimal('rate', 15, 2)->nullable();
            $table->integer('quantity_available')->default(0);
            $table->integer('quantity_used')->default(0);
            $table->integer('quantity_damaged')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
