<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HargaLayanan extends Model
{
    //
    protected $table ='harga_layanan';

    protected $fillable = [
        'id_layanan',
        'id_jenis',
        'id_ukuran',
        'harga_layanan'
        //'hewan_nama_log'
    ];

    protected $primaryKey = 'id_harga_layanan';

    public function Layanan()
    {
        return $this->belongsTo(Layanan::class,'id_layanan');
    }

    public function JenisHewan()
    {
        return $this->belongsTo(JenisHewan::class,'id_jenis');
    }

    public function UkuranHewan()
    {
        return $this->belongsTo(UkuranHewan::class,'id_ukuran');
    }

    const CREATED_AT = 'harga_create_log';
    const UPDATED_AT = 'harga_edit_log';
}
