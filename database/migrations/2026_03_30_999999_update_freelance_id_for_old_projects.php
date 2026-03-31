<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Set freelance_id = created_by for old projects where freelance_id is null
        DB::statement("UPDATE projects SET freelance_id = created_by WHERE freelance_id IS NULL AND created_by IS NOT NULL");
    }

    public function down(): void
    {
        // Optional: Set freelance_id back to null (not usually needed)
        // DB::statement("UPDATE projects SET freelance_id = NULL WHERE freelance_id = created_by");
    }
};
