<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JenisHewan extends Model
{
    protected $table ='jenis_hewan';
    
    protected $fillable = [
        'nama_jenis',
        //'jenisHewan_nama_log'
    ];

    protected $primaryKey = 'id_jenis';

    public function Hewan()
    {
        return $this->hasMany(Hewan::class);
    }

    public function HargaLayanan()
    {
        return $this->hasMany(HargaLayanan::class);
    }

    const CREATED_AT = 'jenisHewan_create_log';
    const UPDATED_AT = 'jenisHewan_edit_log';
}
