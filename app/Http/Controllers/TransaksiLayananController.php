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

class TransaksiLayananController extends Controller
{
    //
    public function index()
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else if (Session::get('jabatan_pegawai') != 'Customer Service' && Session::get('jabatan_pegawai') != 'Admin') {
            return redirect('/')->with('status', 'Anda bukan merupakan CS atau admin');
        } else {
            $itemTransaksi = ItemTransaksi::with('Produk', 'HargaLayanan', 'Transaksi', 'JenisHewan')
                ->whereNotNull('id_harga_layanan')
                ->get();
            $transaksi = Transaksi::where('status_transaksi', 'BELUM LUNAS')
                ->where('jenis_transaksi', 'Layanan')
                ->where('jenis_transaksi', 'LAYANAN')
                ->get();
            $data = array(
                    'transaksi' => $transaksi,
                    'itemTransaksi' => $itemTransaksi
                );
            return view('transaksiLayanan.index', $data);
        }
    }

    public function indexMobile()
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else if (Session::get('jabatan_pegawai') != 'Customer Service' && Session::get('jabatan_pegawai') != 'Admin') {
            return redirect('/')->with('status', 'Anda bukan merupakan CS atau admin');
        } else {
            $index =  DB::table('item_transaksi')->get();
            return response()->json($index, 200);
        }
    }

    public function create()
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else if (Session::get('jabatan_pegawai') != 'Customer Service' && Session::get('jabatan_pegawai') != 'Admin') {
            return redirect('/')->with('status', 'Anda bukan merupakan CS atau admin');
        } else {
            $jenisHewan = JenisHewan::where('jenisHewan_delete_log', NULL)->get();
            $ukuranHewan = UkuranHewan::where('ukuranHewan_delete_log', NULL)->get();
            $hargaLayanan = HargaLayanan::with('Layanan', 'JenisHewan', 'UkuranHewan')->where('harga_delete_log', NULL)->get();
            $member = Member::where('member_delete_log', NULL)->get();
            $layanan = DB::table('layanan')->where('layanan_delete_log', NULL)->get();
            $hewan = Hewan::where('hewan_delete_log', NULL)->get();
            $data = array(
                'hargaLayanan' => $hargaLayanan,
                'layanan' => $layanan,
                'jenisHewan' => $jenisHewan,
                'ukuranHewan' => $ukuranHewan,
                'member' => $member,
                'hewan' => $hewan
            );
            return view('transaksiLayanan.create', $data);
        }
    }

    public function store(Request $request)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else if (Session::get('jabatan_pegawai') != 'Customer Service' && Session::get('jabatan_pegawai') != 'Admin') {
            return redirect('/')->with('status', 'Anda bukan merupakan CS atau admin');
        } else {
            $pegawaiCS = DB::table('pegawai')
                ->where([
                    ['id_pegawai', Session::get('id_pegawai')],
                ])
                ->first();

            $transaksi = new Transaksi;
            $transaksi->nama_transaksi = 'NULL';
            $transaksi->status_transaksi = 'NULL';
            $transaksi->tgl_transaksi = date('Y-m-d');
            $transaksi->jenis_transaksi = 'Layanan';
            $transaksi->diskon = 0;
            $transaksi->total_pembayaran_pembelian = 0;
            $transaksi->total_produk = 0;
            $transaksi->total_layanan = 0;
            $transaksi->id_hewan = $request->id_hewan;
            $transaksi->id_pegawai_cs = $pegawaiCS->id_pegawai;
            $transaksi->id_pegawai_kasir =  $pegawaiCS->id_pegawai;
            $transaksi->nama_transaksi = 'NULL';

            $transaksi->save();

            $request->validate([
                'id_harga_layanan' => 'required'
            ]);

            $hargaLayanan = DB::table('harga_layanan')
                ->where([
                    ['id_harga_layanan', $request->id_harga_layanan],
                ])
                ->first();

            $tabel_transaksi = DB::table('transaksi')
                ->where([
                    ['nama_transaksi', 'NULL'],
                    ['jenis_transaksi', 'Layanan']
                ])
                ->first();

            $itemTransaksi = new ItemTransaksi;
            $itemTransaksi->jumlah_item_transaksi = '1';
            $itemTransaksi->harga_item_transaksi = $hargaLayanan->harga_layanan;
            $itemTransaksi->status_layanan_item_transaksi = 'BELUM TERKONFIRMASI';
            $itemTransaksi->sub_total_item_transaksi = $hargaLayanan->harga_layanan;
            $itemTransaksi->id_harga_layanan = $request->id_harga_layanan;
            $itemTransaksi->id_transaksi = $tabel_transaksi->id_transaksi;


            Transaksi::where('id_transaksi', $tabel_transaksi->id_transaksi)
                ->update([
                    'nama_transaksi' => 'LY-' . date('dmy') . '-' . $tabel_transaksi->id_transaksi,
                    'status_transaksi' => 'BELUM LUNAS',
                    'jenis_transaksi' => 'Layanan',
                    'total_pembayaran_pembelian' => $hargaLayanan->harga_layanan,
                    'total_layanan' => $hargaLayanan->harga_layanan
                ]);

            $itemTransaksi->save();

            return redirect('/transaksiLayanan')->with('status', 'Data Transaksi Layanan Berhasil ditambahkan!');
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
                ->where('id_transaksi', $id)->get();
            $transaksiLayanan = $transaksiLayanan;
            $data = array(
                'transaksiLayanan' => $transaksiLayanan,
                'itemTransaksi' => $itemTransaksi
            );
            return view('transaksiLayanan.show', $data);
        }
    }

    public function edit(TransaksiLayanan $transaksiLayanan)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else if (Session::get('jabatan_pegawai') != 'Customer Service' && Session::get('jabatan_pegawai') != 'Admin') {
            return redirect('/')->with('status', 'Anda bukan merupakan CS atau admin');
        } else {
            $transaksiLayanan = $transaksiLayanan;
            $hargaLayanan = HargaLayanan::all();
            $data = array(
                'transaksiLayanan' => $transaksiLayanan,
                'hargaLayanan' => $hargaLayanan
            );
            return view('transaksiLayanan.edit', $data);
        }
    }


    public function update(Request $request, TransaksiLayanan $transaksiLayanan)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else if (Session::get('jabatan_pegawai') != 'Customer Service' && Session::get('jabatan_pegawai') != 'Admin') {
            return redirect('/')->with('status', 'Anda bukan merupakan CS atau admin');
        } else {
            $request->validate([
                'id_harga_layanan' => 'required'
            ]);

            $hargaLayanan = DB::table('harga_layanan')
                ->where([
                    ['id_harga_layanan', $transaksiLayanan->id_harga_layanan],
                ])
                ->first();

            TransaksiLayanan::where('id_item_transaksi', $transaksiLayanan->id_item_transaksi)
                ->update([
                    'id_harga_layanan' => $request->id_harga_layanan,
                    'sub_total_item_transaksi' => $hargaLayanan->harga_layanan
                ]);
            return redirect('/transaksiLayanan/{{$transaksiLayanan->id_transaksi}}')->with('status', 'Transaksi Layanan Berhasil diubah!');
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

            return redirect('/antrianHewan')->with('status', 'LAYANAN ' . $itemTransaksi->Transaksi->id_item_transaksi . ' SUDAH TERKONFIRMASI SELESAI');
        }
    }


    public function destroy(Request $request, Transaksi $transaksi)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else if (Session::get('jabatan_pegawai') != 'Customer Service' && Session::get('jabatan_pegawai') != 'Admin') {
            return redirect('/')->with('status', 'Anda bukan merupakan CS atau admin');
        } else {
            $transaksi->delete();
            if (Session::get('jabatan_pegawai') != 'Kasir') {
                return redirect('/penjualanProduk')->with('status', 'Item Layanan Berhasil dihapus!');
            } else if (Session::get('jabatan_pegawai') != 'Customer Service' && (Session::get('jabatan_pegawai') != 'Admin')) {
                return redirect('/transaksi')->with('status', 'Item Layanan Berhasil dihapus!');
            }
        }
    }

    // public function destroy(Request $request, Hewan $hewan)
    // {
    //     //Hewan::destroy($hewan->id_hewan);
    //     //return redirect('/hewan')->with('status', 'Data Hewan Berhasil dihapus!');
    //     if (!Session::get('login')) {
    //         return redirect('/')->with('status', 'Anda harus login dulu');
    //     }
    //     else if(Session::get('jabatan_pegawai') != 'Customer Service' && Session::get('jabatan_pegawai') != 'Admin'){
    //         return redirect('/')->with('status','Anda bukan merupakan CS atau admin');
    //     }
    //     else {
    //         $request->validate([
    //             'hewan_delete_log' => NOW()
    //         ]);

    //         Hewan::where('id_hewan', $hewan->id_hewan)
    //             ->update([
    //                 'hewan_delete_log' => NOW()
    //             ]);

    //         return redirect('/hewan')->with('status', 'Data Hewan Berhasil dihapus!');
    //     }
    // }

    public function search(Request $request)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else if (Session::get('jabatan_pegawai') != 'Customer Service' && Session::get('jabatan_pegawai') != 'Admin') {
            return redirect('/')->with('status', 'Anda bukan merupakan CS atau admin');
        } else {
            $search  = $request->get('search');

            $member = DB::table('member')->where('nama_member', 'like', '%' . $search . '%')->first();
            if ($member != NULL) {
                $hewan = DB::table('hewan')->where('id_member', $member->id_member)->first();
                $transaksi = DB::table('transaksi')
                    ->where([
                        ['id_hewan', $hewan->id_hewan],
                        ['status_transaksi', 'BELUM LUNAS'],
                        ['jenis_transaksi', 'Layanan']
                    ])
                    ->get();
                return view('transaksiLayanan.index',  compact('transaksi'));
            } else {
                $transaksi = DB::table('transaksi')
                    ->where([
                        ['nama_transaksi', 'like', '%' . $search . '%'],
                        ['status_transaksi', 'BELUM LUNAS'],
                        ['jenis_transaksi', 'Layanan']
                    ])
                    ->orWhere([
                        ['id_transaksi', 'like', '%' . $search . '%'],
                        ['status_transaksi', 'BELUM LUNAS'],
                        ['jenis_transaksi', 'Layanan']
                    ])
                    ->get();
                return view('transaksiLayanan.index',  compact('transaksi'));
            }
        }
    }
}
