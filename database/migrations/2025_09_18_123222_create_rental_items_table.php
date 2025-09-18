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
        Schema::create('rental_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('item_name');
            $table->foreignId('vendor_id')->constrained('vendors')->cascadeOnDelete();
            $table->date('rent_start_date');
            $table->date('rent_end_date')->nullable();
            $table->decimal('rent_cost_per_day', 15, 2)->nullable();
            $table->decimal('total_cost', 15, 2)->nullable();
            $table->string('status')->default('active'); // active, returned, damaged
            $table->decimal('damage_cost', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_items');
    }
};
