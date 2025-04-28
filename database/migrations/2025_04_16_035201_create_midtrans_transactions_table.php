<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations. INI GA KEPAKE NANTI HAPUS DI ERD NYA
     */
    public function up(): void
    {
        Schema::create('midtrans_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('task_id');
            $table->unsignedBigInteger('escrow_id');
            $table->enum('transaction_status', ['pending', 'success', 'failed', 'expired', 'refund']);
            $table->string('payment_type');
            $table->float('gross_amount');
            $table->json('midtrans_response');
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('task_id')->references('id')->on('task')->onDelete('cascade');
            $table->foreign('escrow_id')->references('id')->on('escrow_payments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('midtrans_transactions');
    }
};
