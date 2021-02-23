<?php

namespace App\Http\Controllers;

use App\Pemesanan;
use App\Supplier;
use App\ItemPemesanan;
use App\Produk;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use PDF;

class PemesananController extends Controller
{
    //
    public function index()
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else if (Session::get('jabatan_pegawai') != 'Admin') {
            return redirect('/')->with('status', 'Anda bukan merupakan Admin');
        } else {
            $pemesanan = Pemesanan::with('Supplier', 'Pegawai')
                ->where('status_pemesanan', 'BELUM SUKSES')
                ->orWhere('status_pemesanan', 'BELUM KONFIRMASI')
                ->get();
            return view('pemesanan.index', compact('pemesanan'));
        }
    }

    public function indexKonfirmasi()
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else if (Session::get('jabatan_pegawai') != 'Admin') {
            return redirect('/')->with('status', 'Anda bukan merupakan Admin');
        } else {
            $pemesanan = Pemesanan::with('Supplier', 'Pegawai')->where('status_pemesanan', 'SUKSES')->get();
            return view('pemesanan.indexKonfirmasi', compact('pemesanan'));
        }
    }

    public function show(Pemesanan $pemesanan)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else if (Session::get('jabatan_pegawai') != 'Admin') {
            return redirect('/')->with('status', 'Anda bukan merupakan Admin');
        } else {
            $id = $pemesanan->id_pemesanan;
            $itemPemesanan = ItemPemesanan::with('Pemesanan', 'Produk')
                ->where('id_pemesanan', $id)
                ->get();

            return view('pemesanan/show', compact('pemesanan'), ['itemPemesanan' => $itemPemesanan]);
        }
    }

    public function create()
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else if (Session::get('jabatan_pegawai') != 'Admin') {
            return redirect('/')->with('status', 'Anda bukan merupakan Admin');
        } else {
            $supplier = Supplier::all();
            $data = array(
                'supplier' => $supplier
            );
            return view('pemesanan.create', $data);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'tgl_pemesanan' => 'required',
            'id_supplier' => 'required'
        ]);

        $pemesanan = new Pemesanan;
        $pemesanan->tgl_pemesanan = $request->tgl_pemesanan;
        $pemesanan->status_pemesanan = 'BELUM SUKSES';
        $pemesanan->total_pembayaran_pemesanan = 0;
        //$pemesanan->tgl_pemesanan = now()->timestamp;
        $pemesanan->id_supplier = $request->id_supplier;
        $pemesanan->id_pegawai = Session::get('id_pegawai');

        $latest_id = Pemesanan::latest('id_pemesanan')->first()->id_pemesanan;
        $temp_id = $latest_id + 1;

        if ($temp_id < 10) {
            $pemesanan->nama_pemesanan = 'PO' . ' - ' . $request->tgl_pemesanan . ' - ' . '0' . ($temp_id);
        } else {
            $pemesanan->nama_pemesanan = 'PO' . ' - ' . $request->tgl_pemesanan . ' - ' . $temp_id;
        }

        $pemesanan->save();

        return redirect('/pemesanan')->with('status', 'Data Pemesanan Berhasil ditambahkan');

        //$tanggal 	= date("Y-m-d");
        //$pemesanan->nama_pemesanan = concat('PO-',toString($request->tanggal_pemesanan),'-',$request->id_supplier);
    }

    public function edit(Pemesanan $pemesanan)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else if (Session::get('jabatan_pegawai') != 'Admin') {
            return redirect('/')->with('status', 'Anda bukan merupakan Admin');
        } else {
            $supplier = Supplier::all();
            return view('pemesanan.edit', compact('pemesanan'), ['supplier' => $supplier]);
        }
    }

    public function update(Request $request, Pemesanan $pemesanan)
    {
        $request->validate([
            'id_supplier' => 'required',
            'tgl_pemesanan' => 'required'
        ]);
        Pemesanan::where('id_pemesanan', $pemesanan->id_pemesanan)
            ->update([
                'id_supplier' => $request->id_supplier,
                'tgl_pemesanan' => $request->tgl_pemesanan,
                'id_pegawai' => Session::get('id_pegawai'),
            ]);

        return redirect('/pemesanan')->with('status', 'Data Pemesanan Berhasil diubah!');
    }

    public function destroy(Pemesanan $pemesanan)
    {
        Pemesanan::destroy($pemesanan->id_pemesanan);
        return redirect('/pemesanan')->with('status', 'Data Pemesanan berhasil dihapus!');
    }


    // ITEM PEMESANAN 

    public function createProduk(Pemesanan $pemesanan)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else if (Session::get('jabatan_pegawai') != 'Admin') {
            return redirect('/')->with('status', 'Anda bukan merupakan Admin');
        } else {
            $produk = Produk::all();
            $data = array(
                'produk' => $produk
            );
            return view('itemPemesanan.create', compact('pemesanan'), $data);
        }
    }

    public function storeProduk(Request $request, Pemesanan $pemesanan)
    {
        $request->validate([
            'id_produk' => 'required',
            'satuan_item_pemesanan' => 'required',
            'jumlah_item_pemesanan' => 'required'
        ]);

        $produk = Produk::where('id_produk', $request->id_produk)->first();

        $itemPemesanan = new ItemPemesanan();
        $itemPemesanan->id_produk = $request->id_produk;
        $itemPemesanan->satuan_item_pemesanan = $request->satuan_item_pemesanan;
        $itemPemesanan->jumlah_item_pemesanan = $request->jumlah_item_pemesanan;
        $itemPemesanan->harga_item_pemesanan = $produk->harga_produk;
        $itemPemesanan->sub_total_item_pemesanan = $request->jumlah_item_pemesanan * $produk->harga_produk;
        $itemPemesanan->id_pemesanan = $pemesanan->id_pemesanan;
        $itemPemesanan->save();

        $i = DB::table('item_pemesanan')
            ->where([
                ['id_pemesanan', $itemPemesanan->id_pemesanan],
            ])
            ->get();

        $temp = 0;
        $hitung = 0;
        foreach ($i as $i) {
            $temp = $i->sub_total_item_pemesanan;
            $temp2 = $temp;
            $hitung = $hitung + $temp2;
            $hasil = $hitung;
        }

        Pemesanan::where('id_pemesanan', $pemesanan->id_pemesanan)
            ->update([
                'total_pembayaran_pemesanan' => $hasil,
                'status_pemesanan' => 'BELUM KONFIRMASI',
            ]);

        return redirect()->route('ShowDetailPemesanan', compact('pemesanan'))->with('statusProduk', 'Data Produk Pemesanan berhasil ditambah');
    }

    public function editProduk(Pemesanan $pemesanan, ItemPemesanan $itemPemesanan)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else if (Session::get('jabatan_pegawai') != 'Admin') {
            return redirect('/')->with('status', 'Anda bukan merupakan Admin');
        } else {
            $produk = Produk::all();

            return view('itemPemesanan.edit', compact('pemesanan', 'itemPemesanan'), ['produk' => $produk]);
        }
    }

    public function updateProduk(Request $request, Pemesanan $pemesanan, ItemPemesanan $itemPemesanan)
    {
        $request->validate([
            'id_produk' => 'required',
            'satuan_item_pemesanan' => 'required',
            'jumlah_item_pemesanan' => 'required'
        ]);

        $produk = Produk::where('id_produk', $request->id_produk)->first();

        Itempemesanan::where('id_item_pemesanan', $itemPemesanan->id_item_pemesanan)
            ->update([
                'id_produk' => $request->id_produk,
                'harga_item_pemesanan' => $produk->harga_produk,
                'jumlah_item_pemesanan' => $request->jumlah_item_pemesanan,
                'sub_total_item_pemesanan' => $request->jumlah_item_pemesanan * $produk->harga_produk,
                'satuan_item_pemesanan' => $request->satuan_item_pemesanan,
            ]);

        $i = DB::table('item_pemesanan')
            ->where([
                ['id_pemesanan', $itemPemesanan->id_pemesanan],
            ])
            ->get();

        $temp = 0;
        $hitung = 0;
        foreach ($i as $i) {
            $temp = $i->sub_total_item_pemesanan;
            $temp2 = $temp;
            $hitung = $hitung + $temp2;
            $hasil = $hitung;
        }

        Pemesanan::where('id_pemesanan', $pemesanan->id_pemesanan)
            ->update([
                'total_pembayaran_pemesanan' => $hasil,
            ]);

        return redirect()->route('ShowDetailPemesanan', compact('pemesanan'))->with('statusProduk', 'Data Produk Pemesanan berhasil diubah');
    }

    public function destroyProduk(Pemesanan $pemesanan, ItemPemesanan $itemPemesanan)
    {
        $pemesanan->total_pembayaran_pemesanan = $pemesanan->total_pembayaran_pemesanan - $itemPemesanan->sub_total_item_pemesanan;
        $pemesanan->status_pemesanan = 'BELUM KONFIRMASI';
        $pemesanan->save();

        ItemPemesanan::destroy($itemPemesanan->id_item_pemesanan);

        return redirect()->route('ShowDetailPemesanan', compact('pemesanan'))->with('statusProduk', 'Data Produk Pemesanan berhasil dihapus');
    }

    // KONFIRMASI PRODUK
    public function konfirmasi(pemesanan $pemesanan)
    {
        $itemPemesanan =  DB::table('item_pemesanan')
            ->join('pemesanan', 'pemesanan.id_pemesanan', '=', 'item_pemesanan.id_pemesanan')
            ->where('item_pemesanan.id_pemesanan', '=', $pemesanan->id_pemesanan)
            ->get();

        $produk = DB::table('produk')
            ->join('item_pemesanan', 'produk.id_produk', '=', 'item_pemesanan.id_produk')
            ->join('pemesanan', 'item_pemesanan.id_pemesanan', '=', 'pemesanan.id_pemesanan')
            ->where('item_pemesanan.id_pemesanan', '=', $pemesanan->id_pemesanan)
            ->get();

        foreach ($itemPemesanan as $i) {
            // echo $dp->id_itemPemesanan;
            foreach ($produk as $p)
                if ($p->id_produk == $i->id_produk) {
                    Produk::where('id_produk', $p->id_produk)
                        ->update([
                            'jumlah_stok_produk' => $p->jumlah_stok_produk + $i->jumlah_item_pemesanan,
                        ]);
                }
        }

        $pemesanan->status_pemesanan = 'SUKSES';
        $pemesanan->save();

        //$pdf = PDF::loadview('pemesanan.suratPemesanan', compact('pemesanan'))->with('status', 'Data Pemesanan berhasil dikonfirmasi');
        //return $pdf->download('Surat Pemesanan.pdf');

        return redirect()->route('ShowDetailPemesanan', compact('pemesanan'))->with('status', 'Data Pemesanan berhasil dikonfirmasi');
    }

    public function cetakSurat(Pemesanan $pemesanan)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else if (Session::get('jabatan_pegawai') != 'Admin') {
            return redirect('/')->with('status', 'Anda bukan merupakan Admin');
        } else {
            $id = $pemesanan->id_pemesanan;
            $itemPemesanan = ItemPemesanan::with('Pemesanan', 'Produk')
                ->where('id_pemesanan', $id)
                ->get();

            $data = array(
                'pemesanan' => $pemesanan,
                'itemPemesanan' => $itemPemesanan,
                'waktu' => date('d F Y')
            );

            $pdf = PDF::loadview('pemesanan.suratPemesanan', $data)->setPaper('a4');
            return $pdf->stream();
            //return $pdf->download('Surat Pemesanan.pdf');
        }
    }
}
