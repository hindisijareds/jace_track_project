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
    Schema::table('users', function (Blueprint $table) {
        $table->string('first_name')->nullable();
        $table->string('middle_name')->nullable();
        $table->string('last_name')->nullable();
        $table->string('city')->nullable();
        $table->string('barangay')->nullable();
        $table->string('zip_code')->nullable();
        $table->string('detailed_address')->nullable();
        $table->string('contact_number')->nullable();
        $table->string('profile_picture')->nullable();
        $table->boolean('email_verified')->default(false);
        $table->boolean('phone_verified')->default(false);
        $table->boolean('info_locked')->default(false); // true if permission required
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
