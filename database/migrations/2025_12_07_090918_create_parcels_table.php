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
        Schema::create('parcels', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('tracking_no')->unique();
            $table->enum('storage_no', ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10']);
            $table->date('delivery_date');
            $table->date('pickup_date')->nullable();
            $table->enum('status', ['pending', 'ready', 'delivered'])
                ->default('pending');
            $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parcels');
    }
};
