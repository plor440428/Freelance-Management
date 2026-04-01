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
        Schema::table('payment_proofs', function (Blueprint $table) {
            if (!Schema::hasColumn('payment_proofs', 'user_note')) {
                $table->text('user_note')->nullable()->after('proof_file');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_proofs', function (Blueprint $table) {
            if (Schema::hasColumn('payment_proofs', 'user_note')) {
                $table->dropColumn('user_note');
            }
        });
    }
};
