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
    Schema::table('shipments', function (Blueprint $table) {
    if (!Schema::hasColumn('shipments', 'proof_of_delivery')) {
        $table->string('proof_of_delivery')->nullable();
    }
    if (!Schema::hasColumn('shipments', 'proof_status')) {
        $table->string('proof_status')->default('pending');
    }
});

}

public function down()
{
    Schema::table('shipments', function (Blueprint $table) {
        $table->dropColumn(['proof_of_delivery', 'proof_status', 'delivered_at']);
    });
}

};
