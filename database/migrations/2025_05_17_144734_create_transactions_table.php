<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->string('order_id')->unique();
            $table->unsignedBigInteger('task_id')->nullable();
            $table->unsignedBigInteger('worker_id')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();

            $table->decimal('amount', 15, 2);

            $table->enum('status', ['pending', 'success', 'cancel', 'expire']);
            $table->enum('payment_method', ['direct', 'ewallet']);
            $table->enum('type', ['payment', 'payout', 'topup', 'salary']);

            $table->timestamps();

            // Foreign key constraints
            $table->foreign('task_id')->references('id')->on('task')->onDelete('cascade');
            $table->foreign('worker_id')->references('id')->on('worker_profiles')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');
        });
    }


    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
