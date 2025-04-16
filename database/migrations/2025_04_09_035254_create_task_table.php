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

        if (!Schema::hasTable('task')) {
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
                $table->timestamps();

                $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('profile_id')->references('user_id')->on('worker_profiles')->onDelete('set null');
            });
        }

        if (!Schema::hasTable('task_applications')) {
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

        if (!Schema::hasTable('task_assignments')) {
            Schema::create('task_assignments', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('task_id');
                $table->unsignedBigInteger('profile_id');
                $table->unsignedBigInteger('assigned_by'); // Changed from uuid to unsignedBigInteger
                $table->enum('worker_status', ['assigned', 'accepted', 'declined']);
                $table->enum('client_status', ['pending', 'accepted', 'declined']);
                $table->dateTime('assigned_at');
                $table->dateTime('updated_at')->nullable();
                $table->dateTime('action_taken_at')->nullable();
                $table->enum('action_by', ['worker', 'client'])->nullable();
                $table->text('rejection_notes')->nullable();
                $table->dateTime('expired_time')->nullable();
        
                $table->foreign('task_id')->references('id')->on('task')->onDelete('cascade');
                $table->foreign('profile_id')->references('user_id')->on('worker_profiles')->onDelete('cascade');
            });
        }

        if (!Schema::hasTable('task_reviews')) {
            Schema::create('task_reviews', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('task_id');
                $table->unsignedBigInteger('client_id');
                $table->unsignedBigInteger('profile_id');
                $table->float('rating');
                $table->text('comment');
                $table->dateTime('created_at');
    
                $table->foreign('task_id')->references('id')->on('task')->onDelete('cascade');
                $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('profile_id')->references('user_id')->on('worker_profiles')->onDelete('cascade');
            });
        }
        
        if (!Schema::hasTable('escrow_payments')) {
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

        if (!Schema::hasTable('payouts')) {
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

        if (!Schema::hasTable('midtrans_transactions')) {
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

        if (!Schema::hasTable('arbitrase')) {
            Schema::create('arbitrase', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('task_id');
                $table->unsignedBigInteger('client_id');
                $table->unsignedBigInteger('worker_id');
                $table->text('reason');
                $table->enum('status', ['open', 'under review', 'resolved']);
                $table->dateTime('created_at');
    
                $table->foreign('task_id')->references('id')->on('task')->onDelete('cascade');
                $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('worker_id')->references('user_id')->on('worker_profiles')->onDelete('cascade');
            });
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arbitrase');
        Schema::dropIfExists('midtrans_transactions');
        Schema::dropIfExists('payouts');
        Schema::dropIfExists('escrow_payments');
        Schema::dropIfExists('task_reviews');
        Schema::dropIfExists('task_assignments');
        Schema::dropIfExists('task_applications');
        Schema::dropIfExists('task');
    }
};