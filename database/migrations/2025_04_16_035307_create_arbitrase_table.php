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
        Schema::create('arbitrase', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id');
            $table->text('reason');
            $table->enum('status', ['open', 'under review', 'resolved', 'cancelled']);
            $table->dateTime('created_at');
            $table->unsignedBigInteger('pelapor');
            

            $table->foreign('task_id')->references('id')->on('task')->onDelete('cascade');
            $table->foreign('pelapor')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arbitrase');
    }
};
