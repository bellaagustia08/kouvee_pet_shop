<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UkuranHewan extends Model
{
    protected $table = 'ukuran_hewan';

    protected $fillable = [
        'nama_ukuran',
        //'ukuranHewan_nama_log'
    ];

    protected $primaryKey = 'id_ukuran';

    public function Hewan()
    {
        return $this->hasMany(Hewan::class);
    }

    public function HargaLayanan()
    {
        return $this->hasMany(HargaLayanan::class);
    }

    const CREATED_AT = 'ukuranHewan_create_log';
    const UPDATED_AT = 'ukuranHewan_edit_log';
}
