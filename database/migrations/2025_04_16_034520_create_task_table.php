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
        Schema::create('task', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('profile_id')->nullable();
            $table->string('title');
            $table->text('description');
            $table->date('deadline');
            $table->date('deadline_promotion');
            $table->text('provisions');
            $table->decimal('price', 15, 2);
            $table->enum('status', ['open', 'in progress', 'completed']);
            $table->integer('revisions');
            $table->enum('taskType', ['it', 'nonIT']);
            $table->string('job_file')->nullable();
            $table->boolean('bayar')->default(false);
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('profile_id')->references('id')->on('worker_profiles')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task');
    }
};
