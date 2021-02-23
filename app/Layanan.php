<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $table ='layanan';
    
    protected $fillable = [
        'nama_layanan',
        //'layanan_nama_log'
    ];

    protected $primaryKey = 'id_layanan';

    const CREATED_AT = 'layanan_create_log';
    const UPDATED_AT = 'layanan_edit_log';

    public function HargaLayanan()
    {
        return $this->hasMany(HargaLayanan::class);
    }
}
