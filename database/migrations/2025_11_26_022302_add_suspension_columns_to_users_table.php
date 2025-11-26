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
    Schema::table('users', function (Blueprint $table) {
        $table->string('suspension_reason')->nullable();
        $table->enum('suspension_duration', ['1_week', '1_month', '3_months', 'custom', 'permanent'])->nullable();
        $table->date('suspension_end_date')->nullable();
        $table->text('suspension_message')->nullable();
        $table->timestamp('suspended_at')->nullable();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
