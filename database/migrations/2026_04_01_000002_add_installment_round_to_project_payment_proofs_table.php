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
            $table->unsignedInteger('installment_round')->nullable()->after('submitted_as');
            $table->index(['project_id', 'installment_round']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_payment_proofs', function (Blueprint $table) {
            $table->dropIndex(['project_id', 'installment_round']);
            $table->dropColumn('installment_round');
        });
    }
};
