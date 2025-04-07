<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // $table->string('profile_image')->nullable(); // Menyimpan path gambar
            $table->string('linkedin')->nullable(); // Menyimpan URL LinkedIn
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('linkedin');
        });
    }
};
