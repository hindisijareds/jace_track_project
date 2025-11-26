<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id('order_id');
            $table->string('tracking_number')->unique();
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['pending', 'cancelled', 'delivered'])->default('pending');

            // Parcel details
            $table->string('item_name');
            $table->string('item_type')->nullable();
            $table->string('parcel_type')->nullable();
            $table->float('parcel_weight');
            $table->float('dimension_l')->nullable();
            $table->float('dimension_w')->nullable();
            $table->float('dimension_h')->nullable();
            $table->decimal('parcel_value', 10, 2)->nullable();

            // Sender
            $table->string('sender_name');
            $table->string('sender_phone');
            $table->string('sender_address');
            $table->string('sender_detailed')->nullable();

            // Receiver
            $table->string('receiver_name');
            $table->string('receiver_phone');
            $table->string('receiver_address');
            $table->string('receiver_detailed')->nullable();

            // Cost breakdown
            $table->decimal('distance_km', 10, 2)->nullable();
            $table->decimal('fuel_liters', 10, 3)->nullable();
            $table->decimal('fuel_cost', 10, 2)->nullable();
            $table->decimal('maintenance_cost', 10, 2)->nullable();
            $table->decimal('box_size_cost', 10, 2)->nullable();
            $table->decimal('box_weight_cost', 10, 2)->nullable();
            $table->decimal('box_total_cost', 10, 2)->nullable();
            $table->decimal('total_cost', 10, 2)->nullable();

            // Dates
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('delivered_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
