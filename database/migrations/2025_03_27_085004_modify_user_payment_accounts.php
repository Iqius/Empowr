<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        Schema::table('user_payment_accounts', function (Blueprint $table) {
            // Ubah nama kolom
            $table->renameColumn('account_number', 'wallet_number');
            $table->renameColumn('account_name', 'ewallet_name');

            // Tambahkan kolom baru
            $table->string('bank_number')->nullable()->after('bank_name');
            $table->string('pemilik_bank')->nullable()->after('bank_number');

            // Ubah bank_name jadi ENUM
            DB::statement("ALTER TABLE user_payment_accounts MODIFY COLUMN bank_name ENUM('bca', 'bni', 'bri', 'mandiri') NOT NULL");
        });
    }

    public function down()
    {
        Schema::table('user_payment_accounts', function (Blueprint $table) {
            // Kembalikan perubahan jika rollback
            $table->renameColumn('wallet_number', 'account_number');
            $table->renameColumn('ewallet_name', 'account_name');

            $table->dropColumn('bank_number');
            $table->dropColumn('pemilik_bank');

            // Kembalikan tipe data bank_name ke string
            DB::statement("ALTER TABLE user_payment_accounts MODIFY COLUMN bank_name VARCHAR(255) NOT NULL");
        });
    }
};
