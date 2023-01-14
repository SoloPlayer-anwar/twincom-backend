<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenilayansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penilayans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->string('name_pemberi')->nullable();
            $table->string('jabatan_pemberi')->nullable();
            $table->string('cabang_pemberi')->nullable();
            $table->double('pemahaman_tugas');
            $table->double('kecekatan_bekerja');
            $table->double('kreatifitas_bekerja');
            $table->double('pengambil_keputusan');
            $table->double('kejujuran');
            $table->double('kedewasaan_berpikir');
            $table->double('tanggung_jawab');
            $table->double('kemandirian');
            $table->double('disiplin');
            $table->double('antusias');
            $table->double('komunikasi');
            $table->double('kerjasama_team');
            $table->double('empati');
            $table->string('tanggal')->nullable();
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
        Schema::dropIfExists('penilayans');
    }
}
