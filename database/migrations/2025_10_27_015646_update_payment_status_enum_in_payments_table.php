<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->enum('payment_status', ['pending', 'awaiting_verification', 'paid'])
                ->default('pending')
                ->change();
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->enum('payment_status', ['pending', 'paid'])
                ->default('pending')
                ->change();
        });
    }
};
