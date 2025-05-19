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
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('other_user_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('last_time_message')->nullable();
            $table->integer('unread_count')->default(0);
            $table->timestamps();
            
            // Ensuring a user can only have one conversation with another user
            $table->unique(['user_id', 'other_user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};