<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuratsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('jenis_surat', ['masuk', 'keluar']);
            $table->string('no_agenda', 100)->nullable();
            $table->string('no_surat', 255);
            $table->date('tgl_surat');
            $table->date('tgl_diterima')->nullable();
            $table->unsignedBigInteger('instansi_id');
            $table->string('perihal', 255);
            $table->string('lampiran', 255)->nullable();
            $table->unsignedBigInteger('sifat_surat_id');
            $table->string('file_surat', 255);
            $table->text('keterangan')->nullable();
            $table->uuid('created_by');
            $table->timestamps();

            $table->foreign('sifat_surat_id')->references('id')->on('sifatsurats')->onDelete('restrict');
            $table->foreign('instansi_id')->references('id')->on('instansi')->restrictOnDelete();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('surats');
    }
}
