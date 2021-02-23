<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    //
    protected $table = 'member';

    protected $fillable = [
        'nama_member',
        'alamat_member',
        'tgl_lahir_member',
        'no_telp_member'
    ];

    protected $primaryKey = 'id_member';
    //protected $nama_member = 'nama_member';

    public function Hewan()
    {
        return $this->hasMany(Hewan::class);
    }

    const CREATED_AT = 'member_create_log';
    const UPDATED_AT = 'member_edit_log';
}
