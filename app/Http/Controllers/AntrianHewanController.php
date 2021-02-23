<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\TransaksiLayanan;
use App\HargaLayanan;
use App\Transaksi;
use App\Layanan;
use App\JenisHewan;
use App\Hewan;
use App\Member;
use App\UkuranHewan;
use App\Produk;
use App\ItemTransaksi;
use Nexmo\Laravel\Facade\Nexmo;

use Illuminate\Http\Request;
use League\CommonMark\Extension\Table\Table;

class AntrianHewanController extends Controller
{
    //
    public function index()
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else if (Session::get('jabatan_pegawai') != 'Customer Service' && Session::get('jabatan_pegawai') != 'Admin') {
            return redirect('/')->with('status', 'Anda bukan merupakan CS atau admin');
        } else {
            $transaksi = Transaksi::where('status_transaksi', 'NOT SUCCESS')
            ->where('jenis_transaksi', 'Layanan')
            ->where('jenis_transaksi', 'LAYANAN')
            ->get();
            $itemTransaksi = ItemTransaksi::with('Produk', 'HargaLayanan', 'Layanan', 'JenisHewan', 'UkuranHewan', 'Member')
            ->where('status_layanan_item_transaksi','BELUM SELESAI')
            ->whereNotNull('id_harga_layanan')
            ->get();
            $data = array(
                'transaksi' => $transaksi,
                'itemTransaksi' => $itemTransaksi
            );
            return view('antrianHewan.index', $data);
        }
    }

    public function show(TransaksiLayanan $transaksiLayanan)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else if (Session::get('jabatan_pegawai') != 'Customer Service' && Session::get('jabatan_pegawai') != 'Admin') {
            return redirect('/')->with('status', 'Anda bukan merupakan CS atau admin');
        } else {
            $id = $transaksiLayanan->id_transaksi;
            $itemTransaksi = ItemTransaksi::with('Produk', 'HargaLayanan', 'Layanan', 'JenisHewan', 'UkuranHewan', 'Member')
            ->where('id_transaksi', $id)
            ->get();
            $transaksiLayanan = $transaksiLayanan;
            $data = array(
                'transaksiLayanan' => $transaksiLayanan,
                'itemTransaksi' => $itemTransaksi
            );
            return view('antrianHewan.show', $data);
        }
    }

    public function konfirmasi(Request $request, ItemTransaksi $itemTransaksi)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else if (Session::get('jabatan_pegawai') != 'Customer Service' && Session::get('jabatan_pegawai') != 'Admin') {
            return redirect('/')->with('status', 'Anda bukan merupakan CS atau admin');
        } else {
            ItemTransaksi::where('id_item_transaksi', $itemTransaksi->id_item_transaksi)
                ->update([
                    'status_layanan_item_transaksi' => 'SELESAI'
                ]);

            return redirect('/transaksiLayanan')->with('status', 'LAYANAN ' . $itemTransaksi->id_item_transaksi . ' SUDAH TERKONFIRMASI SELESAI');
        }
    }
}
