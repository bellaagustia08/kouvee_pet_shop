<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\PenjualanProduk;
use App\Transaksi;
use App\Produk;
use App\HargaLayanan;
use App\Layanan;
use App\Member;
use App\Hewan;
use App\JenisHewan;
use App\UkuranHewan;
use App\ItemTransaksi;
use Illuminate\Http\Request;
use League\CommonMark\Extension\Table\Table;

class PenjualanProdukController extends Controller
{
    //
    public function index()
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else if (Session::get('jabatan_pegawai') != 'Customer Service' && Session::get('jabatan_pegawai') != 'Admin') {
            return redirect('/')->with('status', 'Anda bukan merupakan CS atau admin');
        } else {
            $penjualanProduk = PenjualanProduk::where('status_transaksi', 'BELUM LUNAS')
                ->where('jenis_transaksi', 'Produk')
                ->get();
            return view('penjualanProduk.index', compact('penjualanProduk'));
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
            $hewan = Hewan::where('hewan_delete_log', NULL)->get();
            $produk = Produk::where('produk_delete_log', NULL)->get();
            $data = array(
                'hargaLayanan' => $hargaLayanan,
                'produk' => $produk,
                'jenisHewan' => $jenisHewan,
                'ukuranHewan' => $ukuranHewan,
                'member' => $member,
                'hewan' => $hewan
            );
            return view('penjualanProduk.create', $data);
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
            $transaksi->jenis_transaksi = 'Produk';
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
                'jumlah_item_transaksi' => 'required',
                'id_produk' => 'required'
            ]);

            $produk = DB::table('produk')
                ->where([
                    ['id_produk', $request->id_produk],
                ])
                ->first();

            $tabel_transaksi = DB::table('transaksi')
                ->where([
                    ['nama_transaksi', 'NULL'],
                ])
                ->first();

            $stok_update = $produk->jumlah_stok_produk - $request->jumlah_item_transaksi;

            $itemTransaksi = new ItemTransaksi;
            $itemTransaksi->jumlah_item_transaksi = $request->jumlah_item_transaksi;
            $itemTransaksi->harga_item_transaksi = $produk->harga_produk;
            $itemTransaksi->status_layanan_item_transaksi = 'NULL';
            $itemTransaksi->sub_total_item_transaksi = $produk->harga_produk * $request->jumlah_item_transaksi;
            $itemTransaksi->id_produk = $request->id_produk;
            $itemTransaksi->id_transaksi = $tabel_transaksi->id_transaksi;

            Produk::where('id_produk', $request->id_produk)
                ->update([
                    'jumlah_stok_produk' => $stok_update
                ]);

            Transaksi::where('id_transaksi', $tabel_transaksi->id_transaksi)
                ->update([
                    'nama_transaksi' => 'PR-' . date('dmy') . '-' . $tabel_transaksi->id_transaksi,
                    'status_transaksi' => 'BELUM LUNAS',
                    'jenis_transaksi' => 'Produk',
                    'total_pembayaran_pembelian' => $produk->harga_produk * $request->jumlah_item_transaksi,
                    'total_produk' => $produk->harga_produk * $request->jumlah_item_transaksi
                ]);

            $itemTransaksi->save();

            return redirect('/penjualanProduk')->with('status', 'Data Penjualan Produk Berhasil ditambahkan!');
        }
    }


    public function show(PenjualanProduk $penjualanProduk)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else if (Session::get('jabatan_pegawai') != 'Customer Service' && Session::get('jabatan_pegawai') != 'Admin') {
            return redirect('/')->with('status', 'Anda bukan merupakan CS atau admin');
        } else {
            $id = $penjualanProduk->id_transaksi;
            $itemTransaksi = ItemTransaksi::with('Produk', 'HargaLayanan', 'Layanan', 'JenisHewan', 'UkuranHewan')
                ->where('id_transaksi', $id)->get();
            $penjualanProduk = $penjualanProduk;
            $data = array(
                'penjualanProduk' => $penjualanProduk,
                'itemTransaksi' => $itemTransaksi
            );
            return view('penjualanProduk.show', $data);
        }
    }

    public function edit(PenjualanProduk $penjualanProduk)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else if (Session::get('jabatan_pegawai') != 'Customer Service' && Session::get('jabatan_pegawai') != 'Admin') {
            return redirect('/')->with('status', 'Anda bukan merupakan CS atau admin');
        } else {
            $penjualanProduk = $penjualanProduk;
            $produk = Produk::all();
            $data = array(
                'penjualanProduk' => $penjualanProduk,
                'produk' => $produk
            );
            return view('penjualanProduk.edit', $data);
        }
    }


    public function update(Request $request, PenjualanProduk $penjualanProduk)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else if (Session::get('jabatan_pegawai') != 'Customer Service' && Session::get('jabatan_pegawai') != 'Admin') {
            return redirect('/')->with('status', 'Anda bukan merupakan CS atau admin');
        } else {
            $request->validate([
                'jumlah_item_transaksi' => 'required'
            ]);

            $produk = DB::table('produk')
                ->where([
                    ['id_produk', $penjualanProduk->id_produk],
                ])
                ->first();

            PenjualanProduk::where('id_item_transaksi', $penjualanProduk->id_item_transaksi)
                ->update([
                    'jumlah_item_transaksi' => $request->jumlah_item_transaksi,
                    'sub_total_item_transaksi' => ($request->jumlah_item_transaksi * $produk->harga_produk)
                ]);
            return redirect('/penjualanProduk/{{$penjualanProduk->id_transaksi}}')->with('status', 'Jumlah Penjualan Produk Berhasil diubah!');
        }
    }

    public function konfirmasi(Request $request, PenjualanProduk $penjualanProduk)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else if (Session::get('jabatan_pegawai') != 'Customer Service' && Session::get('jabatan_pegawai') != 'Admin') {
            return redirect('/')->with('status', 'Anda bukan merupakan CS atau admin');
        } else {
            $request->validate([
                'status_layanan_item_transaksi' => 'required'
            ]);

            $produk = DB::table('produk')
                ->where([
                    ['id_produk', $penjualanProduk->id_produk],
                ])
                ->first();

            PenjualanProduk::where('id_item_transaksi', $penjualanProduk->id_item_transaksi)
                ->update([
                    'status_layanan_item_transaksi' => $request->status_layanan_item_transaksi,
                ]);
            return redirect('/penjualanProduk')->with('status', $request->status_layanan_item_transaksi);
        }
    }


    public function destroy(Request $request, PenjualanProduk $penjualanProduk)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else if (Session::get('jabatan_pegawai') != 'Customer Service' && Session::get('jabatan_pegawai') != 'Admin') {
            return redirect('/')->with('status', 'Anda bukan merupakan CS atau admin');
        } else {
            $penjualanProduk->delete();
            if (Session::get('jabatan_pegawai') != 'Kasir') {
                return redirect('/penjualanProduk')->with('status', 'Item Berhasil dihapus!');
            } else if (Session::get('jabatan_pegawai') != 'Customer Service' && (Session::get('jabatan_pegawai') != 'Admin')) {
                return redirect('/transaksi')->with('status', 'Item Berhasil dihapus!');
            }
        }
    }

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
                $penjualanProduk = DB::table('transaksi')
                    ->where([
                        ['id_hewan', $hewan->id_hewan],
                        ['status_transaksi', 'BELUM LUNAS'],
                        ['jenis_transaksi', 'Produk']
                    ])
                    ->get();
                return view('penjualanProduk.index',  compact('penjualanProduk'));
            } else {
                $penjualanProduk = DB::table('transaksi')
                    ->where([
                        ['nama_transaksi', 'like', '%' . $search . '%'],
                        ['status_transaksi', 'BELUM LUNAS'],
                        ['jenis_transaksi', 'Produk']
                    ])
                    ->orWhere([
                        ['id_transaksi', 'like', '%' . $search . '%'],
                        ['status_transaksi', 'BELUM LUNAS'],
                        ['jenis_transaksi', 'Produk']
                    ])
                    ->get();
                return view('penjualanProduk.index',  compact('penjualanProduk'));
            }
        }
    }
}
