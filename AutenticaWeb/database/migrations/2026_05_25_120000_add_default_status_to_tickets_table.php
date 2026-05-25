<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('tickets')) {
            return;
        }

        DB::statement("ALTER TABLE tickets MODIFY COLUMN status ENUM('pendente', 'lida', 'confirmada') NOT NULL DEFAULT 'pendente'");
    }

    public function down(): void
    {
        if (! Schema::hasTable('tickets')) {
            return;
        }

        DB::statement("ALTER TABLE tickets MODIFY COLUMN status ENUM('pendente', 'lida', 'confirmada') NOT NULL");
    }
};
