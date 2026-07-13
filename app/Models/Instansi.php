<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instansi extends Model
{
    use HasFactory;

    protected $table = 'instansis';

    protected $fillable = [
        'kode_instansi',
        'nama_instansi',
        'jenis_instansi',
        'alamat',
        'telepon',
        'email',
        'status',
        'created_by'
    ];

    public function surat()
    {
        return $this->hasMany(Surat::class, 'instansi_id', 'id');
    }
}
