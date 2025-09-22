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
        Schema::create('rents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->foreignId('vendor_id')->constrained('vendors')->cascadeOnDelete();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->decimal('rate', 15, 2)->nullable();
            $table->enum('billing_cycle', ['daily', 'weekly', 'monthly', 'usage', 'fixed'])->nullable();
            $table->decimal('total_cost', 15, 2)->nullable();
            $table->text('details')->nullable();
            $table->enum('status', ['active', 'returned'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rents');
    }
};
