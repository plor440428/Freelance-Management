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
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('note');
            $table->decimal('reviewed_amount', 10, 2)->nullable()->after('status');
            $table->text('review_note')->nullable()->after('reviewed_amount');
            $table->foreignId('reviewed_by')->nullable()->after('review_note')->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable()->after('reviewed_by');

            $table->index(['project_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_payment_proofs', function (Blueprint $table) {
            $table->dropConstrainedForeignId('reviewed_by');
            $table->dropIndex(['project_id', 'status']);
            $table->dropColumn(['status', 'reviewed_amount', 'review_note', 'reviewed_at']);
        });
    }
};
