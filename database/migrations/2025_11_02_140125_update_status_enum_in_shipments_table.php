<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Change enum values to include 'approved'
        DB::statement("ALTER TABLE shipments MODIFY status ENUM('pending','approved','assigned','transit','delivered','cancelled') NOT NULL DEFAULT 'pending'");
    }

    public function down(): void
    {
        // Revert to original values
        DB::statement("ALTER TABLE shipments MODIFY status ENUM('pending','assigned','transit','delivered','cancelled') NOT NULL DEFAULT 'pending'");
    }
};

