<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_payment_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');

            // ini hapus aja nanti
            $table->enum('account_type', ['ewallet', 'bank', 'Tidak ada'])->default('Tidak ada')->nullable();

            
            $table->string('account_number')->default('Tidak ada')->nullable();
            $table->string('bank_account_name')->default('Tidak ada')->nullable();
            $table->enum('bank_name',['BCA', 'BNI', 'BRI', 'Mandiri', 'CIMB Niaga', 'Danamon', 'Permata', 'BTN', 'Maybank', 'OCBC NISP', 'Panin', 'Bank Jago', 'BSI', 'Bank DKI', 'Bank Jabar Banten (BJB)', 'Bank Sumut', 'Bank Nagari', 'Bank Aceh', 'Bank Kaltimtara', 'Bank Kalsel', 'Bank Kalteng', 'Bank Papua', 'Bank NTB Syariah', 'Bank NTT', 'Bank Sulselbar',
            'Bank SulutGo', 'Bank Bengkulu', 'Bank Riau Kepri', 'Bank Maluku Malut', 'Bank Lampung', 'Bank Sumsel Babel', 'Tidak ada'])->default('Tidak ada')->nullable();
            $table->enum('ewallet_provider', ['Gopay','OVO','DANA','ShopeePay','LinkAja','Jenius Pay','Sakuku','iSaku','Paytren','Tidak ada'])->default('Tidak ada')->nullable();
            $table->string('wallet_number')->default('Tidak ada')->nullable();
            $table->string('ewallet_account_name')->default('Tidak ada')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_payment_accounts');
    }
};
