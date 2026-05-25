<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('tickets') || ! Schema::hasColumn('tickets', 'student_id')) {
            return;
        }

        Schema::table('tickets', function (Blueprint $table) {
            $table->string('student_name')->nullable()->after('responsible_id');
        });

        $tickets = DB::table('tickets')->whereNotNull('student_id')->get();

        foreach ($tickets as $ticket) {
            $name = DB::table('users')->where('id', $ticket->student_id)->value('name');
            DB::table('tickets')->where('id', $ticket->id)->update([
                'student_name' => $name ?? 'Aluno',
            ]);
        }

        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
            $table->dropColumn('student_id');
        });

        DB::statement('ALTER TABLE tickets MODIFY student_name VARCHAR(255) NOT NULL');
    }

    public function down(): void
    {
        if (! Schema::hasTable('tickets') || Schema::hasColumn('tickets', 'student_id')) {
            return;
        }

        Schema::table('tickets', function (Blueprint $table) {
            $table->foreignId('student_id')->nullable()->after('responsible_id')->constrained('users');
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn('student_name');
        });
    }
};
