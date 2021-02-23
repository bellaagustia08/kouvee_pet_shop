<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Transaksi;
use App\ItemTransaksi;
use App\Produk;
use App\HargaLayanan;
use App\Hewan;
use App\Layanan;
use App\JenisHewan;
use App\Member;
use App\Pegawai;
use App\UkuranHewan;

class TransaksiController extends Controller
{
    //
    public function index()
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else {
            $i = 1;

            $transaksi = Transaksi::with('Hewan', 'Pegawai')->where('status_transaksi', 'BELUM LUNAS')->get();
            $data = array(
                'i' => $i,
                'transaksi' => $transaksi
            );
            return view('transaksi.index', $data);
        }
    }

    public function indexLunas()
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else {
            $i = 1;

            $transaksi = Transaksi::with('Hewan', 'Pegawai')->where('status_transaksi', 'LUNAS')->get();
            $data = array(
                'i' => $i,
                'transaksi' => $transaksi
            );
            return view('transaksi.indexLunas', $data);
        }
    }

    public function edit(Transaksi $transaksi)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else {
            $id = $transaksi->id_transaksi;

            $itemTransaksi = ItemTransaksi::with('Produk', 'HargaLayanan', 'Layanan', 'JenisHewan', 'UkuranHewan')
                ->where('id_transaksi', $id)->get();
            $hewan = DB::table('hewan')->where('id_hewan', $transaksi->id_hewan)->first();
            $jenisHewan = JenisHewan::all();
            $member = Member::all();
            $pegawai = Pegawai::all();
            $transaksi = $transaksi;
            $data = array(
                'transaksi' => $transaksi,
                'itemTransaksi' => $itemTransaksi,
                'hewan' => $hewan,
                'jenisHewan' => $jenisHewan,
                'member' => $member,
                'pegawai' => $pegawai
            );
            return view('transaksi.show', $data);
        }
    }

    public function show(Transaksi $transaksi)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else if (Session::get('jabatan_pegawai') != 'Kasir') {
            return redirect('/')->with('status', 'Anda bukan merupakan Kasir');
        } else {
            $id = $transaksi->id_transaksi;

            $itemTransaksi = ItemTransaksi::with('Produk', 'HargaLayanan', 'Layanan', 'JenisHewan', 'UkuranHewan')
                ->where('id_transaksi', $id)->get();
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
        }
    }

    public function showLunas(Transaksi $transaksi)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else if (Session::get('jabatan_pegawai') != 'Kasir') {
            return redirect('/')->with('status', 'Anda bukan merupakan Kasir');
        } else {
            $id = $transaksi->id_transaksi;

            $itemTransaksi = ItemTransaksi::with('Produk', 'HargaLayanan', 'Layanan', 'JenisHewan', 'UkuranHewan')
                ->where('id_transaksi', $id)->get();
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
            return view('transaksi.showLunas', $data);
        }
    }

    public function search(Request $request)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else if (Session::get('jabatan_pegawai') != 'Kasir') {
            return redirect('/')->with('status', 'Anda bukan merupakan Kasir');
        } else {
            $search  = $request->get('search');

            $member = DB::table('member')->where('nama_member', 'like', '%' . $search . '%')->first();
            if ($member != NULL) {
                $hewan = DB::table('hewan')->where('id_member', $member->id_member)->first();
                $transaksi = DB::table('transaksi')
                    ->where([
                        ['id_hewan', $hewan->id_hewan],
                        ['status_transaksi', 'NOT SUCCESS'],
                    ])
                    ->get();
                return view('transaksi.index', compact('transaksi'));
            } else {
                $transaksi = DB::table('transaksi')
                    ->where([
                        ['nama_transaksi', 'like', '%' . $search . '%'],
                        ['status_transaksi', 'NOT SUCCESS'],
                    ])
                    ->orWhere([
                        ['id_transaksi', 'like', '%' . $search . '%'],
                        ['status_transaksi', 'NOT SUCCESS'],
                    ])
                    ->get();
                return view('transaksi.index', compact('transaksi'));
            }
        }
    }

    public function bayar(Request $request, Transaksi $transaksi)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else {
            if ($request->jumlah_bayar < $transaksi->total_pembayaran_pembelian) {
                //$id = $transaksi->id_transaksi;
                //return redirect('/transaksi')->with('status', 'Tidak Berhasil melakukan pembayaran');
                return redirect()->route('ShowDetailTransaksi', compact('transaksi'))->with('statusBayar', 'Tidak Berhasil melakukan pembayaran');
            } else {
                //$transaksi = $transaksi;
                $harga = DB::table('transaksi')
                    ->where('id_transaksi', $request->id_transaksi)
                    ->first();

                $total = $harga->total_pembayaran_pembelian - $request->diskon;
                $kembalian = $request->jumlah_bayar - $total;

                Transaksi::where('id_transaksi', $request->id_transaksi)
                    ->update([
                        'diskon' => $request->diskon,
                        'status_transaksi' => 'LUNAS',
                        'total_pembayaran_pembelian' => $harga->total_pembayaran_pembelian - $request->diskon
                    ]);

                if ($transaksi->jenis_transaksi == 'Produk') {
                    Transaksi::where('id_transaksi', $request->id_transaksi)
                        ->update([
                            'total_produk' => $harga->total_pembayaran_pembelian - $request->diskon
                        ]);
                } elseif ($transaksi->jenis_transaksi == 'Layanan') {
                    Transaksi::where('id_transaksi', $request->id_transaksi)
                        ->update([
                            'total_layanan' => $harga->total_pembayaran_pembelian - $request->diskon
                        ]);
                }

                //return redirect('/transaksiLunas')->with('status', 'Berhasil melakukan pembayaran');
                return redirect()->route('ShowDetailTransaksi', compact('transaksi'))->with('statusBayar', 'Berhasil melakukan pembayaran')
                    ->with('jumlah_bayar', $request->jumlah_bayar)
                    ->with('diskon', $request->diskon)
                    ->with('kembalian', $kembalian);
            }
        }
    }

    public function cetakStruk(Transaksi $transaksi)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else {
            $id = $transaksi->id_transaksi;

            $itemTransaksi = ItemTransaksi::with('Produk', 'HargaLayanan', 'Layanan', 'JenisHewan', 'UkuranHewan')
                ->where('id_transaksi', $transaksi->id_transaksi)->get();
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
                    ['id_pegawai', Session::get('id_pegawai')],
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
                'pegawaikasir' => $pegawaiKasir,
                'waktu' => date('d F Y H:i')
            );

            //$transaksi = Transaksi::all();

            if ($transaksi->jenis_transaksi == 'Layanan') {
                $pdf = PDF::loadview('transaksi.cetakStruk_layanan', $data)->setPaper('a4');
            } else {
                $pdf = PDF::loadview('transaksi.cetakStruk_produk', $data)->setPaper('a4');
            }
            //return $pdf->download('laporan-review-pdf.pdf');
            return $pdf->stream();
        }
    }
}
