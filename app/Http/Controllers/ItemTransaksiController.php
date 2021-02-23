<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\ItemTransaksi;
use App\Produk;
use App\HargaLayanan;
use App\Hewan;
use App\JenisHewan;
use App\Member;
use App\Transaksi;
use App\PenjualanProduk;
use Nexmo\Laravel\Facade\Nexmo;
use Illuminate\Http\Request;
use League\CommonMark\Extension\Table\Table;

class ItemTransaksiController extends Controller
{

    public function index()
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else if (Session::get('jabatan_pegawai') != 'Kasir' && Session::get('jabatan_pegawai') != 'Customer Service' && Session::get('jabatan_pegawai') != 'Admin') {
            return redirect('/')->with('status', 'Anda bukan merupakan Pegawai');
        } else {
            $i = 1;
            $itemTransaksi = ItemTransaksi::with('Produk', 'HargaLayanan', 'Transaksi', 'JenisHewan')->where('status_layanan_item_transaksi', 'TERKONFIRMASI')->get();
            $data = array(
                'i' => $i,
                'itemTransaksi' => $itemTransaksi
            );
            return view('itemTransaksi.index', $data);
        }
    }

    public function indexMobile()
    {
        $index =  DB::table('itemTransaksi')->get();
        return response()->json($index, 200);
    }


    public function create(PenjualanProduk $penjualanProduk)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else if (Session::get('jabatan_pegawai') != 'Customer Service' && Session::get('jabatan_pegawai') != 'Admin') {
            return redirect('/')->with('status', 'Anda bukan merupakan CS atau admin');
        } else {
            $id = $penjualanProduk->id_transaksi;
            $produk = Produk::where('produk_delete_log', NULL)->get();
            $data = array(
                'produk' => $produk,
                'id' => $id
            );
            return view('itemTransaksi.create', $data);
        }
    }


    public function store(Request $request)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else if (Session::get('jabatan_pegawai') != 'Customer Service' && Session::get('jabatan_pegawai') != 'Admin') {
            return redirect('/')->with('status', 'Anda bukan merupakan CS atau admin');
        } else {
            $produk = DB::table('produk')
                ->where([
                    ['id_produk', $request->id_produk],
                ])
                ->first();

            $tabel_transaksi = DB::table('transaksi')
                ->where([
                    ['id_transaksi', $request->id_transaksi],
                ])
                ->first();

            $stok_update = $produk->jumlah_stok_produk - $request->jumlah_item_transaksi;

            $itemTransaksi = new ItemTransaksi;
            $itemTransaksi->jumlah_item_transaksi = $request->jumlah_item_transaksi;
            $itemTransaksi->harga_item_transaksi = $produk->harga_produk;
            $itemTransaksi->status_layanan_item_transaksi = 'BELUM TERKONFIRMASI';
            $itemTransaksi->sub_total_item_transaksi = $produk->harga_produk * $request->jumlah_item_transaksi;
            $itemTransaksi->id_produk = $request->id_produk;
            $itemTransaksi->id_transaksi = $request->id_transaksi;

            Produk::where('id_produk', $request->id_produk)
                ->update([
                    'jumlah_stok_produk' => $stok_update
                ]);

            $harga_update = ($produk->harga_produk * $request->jumlah_item_transaksi) + $tabel_transaksi->total_pembayaran_pembelian;

            Transaksi::where('id_transaksi', $tabel_transaksi->id_transaksi)
                ->update([
                    'total_pembayaran_pembelian' => $harga_update,
                ]);

            $itemTransaksi->save();
            return redirect('/penjualanProduk')->with('status', 'Data Penjualan Produk Berhasil ditambahkan!');
        }
    }

    public function edit(ItemTransaksi $itemTransaksi)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else if (Session::get('jabatan_pegawai') != 'Kasir' && Session::get('jabatan_pegawai') != 'Customer Service' && Session::get('jabatan_pegawai') != 'Admin') {
            return redirect('/')->with('status', 'Anda bukan merupakan Pegawai');
        } else {
            $itemTransaksi = $itemTransaksi;
            $hargaLayanan = HargaLayanan::where('harga_delete_log', NULL)->get();
            $data = array(
                'itemTransaksi' => $itemTransaksi,
                'hargaLayanan' => $hargaLayanan
            );
            return view('itemTransaksi.edit', $data);
        }
    }


    public function update(Request $request, ItemTransaksi $itemTransaksi)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else if (Session::get('jabatan_pegawai') != 'Kasir' && Session::get('jabatan_pegawai') != 'Customer Service' && Session::get('jabatan_pegawai') != 'Admin') {
            return redirect('/')->with('status', 'Anda bukan merupakan Pegawai');
        } else {
            if ($itemTransaksi->id_harga_layanan == NULL) {
                $request->validate([
                    'jumlah_item_transaksi' => 'required'
                ]);

                $produk = DB::table('produk')
                    ->where([
                        ['id_produk', $itemTransaksi->id_produk],
                    ])
                    ->first();

                ItemTransaksi::where('id_item_transaksi', $itemTransaksi->id_item_transaksi)
                    ->update([
                        'jumlah_item_transaksi' => $request->jumlah_item_transaksi,
                        'sub_total_item_transaksi' => ($request->jumlah_item_transaksi * $itemTransaksi->harga_item_transaksi)
                    ]);

                $i = DB::table('item_transaksi')
                    ->where([
                        ['id_transaksi', $itemTransaksi->id_transaksi],
                    ])
                    ->get();

                Produk::where('id_produk', $itemTransaksi->id_produk)
                    ->update([
                        'jumlah_stok_produk' => ($produk->jumlah_stok_produk - ($request->jumlah_item_transaksi - $itemTransaksi->jumlah_item_transaksi))
                    ]);

                $temp = 0;
                $hitung = 0;
                foreach ($i as $i) {
                    $temp = $i->sub_total_item_transaksi;
                    $temp2 = $temp;
                    $hitung = $hitung + $temp2;
                    $hasil = $hitung;
                }

                Transaksi::where('id_transaksi', $itemTransaksi->id_transaksi)
                    ->update([
                        'total_pembayaran_pembelian' => $hasil
                    ]);

                if (Session::get('jabatan_pegawai') != 'Kasir') {
                    if ($itemTransaksi->id_harga_layanan == NULL) {
                        return redirect('/penjualanProduk')->with('status', 'Item Produk Berhasil diubah!');
                    } else {
                        return redirect('/transaksiLayanan')->with('status', 'Item Layanan Berhasil diubah!');
                    }
                } else if (Session::get('jabatan_pegawai') != 'Customer Service' && (Session::get('jabatan_pegawai') != 'Admin')) {
                    return redirect('/transaksi')->with('status', 'Item Layanan Berhasil diubah!');
                }
            } else {
                $request->validate([
                    'id_harga_layanan' => 'required',
                    'jumlah_item_transaksi' => 'required'
                ]);

                $hargaLayanan = DB::table('harga_layanan')
                    ->where([
                        ['id_harga_layanan', $request->id_harga_layanan],
                    ])
                    ->first();

                ItemTransaksi::where('id_item_transaksi', $itemTransaksi->id_item_transaksi)
                    ->update([
                        'id_harga_layanan' => $request->id_harga_layanan,
                        'harga_item_transaksi' => $hargaLayanan->harga_layanan,
                        'sub_total_item_transaksi' => ($request->jumlah_item_transaksi * $hargaLayanan->harga_layanan),
                        'jumlah_item_transaksi' => $request->jumlah_item_transaksi,
                    ]);

                $i = DB::table('item_transaksi')
                    ->where([
                        ['id_transaksi', $itemTransaksi->id_transaksi],
                    ])
                    ->get();

                $temp = 0;
                $hitung = 0;
                foreach ($i as $i) {
                    $temp = $i->sub_total_item_transaksi;
                    $temp2 = $temp;
                    $hitung = $hitung + $temp2;
                    $hasil = $hitung;
                }

                Transaksi::where('id_transaksi', $itemTransaksi->id_transaksi)
                    ->update([
                        'total_pembayaran_pembelian' => $hasil
                    ]);

                if (Session::get('jabatan_pegawai') != 'Kasir') {
                    if ($itemTransaksi->id_harga_layanan == NULL) {
                        return redirect('/penjualanProduk')->with('status', 'Item Produk Berhasil diubah!');
                    } else {
                        return redirect('/transaksiLayanan')->with('status', 'Item Layanan Berhasil diubah!');
                    }
                } else if (Session::get('jabatan_pegawai') != 'Customer Service' && (Session::get('jabatan_pegawai') != 'Admin')) {
                    return redirect('/transaksi')->with('status', 'Item Layanan Berhasil diubah!');
                }
            }
        }
    }


    public function sendSms(Request $request, ItemTransaksi $itemTransaksi)
    {
        // return $request;
        ItemTransaksi::where('id_item_transaksi', $itemTransaksi->id_item_transaksi)
                ->update([
                    'status_layanan_item_transaksi' => 'SELESAI'
            ]);
        Nexmo::message()->send([
            'to' => '62'.$request->mobile,
            'from' => 'Vonage',
            'text' => 'Layanan ' . $request->layanan . ' ' . $request->jenis . ' ' . $request->ukuran . ' dengan nama transaksi ' . $request->namaTransaksi . ' Sudah selesai dengan total Rp' . $request->harga . '   [KOUVEE PET SHOP]'
        ]);

        Session::flash('success', 'Message sent');

        return redirect('/antrianHewan')->with('status', 'SMS Berhasil Terkirim dan Layanan '. $request->namaTransaksi.' sudah selesai');
    }

    public function destroy(Request $request, ItemTransaksi $itemTransaksi)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else if (Session::get('jabatan_pegawai') != 'Kasir' && Session::get('jabatan_pegawai') != 'Customer Service' && Session::get('jabatan_pegawai') != 'Admin' && Session::get('jabatan_pegawai') != 'Kasir') {
            return redirect('/')->with('status', 'Anda bukan merupakan Pegawai');
        } else {
            $transaksi = DB::table('transaksi')
                ->where('id_transaksi', $itemTransaksi->id_transaksi)
                ->first();
            $harga = $itemTransaksi->sub_total_item_transaksi;
            Transaksi::where('id_transaksi', $itemTransaksi->id_transaksi)
                ->update([
                    'total_pembayaran_pembelian' => $transaksi->total_pembayaran_pembelian - $harga
                ]);

            $produk = DB::table('produk')
                ->where('id_produk', $itemTransaksi->id_produk)
                ->first();

            Produk::where('id_produk', $itemTransaksi->id_produk)
                ->update([
                    'jumlah_stok_produk' => $produk->jumlah_stok_produk + $itemTransaksi->jumlah_item_transaksi
                ]);

            $itemTransaksi->delete();


            if (Session::get('jabatan_pegawai') != 'Kasir') {
                if ($itemTransaksi->id_harga_layanan == NULL) {
                    return redirect('/penjualanProduk')->with('status', 'Item Produk Berhasil dihapus!');
                } else {
                    return redirect('/transaksiLayanan')->with('status', 'Item Layanan Berhasil dihapus!');
                }
            } else if (Session::get('jabatan_pegawai') != 'Customer Service' && (Session::get('jabatan_pegawai') != 'Admin')) {
                if ($itemTransaksi->id_harga_layanan == NULL) {
                    return redirect('/transaksi')->with('status', 'Item Layanan Berhasil dihapus!');
                } else {
                    return redirect('/transaksi')->with('status', 'Item Produk Berhasil dihapus!');
                }
            }
        }
    }

    /* search yg item blm berhasil jdi pake bawaan dari jquery aja 
    public function search(Request $request, Transaksi $transaksi, ItemTransaksi $itemTransaksi)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else if (Session::get('jabatan_pegawai') != 'Kasir' && Session::get('jabatan_pegawai') != 'Customer Service' && Session::get('jabatan_pegawai') != 'Admin') {
            return redirect('/')->with('status', 'Anda bukan merupakan CS atau admin');
        } else {
            if ($itemTransaksi->id_harga_layanan == NULL) {

                $search  = $request->get('search');
                $produk = DB::table('produk')->where('nama_produk', 'like', '%' . $search . '%')->first();

                $id = $transaksi->id_transaksi;
                $item = ItemTransaksi::with('Produk', 'HargaLayanan', 'Layanan', 'JenisHewan', 'UkuranHewan')
                    ->where('id_transaksi', $id)->get();

                $itemTransaksi = $item->where('id_produk', $produk->id_produk)->get('id_item_transaksi');
                $hewan = Hewan::with('Member', 'JenisHewan', 'UkuranHewan')->where('id_hewan', $transaksi->id_hewan)->first();
                $jenisHewan = JenisHewan::all();
                $member = Member::all();
                $pegawai = DB::table('pegawai')
                    ->where([
                        ['id_pegawai', $transaksi->id_pegawai_cs],
                    ])
                    ->first();
                $pegawaiKasir = DB::table('pegawai')
                    ->where([
                        ['id_pegawai', $transaksi->id_pegawai_kasir],
                    ])
                    ->first();
                $transaksi = $transaksi;
                $data = array(
                    'transaksi' => $transaksi,
                    'itemTransaksi' => $itemTransaksi,
                    'hewan' => $hewan,
                    'jenisHewan' => $jenisHewan,
                    'member' => $member,
                    'pegawaics' => $pegawai,
                    'pegawaikasir' => $pegawaiKasir
                );
                return view('transaksi.show', $data);

                if (Session::get('jabatan_pegawai') != 'Kasir') {
                    if ($itemTransaksi->id_harga_layanan == NULL) {
                        return view('penjualanProduk.show',  $data);
                    } else {
                        return view('transaksiLayanan.show',  $data);
                    }
                } else if (Session::get('jabatan_pegawai') != 'Customer Service' && (Session::get('jabatan_pegawai') != 'Admin')) {
                    return view('transaksi.show',  $data);
                }
            } else {
                $search  = $request->get('search');




                if (Session::get('jabatan_pegawai') != 'Kasir') {
                    if ($itemTransaksi->id_harga_layanan == NULL) {
                        return view('penjualanProduk.show',  $data);
                    } else {
                        return view('transaksiLayanan.show',  $data);
                    }
                } else if (Session::get('jabatan_pegawai') != 'Customer Service' && (Session::get('jabatan_pegawai') != 'Admin')) {
                    return view('transaksi.show',  $data);
                }
            }
        }
    }*/
}
