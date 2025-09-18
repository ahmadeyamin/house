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
            $table->string('name'); // cement, rod, sand, paint, etc.
            $table->string('unit')->nullable(); // kg, bag, piece, sqft
            $table->decimal('unit_price', 15, 2)->nullable();
            $table->integer('quantity_purchased')->default(0);
            $table->integer('quantity_used')->default(0);
            $table->integer('damaged_quantity')->default(0);
            $table->foreignId('vendor_id')->nullable()->constrained('vendors')->cascadeOnDelete();
            $table->date('purchase_date')->nullable();
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
