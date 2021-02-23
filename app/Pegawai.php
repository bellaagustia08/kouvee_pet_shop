<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    //
    protected $table ='pegawai';
    
    protected $fillable = [
        'nama_pegawai',
        'alamat_pegawai',
        'tgl_lahir_pegawai',
        'no_telp_pegawai',
        'jabatan_pegawai',
        'password',
        //'pegawai_nama_log'
    ];

    protected $primaryKey = 'id_pegawai';

    const CREATED_AT = 'pegawai_create_log';
    const UPDATED_AT = 'pegawai_edit_log';
}
