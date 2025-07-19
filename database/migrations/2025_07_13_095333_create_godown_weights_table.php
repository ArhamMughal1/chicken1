<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('godown_weights', function (Blueprint $table) {
            $table->id();
            $table->decimal('remaining_weight', 10, 2); // e.g., 950.25 Kg
            $table->date('date'); // The date this weight was recorded
            $table->text('notes')->nullable(); // Optional notes (e.g., "after restock")
            $table->timestamps(); // created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('godown_weights');
    }
};
