<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    //
    protected $table ='supplier';
    
    protected $fillable = [
        'nama_supplier',
        'alamat_supplier',
        'no_telp_supplier',
        //'supplier_nama_log'
    ];

    protected $primaryKey = 'id_supplier';

    const CREATED_AT = 'supplier_create_log';
    const UPDATED_AT = 'supplier_edit_log';
}
