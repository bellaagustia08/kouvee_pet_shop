<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hewan extends Model
{
    //
    protected $table ='hewan';

    protected $fillable = [
        'nama_hewan',
        'tgl_lahir_hewan',
        'id_jenis',
        'id_ukuran',
        'id_member',
        //'hewan_nama_log'
    ];

    protected $primaryKey = 'id_hewan';

    public function Member()
    {
        return $this->belongsTo(Member::class,'id_member');
    }

    public function JenisHewan()
    {
        return $this->belongsTo(JenisHewan::class,'id_jenis');
    }

    public function UkuranHewan()
    {
        return $this->belongsTo(UkuranHewan::class,'id_ukuran');
    }

    const CREATED_AT = 'hewan_create_log';
    const UPDATED_AT = 'hewan_edit_log';
}
