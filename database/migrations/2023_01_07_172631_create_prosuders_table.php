<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProsudersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prosuders', function (Blueprint $table) {
            $table->id();
            $table->string('name_bm')->nullable();
            $table->string('jabatan_bm')->nullable();
            $table->string('cabang_bm')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('options_id')->nullable();
            $table->text('tdm')->nullable();
            $table->string('mengetahui')->nullable();
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
        Schema::dropIfExists('prosuders');
    }
}
