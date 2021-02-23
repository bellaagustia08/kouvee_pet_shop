<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table ='produk';
    
    protected $fillable = [
        'nama_produk', 
        'jumlah_stok_produk',
        'stok_minimum_produk', 
        'harga_produk',
        'gambar',
        'total_penjualan'
        //'produk_nama_log'
    ];

    protected $primaryKey = 'id_produk';

    const CREATED_AT = 'produk_create_log';
    const UPDATED_AT = 'produk_edit_log';

    public function Users(){
        return $this->belongsTo(User::class);
    }

    public function ItemPemesanan()
    {
        return $this->belongsTo(ItemPemesanan::class, 'id_produk');
    }
}
