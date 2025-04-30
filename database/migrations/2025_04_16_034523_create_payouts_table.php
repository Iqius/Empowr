<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations. INI GA KEPAKE DI ERD
     */
    public function up(): void
    {
        Schema::create('payouts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('escrow_id');
            $table->unsignedBigInteger('profile_id');
            $table->unsignedBigInteger('payment_account_id');
            $table->float('amount');
            $table->enum('status', ['pending', 'processed', 'failed']);
            $table->dateTime('created_at');
            $table->dateTime('processed_at')->nullable();

            $table->foreign('escrow_id')->references('id')->on('escrow_payments')->onDelete('cascade');
            $table->foreign('profile_id')->references('user_id')->on('worker_profiles')->onDelete('cascade');
            $table->foreign('payment_account_id')->references('id')->on('user_payment_accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payouts');
    }
};
