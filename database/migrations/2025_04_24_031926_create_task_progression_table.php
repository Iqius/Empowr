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
        Schema::create('task_progression', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id');
            $table->string('path_file')->nullable();
            $table->unsignedBigInteger('action_by_client')->nullable(); 
            $table->unsignedBigInteger('action_by_worker')->nullable(); 
            $table->enum('status_upload', ['null', 'uploaded'])->default('null');
            $table->enum('status_approve', ['waiting', 'approved', 'rejected'])->default('waiting');
            $table->text('note')->nullable();
            $table->dateTime('date_upload')->nullable();
            $table->dateTime('date_approve')->nullable();
            $table->unsignedInteger('progression_ke');

            $table->timestamps();

            $table->foreign('task_id')->references('id')->on('task')->onDelete('cascade');
            $table->foreign('action_by_client')->references('id')->on('users');
            $table->foreign('action_by_worker')->references('id')->on('users');  
        });
    }
   
    /**
     * Reverse the migrationas.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_progression');
    }
};
