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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->foreignId('assigned_to')->constrained('users')->cascadeOnDelete();
            $table->string('judul_task');
            $table->text('deskripsi')->nullable();
            $table->enum('kesulitan', ['low', 'medium', 'high', 'critical'])->nullable();
            $table->enum('status', ['rencana', 'sedang_dikerjakan', 'tinjauan', 'selesai', 'dibatalkan']);
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_tenggat')->nullable();
            $table->decimal('estimasi', 5, 2)->nullable();
            $table->integer('progress')->default(0);
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
