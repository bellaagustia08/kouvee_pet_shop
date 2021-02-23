<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    //
    protected $table = "pemesanan";

    protected $fillable = [
        'nama_pemesanan',
        'status_pemesanan',
        'tgl_pemesanan',
        'total_pembayaran_pemesanan',
        'id_supplier',
        'id_pegawai'
    ];

    protected $primaryKey = 'id_pemesanan';

    public function Produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }

    public function ItemPemesanan()
    {
        return $this->hasMany(ItemPemesanan::class, 'id_item_pemesanan');
    }

    public function Supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier');
    }

    public function Pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai');
    }

    const CREATED_AT = NULL;
    const UPDATED_AT = NULL;
}
