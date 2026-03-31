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
        Schema::table('project_payment_proofs', function (Blueprint $table) {
            $table->timestamp('transfer_at')->nullable()->after('amount');
            $table->index('transfer_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_payment_proofs', function (Blueprint $table) {
            $table->dropIndex(['transfer_at']);
            $table->dropColumn('transfer_at');
        });
    }
};
