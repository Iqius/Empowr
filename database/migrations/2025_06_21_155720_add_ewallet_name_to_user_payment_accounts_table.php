<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('user_payment_accounts', function (Blueprint $table) {
            $table->string('ewallet_name')->nullable(); // 👈 tambahkan kolom ini
        });
    }

    public function down()
    {
        Schema::table('user_payment_accounts', function (Blueprint $table) {
            $table->dropColumn('ewallet_name');
        });
    }
};
