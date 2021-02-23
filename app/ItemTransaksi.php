<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemTransaksi extends Model
{
    //
    protected $table = 'item_transaksi';

    protected $fillable = [
        'jumlah_item_transaksi',
        'harga_item_transaksi',
        'sub_total_item_transaksi',
        'status_layanan_item_transaksi',
        'id_produk',
        'id_harga_layanan',
        'id_transaksi'
    ];

    protected $primaryKey = 'id_item_transaksi';

    public function Produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }

    public function HargaLayanan()
    {
        return $this->belongsTo(HargaLayanan::class, 'id_harga_layanan');
    }

    public function Layanan()
    {
        return $this->belongsTo(Layanan::class, 'id_layanan');
    }
    public function JenisHewan()
    {
        return $this->belongsTo(JenisHewan::class, 'id_jenis');
    }
    public function UkuranHewan()
    {
        return $this->belongsTo(UkuranHewan::class, 'id_ukuuran');
    }

    public function Transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }

    public function Member()
    {
        return $this->belongsTo(Member::class, 'id_member');
    }

    const CREATED_AT = NULL;
    const UPDATED_AT = NULL;
}
