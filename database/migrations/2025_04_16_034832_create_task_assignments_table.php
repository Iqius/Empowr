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
        Schema::create('task_assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id');
            $table->unsignedBigInteger('profile_id');
            $table->unsignedBigInteger('assigned_by'); // Changed from uuid to unsignedBigInteger
            $table->enum('worker_status', ['assigned', 'accepted', 'declined']);
            $table->enum('client_status', ['pending', 'accepted', 'declined']);
            $table->dateTime('assigned_at');
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('action_taken_at')->nullable();
            $table->enum('action_by', ['worker', 'client'])->nullable();
            $table->text('rejection_notes')->nullable();
            $table->dateTime('expired_time')->nullable();
    
            $table->foreign('task_id')->references('id')->on('task')->onDelete('cascade');
            $table->foreign('profile_id')->references('user_id')->on('worker_profiles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_assignments');
    }
};
