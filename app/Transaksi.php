<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    //

    protected $table = 'transaksi';

    protected $fillable = [
        'nama_transaksi',
        'status_transaksi',
        'tgl_transaksi',
        'jenis_transasi',
        'diskon',
        'total_pembayaran_pembelian',
        'id_hewan',
        'id_pegawai_cs',
        'id_pegawai_kasir'
    ];

    protected $primaryKey = 'id_transaksi';

    public function Hewan()
    {
        return $this->belongsTo(Hewan::class, 'id_hewan');
    }

    public function Member()
    {
        return $this->belongsTo(Member::class, 'id_member');
    }

    public function Pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai');
    }

    public function TransaksiLayanan()
    {
        return $this->belongsTo(TransaksiLayanan::class, 'id_item_transaksi');
    }

    public function ItemTransaksi()
    {
        return $this->belongsTo(ItemTransaksi::class, 'id_item_transaksi');
    }

    const CREATED_AT = NULL;
    const UPDATED_AT = NULL;
}
