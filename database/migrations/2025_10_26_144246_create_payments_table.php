<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('payments', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('order_id');
    $table->decimal('amount', 10, 2);
    $table->string('payment_method')->default('Pay on Pickup');
    $table->enum('payment_status', ['paid', 'pending'])->default('pending');
    $table->timestamp('payment_date')->nullable();
    $table->timestamps();

    // ✅ Correct foreign key reference
    $table->foreign('order_id')->references('order_id')->on('shipments')->onDelete('cascade');
});

    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
