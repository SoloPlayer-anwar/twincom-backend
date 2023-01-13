<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->text('avatar')->nullable();
            $table->string('contact')->nullable();
            $table->text('address')->nullable();
            $table->string('gender')->nullable();
            $table->text('fcm')->nullable();
            $table->string('cabang')->nullable();
            $table->enum('role', ['ADMIN', 'BM', 'KARYAWAN', 'MAGANG', 'MEMBER'])->default('MEMBER');
            $table->string('shift')->nullable();
            $table->string('tanggal')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
