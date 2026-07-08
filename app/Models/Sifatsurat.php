<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sifatsurat extends Model
{
    use HasFactory;

    protected $table = 'sifatsurats';
    protected $fillable = ['nama_sifat'];

    public function surat()
    {
        return $this->hasMany(Surat::class, 'sifat_surat_id');
    }
}
