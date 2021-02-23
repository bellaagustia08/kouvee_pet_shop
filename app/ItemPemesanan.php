<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemPemesanan extends Model
{
    //
    protected $table = 'item_pemesanan';

    protected $fillable = [
        'satuan_item_pemesanan',
        'jumlah_item_pemesanan',
        'harga_item_pemesanan',
        'sub_total_item_pemesanan',
        'id_produk',
        'id_pemesanan'
    ];

    protected $primaryKey = 'id_item_pemesanan';

    public function Produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }

    public function Pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'id_pemesanan');
    }

    const CREATED_AT = NULL;
    const UPDATED_AT = NULL;
}
