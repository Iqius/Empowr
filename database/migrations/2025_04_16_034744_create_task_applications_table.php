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
        Schema::create('task_applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id');
            $table->unsignedBigInteger('profile_id');
            $table->text('catatan');
            $table->float('bidPrice');
            $table->enum('status', ['pending', 'accepted', 'rejected']);
            $table->dateTime('applied_at');

            $table->foreign('task_id')->references('id')->on('task')->onDelete('cascade');
            $table->foreign('profile_id')->references('id')->on('worker_profiles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_applications');
    }
};
