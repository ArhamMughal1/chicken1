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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained();
            $table->date('sale_date');
            $table->decimal('rate_difference',5,2);
            $table->decimal('rate',5,2);
            $table->decimal('weight',6,1,true);
            $table->decimal('amount',8,0,true);
            $table->integer('amount_paid')->unsigned();
            $table->integer('arrears');
            $table->integer('previous_arrears')->default(0);
            $table->integer('total_arrears')->default(0);
            $table->enum('sale_type', ['cash', 'credit'])->default('cash');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
