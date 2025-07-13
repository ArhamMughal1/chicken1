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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained();
            $table->date('purchase_date');
            $table->string('driver_name');
            $table->string('vehicle_number',20);
            $table->decimal('load_weight',6,1,true);
            $table->decimal('net_weight',6,1,true);
            $table->decimal('short_weight',6,1,true);
            $table->decimal('rate_difference',5,2);
            $table->decimal('rate',5,2);
            $table->integer('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
