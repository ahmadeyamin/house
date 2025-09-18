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
        Schema::create('damages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('related_item_type')->nullable(); // material, rental, other
            $table->unsignedBigInteger('related_item_id')->nullable();
            $table->text('description')->nullable();
            $table->decimal('damage_cost', 15, 2)->nullable();
            $table->string('responsible_party')->nullable(); // vendor, worker, unknown
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('damages');
    }
};
