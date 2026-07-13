<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    use HasFactory;

    protected $fillable = [
        'jenis_surat',
        'no_agenda',
        'no_surat',
        'tgl_surat',
        'tgl_diterima',
        'instansi_id',
        'perihal',
        'lampiran',
        'sifat_surat_id',
        'file_surat',
        'keterangan',
        'created_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function sifatSurat()
    {
        return $this->belongsTo(Sifatsurat::class, 'sifat_surat_id');
    }

    public function instansi()
    {
        return $this->belongsTo(Instansi::class, 'instansi_id');
    }
}
