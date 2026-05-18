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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('responsible_id')->constrained('users');
            $table->foreignId('student_id')->constrained('users');
            $table->enum('type',['entrada','saida']);
            $table->boolean('validated')->default(false);
            $table->string('reason')->nullable();
            $table->dateTime('scheduled_for');
            $table->boolean('comeback')->default(false);
            $table->dateTime('return_scheduled_for')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
