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
        Schema::create('task_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id');
            $table->unsignedBigInteger('user_id');  // User yang memberikan ulasan (client atau worker)
            $table->unsignedBigInteger('reviewed_user_id');  // User yang menerima ulasan (client atau worker)
            $table->integer('rating');
            $table->text('comment')->nullable();
            $table->timestamps();  // untuk menyimpan waktu ulasan diberikan

            // Foreign keys
            $table->foreign('task_id')->references('id')->on('task')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('reviewed_user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_reviews');
    }
};
