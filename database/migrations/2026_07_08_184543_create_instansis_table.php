<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstansisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instansis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode_instansi', 30)->nullable();
            $table->string('nama_instansi', 255);
            $table->enum('jenis_instansi', [
                'Kementerian',
                'Lembaga',
                'Pemerintah Provinsi',
                'Pemerintah Kabupaten/Kota',
                'OPD',
                'Kecamatan',
                'Kelurahan',
                'BUMN',
                'BUMD',
                'Swasta',
                'Perguruan Tinggi',
                'Organisasi',
                'Lainnya'
            ])->default('Lainnya');
            $table->text('alamat')->nullable();
            $table->string('telepon', 30)->nullable();
            $table->string('email')->nullable();
            $table->boolean('status')->default(true);
            $table->uuid('created_by')->nullable();
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
        Schema::dropIfExists('instansis');
    }
}
