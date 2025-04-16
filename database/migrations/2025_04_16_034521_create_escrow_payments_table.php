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
        Schema::create('escrow_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id');
            $table->unsignedBigInteger('profile_id');
            $table->float('amount');
            $table->enum('status', ['holding', 'released', 'disputed']);
            $table->dateTime('created_at');
            $table->dateTime('released_at')->nullable();

            $table->foreign('task_id')->references('id')->on('task')->onDelete('cascade');
            $table->foreign('profile_id')->references('user_id')->on('worker_profiles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('escrow_payments');
    }
};
