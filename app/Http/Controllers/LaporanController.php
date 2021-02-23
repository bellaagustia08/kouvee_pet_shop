<?php

namespace App\Http\Controllers;

use App\Pemesanan;
use App\Supplier;
use App\Produk;
use App\Layanan;
use App\Transaksi;
use App\ItemTransaksi;
use App\PenjualanProduk;
use App\TransaksiLayanan;
use App\Member;
use App\Pegawai;
use Carbon\Carbon;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use PDF;

class LaporanController extends Controller
{
    //
    public function produkTerlaris(Request $request){
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else if (Session::get('jabatan_pegawai') != 'Admin') {
            return redirect('/')->with('status', 'Anda bukan merupakan Admin');
        } else {
            $search = $request->get('tahun');
            for($i = 1; $i <= 12; $i++){
                $transaksi[$i] = \DB::table('transaksi')
                ->join('item_transaksi','item_transaksi.id_transaksi','=','transaksi.id_transaksi')
                ->join('produk','item_transaksi.id_produk','=','produk.id_produk')
                ->whereYear('transaksi.tgl_transaksi',$search)
                ->whereMonth('transaksi.tgl_transaksi',$i)
                ->where('status_transaksi','LUNAS')
                ->select(DB::raw('DATE_FORMAT(transaksi.tgl_transaksi, "%M") as tgl'),DB::raw('DATE_FORMAT(transaksi.tgl_transaksi, "%Y") as tahun'),'produk.nama_produk as nama_produk','item_transaksi.id_produk', \DB::raw('COUNT(item_transaksi.id_produk) as count'))
                ->groupBy('item_transaksi.id_produk')
                ->groupBy('produk.nama_produk')
                ->groupBy('transaksi.tgl_transaksi')
                ->orderBy('count','DESC')
                ->first();
                $itemTransaksi = ItemTransaksi::all();
                $produk = Produk::all();
            }
            $bulanSuper = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
           
            $tahun = \DB::table('transaksi')
                ->join('item_transaksi','item_transaksi.id_transaksi','=','transaksi.id_transaksi')
                ->join('produk','item_transaksi.id_produk','=','produk.id_produk')
                ->whereYear('transaksi.tgl_transaksi',$search)
                // ->whereMonth('transaksi.tgl_transaksi',$i)
                ->select(DB::raw('DATE_FORMAT(transaksi.tgl_transaksi, "%Y") as thn'))
                ->groupBy('transaksi.tgl_transaksi')
                ->first();

            $this->data['transaksi'] = $transaksi;
            $this->data['bulan'] = $bulanSuper;
            $this->data['tahun'] = $tahun;
            return view('produkTerlaris.index', $this->data);

            // return response()->json([
            //     'transaksi' => $transaksi,
            //     'bulan' => $bulanSuper[1]
            // ]);
        }
    }

    public function layananTerlaris(Request $request){
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else if (Session::get('jabatan_pegawai') != 'Admin') {
            return redirect('/')->with('status', 'Anda bukan merupakan Admin');
        } else {
            $search = $request->get('tahun');
            for($i = 1; $i <= 12; $i++){
                $transaksi[$i] = \DB::table('transaksi')
                ->join('item_transaksi','item_transaksi.id_transaksi','=','transaksi.id_transaksi')
                ->join('harga_layanan','item_transaksi.id_harga_layanan','=','harga_layanan.id_harga_layanan')
                ->join('layanan','harga_layanan.id_layanan','=','layanan.id_layanan')
                ->join('jenis_hewan','harga_layanan.id_jenis','=','jenis_hewan.id_jenis')
                ->join('ukuran_hewan','harga_layanan.id_ukuran','=','ukuran_hewan.id_ukuran')
                ->whereYear('transaksi.tgl_transaksi',$search)
                ->whereMonth('transaksi.tgl_transaksi',$i)
                ->where('status_transaksi','LUNAS')
                ->select(DB::raw('DATE_FORMAT(transaksi.tgl_transaksi, "%M") as bln'),
                    'jenis_hewan.nama_jenis as nama_jenis',
                    'ukuran_hewan.nama_ukuran as nama_ukuran',
                    'layanan.nama_layanan as nama_layanan',
                    'item_transaksi.id_harga_layanan as id_harga_layanan',
                    \DB::raw('COUNT(item_transaksi.id_harga_layanan) as count'))
                ->groupBy('item_transaksi.id_harga_layanan')
                ->groupBy('layanan.nama_layanan')
                ->groupBy('jenis_hewan.nama_jenis')
                ->groupBy('ukuran_hewan.nama_ukuran')
                ->groupBy('transaksi.tgl_transaksi')
                ->orderBy('count','DESC')
                ->first();
                $itemTransaksi = ItemTransaksi::all();
            }
            $bulanSuper = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
            
            $tahun = \DB::table('transaksi')
            ->join('item_transaksi','item_transaksi.id_transaksi','=','transaksi.id_transaksi')
            ->join('harga_layanan','item_transaksi.id_harga_layanan','=','harga_layanan.id_harga_layanan')
            ->whereYear('transaksi.tgl_transaksi',$search)
            // ->whereMonth('transaksi.tgl_transaksi',$i)
            ->select(DB::raw('DATE_FORMAT(transaksi.tgl_transaksi, "%Y") as thn'))
            ->groupBy('transaksi.tgl_transaksi')
            ->first();

            $this->data['transaksi'] = $transaksi;
            $this->data['bulan'] = $bulanSuper;
            $this->data['tahun'] = $tahun;
            return view('layananTerlaris.index', $this->data);
        }
    }

    public function pendapatanBulanan(Request $request){
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else if (Session::get('jabatan_pegawai') != 'Admin') {
            return redirect('/')->with('status', 'Anda bukan merupakan Admin');
        } else {
            $searchTahun = $request->get('tahun');
            $searchBulan = $request->get('bulan');
                $bulananLayanan = Transaksi::select(DB::raw("CONCAT(layanan.nama_layanan,' ',CONCAT(jenis_hewan.nama_jenis,' ', ukuran_hewan.nama_ukuran)) as nama_layanan"),
                DB::raw("FORMAT(SUM(transaksi.total_layanan),0) as total"))
                ->join('item_transaksi','transaksi.id_transaksi','=','item_transaksi.id_transaksi')
                ->join('harga_layanan','item_transaksi.id_harga_layanan','=','harga_layanan.id_harga_layanan')
                ->join('layanan','harga_layanan.id_layanan','=','layanan.id_layanan')
                ->join('jenis_hewan','harga_layanan.id_jenis','=','jenis_hewan.id_jenis')
                ->join('ukuran_hewan','harga_layanan.id_ukuran','=','ukuran_hewan.id_ukuran')
                ->where('jenis_transaksi','Layanan')
                ->where('status_transaksi','LUNAS')
                ->whereYear('transaksi.tgl_transaksi',$searchTahun)
                ->whereMonth('transaksi.tgl_transaksi',$searchBulan)
                ->groupBy('nama_layanan')
                ->groupBy('jenis_hewan.nama_jenis')
                ->groupBy('ukuran_hewan.nama_ukuran')
                ->groupBy('harga_layanan.id_layanan')
                ->orderBy('total','DESC')
                ->get();

                $bulananProduk = Transaksi::select(DB::raw("produk.nama_produk as nama_produk"),
                DB::raw("FORMAT(SUM(transaksi.total_produk),0) as total"))
                ->join('item_transaksi','item_transaksi.id_transaksi','=','transaksi.id_transaksi')
                ->join('produk','item_transaksi.id_produk','=','produk.id_produk')
                ->where('jenis_transaksi','Produk')
                ->where('status_transaksi','LUNAS')
                ->whereYear('transaksi.tgl_transaksi',$searchTahun)
                ->whereMonth('transaksi.tgl_transaksi',$searchBulan)
                ->groupBy('nama_produk')
                ->groupBy('produk.id_produk')
                ->orderBy('total','DESC')
                ->get();

        $totalBulanLayanan = DB::table('transaksi')
        ->where('status_transaksi','LUNAS')
        ->where('jenis_transaksi','Layanan')
        ->whereYear('transaksi.tgl_transaksi',$searchTahun)
        ->whereMonth('transaksi.tgl_transaksi',$searchBulan)
        ->select(DB::raw('FORMAT(SUM(IFNULL(total_layanan,0)),0) as subtotal'))
        ->first();

        $totalBulanProduk = DB::table('transaksi')
        ->where('status_transaksi','LUNAS')
        ->where('jenis_transaksi','Produk')
        ->whereYear('transaksi.tgl_transaksi',$searchTahun)
        ->whereMonth('transaksi.tgl_transaksi',$searchBulan)
        ->select(DB::raw('FORMAT(SUM(IFNULL(total_produk,0)),0) as subtotal'))
        ->first();

        $tahun = \DB::table('transaksi')
        ->join('item_transaksi','item_transaksi.id_transaksi','=','transaksi.id_transaksi')
        ->join('produk','item_transaksi.id_produk','=','produk.id_produk')
        ->whereYear('transaksi.tgl_transaksi',$searchTahun)
        ->whereMonth('transaksi.tgl_transaksi',$searchBulan)
        ->select(DB::raw('DATE_FORMAT(transaksi.tgl_transaksi, "%Y") as thn'))
        ->groupBy('transaksi.tgl_transaksi')
        ->first();

        $bulanSuper = ["","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];

        $bulan = \DB::table('transaksi')
        ->join('item_transaksi','item_transaksi.id_transaksi','=','transaksi.id_transaksi')
        ->join('produk','item_transaksi.id_produk','=','produk.id_produk')
        ->whereYear('transaksi.tgl_transaksi',$searchTahun)
        ->whereMonth('transaksi.tgl_transaksi',$searchBulan)
        ->select(DB::raw('DATE_FORMAT(transaksi.tgl_transaksi, "%M") as bln'))
        ->groupBy('transaksi.tgl_transaksi')
        ->first();

        $bulan1 = $searchBulan;
        
        $this->data['bulananLayanan'] = $bulananLayanan;
        $this->data['bulananProduk'] = $bulananProduk;
        $this->data['totalBulanLayanan'] = $totalBulanLayanan;
        $this->data['totalBulanProduk'] = $totalBulanProduk;


        // $this->data['subtotalsetahun'] = $subtotalsetahun;
        $this->data['bulan1'] = $bulan1;
        $this->data['bulan'] = $bulan;
        $this->data['tahun'] = $tahun;

        return view('pendapatanBulanan.index', $this->data);

        // return response()->json([
        //     'bulananProduk' => $bulananProduk,
        //     'bulananLayanan' => $bulananLayanan,
        //     'totalBulanLayanan' => $totalBulanLayanan,
        //     'totalBulanProduk' => $totalBulanProduk,
        //     // 'subtotalsetahun' => $subtotalsetahun,
        //     // 'pendapatanProduk' => $pendapatanProduk,
        //     // // 'totalPendapatan' => $totalPendapatan,
        //     // 'bulan' => $bulanSuper,
        //     // 'tahun' => $tahun,
        // ]);
        }
    }

    public function pendapatanTahunan(Request $request){
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else if (Session::get('jabatan_pegawai') != 'Admin') {
            return redirect('/')->with('status', 'Anda bukan merupakan Admin');
        } else {
            $search = $request->get('tahun');
            for($i = 1; $i <= 12; $i++){
                $pendapatanTahunan[$i] = \DB::table('transaksi')
                ->where('status_transaksi','LUNAS')
                ->whereYear('transaksi.tgl_transaksi',$search)
                ->whereMonth('transaksi.tgl_transaksi',$i)
                ->select(DB::raw('DATE_FORMAT(transaksi.tgl_transaksi,"%M") as bulan'),
                    DB::raw('FORMAT(SUM(total_produk),0) as total_produk'),
                    DB::raw('FORMAT(SUM(total_layanan),0) as total_layanan'),
                    DB::raw('FORMAT(SUM(total_pembayaran_pembelian),0) as subtotal'),
                    DB::raw('FORMAT(SUM(IFNULL(total_layanan,0))+SUM(IFNULL(total_produk,0)),0) as total'))
                ->groupBy('transaksi.tgl_transaksi')
                ->first();
            }
            
            $subtotalsetahun = DB::table('transaksi')
            ->where('status_transaksi','LUNAS')
            ->whereYear('transaksi.tgl_transaksi',$search)
            ->select(DB::raw('FORMAT(SUM(total_pembayaran_pembelian),0) as subtotal'))
            ->first();

            $bulanSuper = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
            
            $tahun = \DB::table('transaksi')
            ->join('item_transaksi','item_transaksi.id_transaksi','=','transaksi.id_transaksi')
            ->join('produk','item_transaksi.id_produk','=','produk.id_produk')
            ->whereYear('transaksi.tgl_transaksi',$search)
            ->where('status_transaksi','LUNAS')
            ->select(DB::raw('DATE_FORMAT(transaksi.tgl_transaksi, "%Y") as thn'))
            ->groupBy('transaksi.tgl_transaksi')
            ->first();
            
            $this->data['pendapatanTahunan'] = $pendapatanTahunan;
            $this->data['subtotalsetahun'] = $subtotalsetahun;
            $this->data['bulan'] = $bulanSuper;
            $this->data['tahun'] = $tahun;

            return view('pendapatanTahunan.index', $this->data);

            // return response()->json([
            //     'pendapatanTahunan' => $pendapatanTahunan,
            //     'subtotalsetahun' => $subtotalsetahun,
            //     // 'pendapatanProduk' => $pendapatanProduk,
            //     // // 'totalPendapatan' => $totalPendapatan,
            //     // 'bulan' => $bulanSuper,
            //     // 'tahun' => $tahun,
            // ]);
        }
    }

    public function pengadaanBulanan(Request $request){
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else if (Session::get('jabatan_pegawai') != 'Admin') {
            return redirect('/')->with('status', 'Anda bukan merupakan Admin');
        } else {
            $searchTahun = $request->get('tahun');
            $searchBulan = $request->get('bulan');
            
            $pengadaanBulan = Pemesanan::select(DB::raw("produk.nama_produk as nama_produk"),
            DB::raw("FORMAT(SUM(pemesanan.total_pembayaran_pemesanan),0) as total"))
            ->join('item_pemesanan','pemesanan.id_pemesanan','=','item_pemesanan.id_pemesanan')
            ->join('produk','item_pemesanan.id_produk','=','produk.id_produk')
            ->where('status_pemesanan','SUKSES')
            ->whereYear('pemesanan.tgl_pemesanan',$searchTahun)
            ->whereMonth('pemesanan.tgl_pemesanan',$searchBulan)
            ->groupBy('nama_produk')
            ->orderBy('total','DESC')
            ->get();

        $subtotalsebulan = DB::table('pemesanan')
        ->where('status_pemesanan','SUKSES')
        ->whereYear('pemesanan.tgl_pemesanan',$searchTahun)
        ->whereMonth('pemesanan.tgl_pemesanan',$searchBulan)
        ->select(DB::raw('FORMAT(SUM(IFNULL(total_pembayaran_pemesanan,0)),0) as subtotal'))
        ->first();

        $tahun = \DB::table('pemesanan')
        ->join('item_pemesanan','pemesanan.id_pemesanan','=','item_pemesanan.id_pemesanan')
        ->join('produk','item_pemesanan.id_produk','=','produk.id_produk')
        ->where('status_pemesanan','SUKSES')
        ->whereYear('pemesanan.tgl_pemesanan',$searchTahun)
        ->whereMonth('pemesanan.tgl_pemesanan',$searchBulan)
        ->select(DB::raw('DATE_FORMAT(pemesanan.tgl_pemesanan, "%Y") as thn'))
        ->groupBy('pemesanan.tgl_pemesanan')
        ->first();

        $bulanSuper = ["","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];

        $bulan = \DB::table('pemesanan')
        ->join('item_pemesanan','pemesanan.id_pemesanan','=','item_pemesanan.id_pemesanan')
        ->join('produk','item_pemesanan.id_produk','=','produk.id_produk')
        ->where('status_pemesanan','SUKSES')
        ->whereYear('pemesanan.tgl_pemesanan',$searchTahun)
        ->whereMonth('pemesanan.tgl_pemesanan',$searchBulan)
        ->select(DB::raw('DATE_FORMAT(pemesanan.tgl_pemesanan, "%M") as bln'))
        ->groupBy('pemesanan.tgl_pemesanan')
        ->first();

        $bulan1 = $searchBulan;
        
        $this->data['pengadaanBulan'] = $pengadaanBulan;
        $this->data['subtotalsebulan'] = $subtotalsebulan;

        // $this->data['subtotalsetahun'] = $subtotalsetahun;
        $this->data['bulan1'] = $bulan1;
        $this->data['bulan'] = $bulan;
        $this->data['tahun'] = $tahun;

        return view('pengadaanBulanan.index', $this->data);
        }
    }
    
    public function pengadaanTahunan(Request $request){
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else if (Session::get('jabatan_pegawai') != 'Admin') {
            return redirect('/')->with('status', 'Anda bukan merupakan Admin');
        } else {
            $search = $request->get('tahun');
            for($i = 1; $i <= 12; $i++){
                $pengadaanTahunan[$i] = \DB::table('pemesanan')
                ->where('status_pemesanan','SUKSES')
                ->whereYear('pemesanan.tgl_pemesanan',$search)
                ->whereMonth('pemesanan.tgl_pemesanan',$i)
                ->select(DB::raw('DATE_FORMAT(pemesanan.tgl_pemesanan,"%M") as bulan'),
                    DB::raw('FORMAT(SUM(total_pembayaran_pemesanan),0) as total'))
                ->groupBy('pemesanan.tgl_pemesanan')
                ->first();
            }
            
            $subtotalsetahun = DB::table('pemesanan')
            ->where('status_pemesanan','SUKSES')
            ->whereYear('pemesanan.tgl_pemesanan',$search)
            ->select(DB::raw('FORMAT(SUM(total_pembayaran_pemesanan),0) as subtotal'))
            ->first();

            $bulanSuper = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
            
            $tahun = \DB::table('pemesanan')
            ->join('item_pemesanan','item_pemesanan.id_pemesanan','=','pemesanan.id_pemesanan')
            ->join('produk','item_pemesanan.id_produk','=','produk.id_produk')
            ->where('status_pemesanan','SUKSES')
            ->whereYear('pemesanan.tgl_pemesanan',$search)
            ->select(DB::raw('DATE_FORMAT(pemesanan.tgl_pemesanan, "%Y") as thn'))
            ->groupBy('pemesanan.tgl_pemesanan')
            ->first();
            
            $this->data['pengadaanTahunan'] = $pengadaanTahunan;
            $this->data['subtotalsetahun'] = $subtotalsetahun;
            $this->data['bulan'] = $bulanSuper;
            $this->data['tahun'] = $tahun;

            return view('pengadaanTahunan.index', $this->data);
        }
    }

    public function cetakLaporanProduk(Request $request,$year)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else if (Session::get('jabatan_pegawai') != 'Admin') {
            return redirect('/')->with('status', 'Anda bukan merupakan Admin');
        }else {

            $search = $year;
            for($i = 1; $i <= 12; $i++){
                $transaksi[$i] = \DB::table('transaksi')
                ->join('item_transaksi','item_transaksi.id_transaksi','=','transaksi.id_transaksi')
                ->join('produk','item_transaksi.id_produk','=','produk.id_produk')
                ->whereYear('transaksi.tgl_transaksi',$year)
                ->whereMonth('transaksi.tgl_transaksi',$i)
                ->where('status_transaksi','LUNAS')
                ->select(DB::raw('DATE_FORMAT(transaksi.tgl_transaksi, "%M") as tgl'),
                    DB::raw('DATE_FORMAT(transaksi.tgl_transaksi, "%Y") as tahun'),
                    'produk.nama_produk as nama_produk',
                    'item_transaksi.id_produk', 
                    \DB::raw('COUNT(item_transaksi.id_produk) as count'))
                ->groupBy('item_transaksi.id_produk')
                ->groupBy('nama_produk')
                ->groupBy('transaksi.tgl_transaksi')
                ->orderBy('count','DESC')
                ->first();
            }

            $bulanSuper = ["","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
           
            $tahun = \DB::table('transaksi')
                ->join('item_transaksi','item_transaksi.id_transaksi','=','transaksi.id_transaksi')
                ->join('produk','item_transaksi.id_produk','=','produk.id_produk')
                ->whereYear('transaksi.tgl_transaksi',$year)
                ->where('status_transaksi','LUNAS')
                // ->whereMonth('transaksi.tgl_transaksi',$i)
                ->select(DB::raw('DATE_FORMAT(transaksi.tgl_transaksi, "%Y") as thn'))
                ->groupBy('transaksi.tgl_transaksi')
                ->first();

            $this->data['transaksi'] = $transaksi;
            $this->data['bulan'] = $bulanSuper;
            $this->data['tahun'] = $tahun;
            // return view('produkTerlaris.index', $this->data);


            $pdf = PDF::loadview('produkTerlaris.produk_pdf',$this->data);
            return $pdf->download('laporan_produk_terlaris.pdf');
        }
    }

    public function cetakLaporanLayanan(Request $request,$year)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else if (Session::get('jabatan_pegawai') != 'Admin') {
            return redirect('/')->with('status', 'Anda bukan merupakan Admin');
        }else {
            $search = $year;
            for($i = 1; $i <= 12; $i++){
                $transaksi[$i] = \DB::table('transaksi')
                ->join('item_transaksi','item_transaksi.id_transaksi','=','transaksi.id_transaksi')
                ->join('harga_layanan','item_transaksi.id_harga_layanan','=','harga_layanan.id_harga_layanan')
                ->join('layanan','harga_layanan.id_layanan','=','layanan.id_layanan')
                ->join('jenis_hewan','harga_layanan.id_jenis','=','jenis_hewan.id_jenis')
                ->join('ukuran_hewan','harga_layanan.id_ukuran','=','ukuran_hewan.id_ukuran')
                ->whereYear('transaksi.tgl_transaksi',$year)
                ->whereMonth('transaksi.tgl_transaksi',$i)
                ->where('status_transaksi','LUNAS')
                ->select(DB::raw('DATE_FORMAT(transaksi.tgl_transaksi, "%M") as bln'),
                    'jenis_hewan.nama_jenis as nama_jenis',
                    'ukuran_hewan.nama_ukuran as nama_ukuran',
                    'layanan.nama_layanan as nama_layanan',
                    'item_transaksi.id_harga_layanan as id_harga_layanan',
                    \DB::raw('COUNT(item_transaksi.id_harga_layanan) as count'))
                ->groupBy('item_transaksi.id_harga_layanan')
                ->groupBy('layanan.nama_layanan')
                ->groupBy('jenis_hewan.nama_jenis')
                ->groupBy('ukuran_hewan.nama_ukuran')
                ->groupBy('transaksi.tgl_transaksi')
                ->orderBy('count','DESC')
                ->first();
            }

            $bulanSuper = ["","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
           
            $tahun = \DB::table('transaksi')
                ->join('item_transaksi','item_transaksi.id_transaksi','=','transaksi.id_transaksi')
                ->join('produk','item_transaksi.id_produk','=','produk.id_produk')
                ->whereYear('transaksi.tgl_transaksi',$year)
                ->where('status_transaksi','LUNAS')
                // ->whereMonth('transaksi.tgl_transaksi',$i)
                ->select(DB::raw('DATE_FORMAT(transaksi.tgl_transaksi, "%Y") as thn'))
                ->groupBy('transaksi.tgl_transaksi')
                ->first();

            $this->data['transaksi'] = $transaksi;
            $this->data['bulan'] = $bulanSuper;
            $this->data['tahun'] = $tahun;
            // return view('produkTerlaris.index', $this->data);


            $pdf = PDF::loadview('layananTerlaris.layanan_pdf',$this->data);
            return $pdf->download('laporan_layanan_terlaris.pdf');

        }
    }

    public function cetakLaporanBulanan(Request $request,$year,$month)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else if (Session::get('jabatan_pegawai') != 'Admin') {
            return redirect('/')->with('status', 'Anda bukan merupakan Admin');
        }else {
                $bulananLayanan = Transaksi::select(DB::raw("CONCAT(layanan.nama_layanan,' ',CONCAT(jenis_hewan.nama_jenis,' ', ukuran_hewan.nama_ukuran)) as nama_layanan"),
                DB::raw("FORMAT(SUM(transaksi.total_layanan),0) as total"))
                ->join('item_transaksi','transaksi.id_transaksi','=','item_transaksi.id_transaksi')
                ->join('harga_layanan','item_transaksi.id_harga_layanan','=','harga_layanan.id_harga_layanan')
                ->join('layanan','harga_layanan.id_layanan','=','layanan.id_layanan')
                ->join('jenis_hewan','harga_layanan.id_jenis','=','jenis_hewan.id_jenis')
                ->join('ukuran_hewan','harga_layanan.id_ukuran','=','ukuran_hewan.id_ukuran')
                ->where('jenis_transaksi','Layanan')
                ->where('status_transaksi','LUNAS')
                ->whereYear('transaksi.tgl_transaksi',$year)
                ->whereMonth('transaksi.tgl_transaksi',$month)
                ->groupBy('nama_layanan')
                ->groupBy('jenis_hewan.nama_jenis')
                ->groupBy('ukuran_hewan.nama_ukuran')
                ->groupBy('harga_layanan.id_layanan')
                ->orderBy('total','DESC')
                ->get();

                $bulananProduk = Transaksi::select(DB::raw("produk.nama_produk as nama_produk"),
                DB::raw("FORMAT(SUM(transaksi.total_produk),0) as total"))
                ->join('item_transaksi','item_transaksi.id_transaksi','=','transaksi.id_transaksi')
                ->join('produk','item_transaksi.id_produk','=','produk.id_produk')
                ->where('jenis_transaksi','Produk')
                ->where('status_transaksi','LUNAS')
                ->whereYear('transaksi.tgl_transaksi',$year)
                ->whereMonth('transaksi.tgl_transaksi',$month)
                ->groupBy('nama_produk')
                ->groupBy('produk.id_produk')
                ->orderBy('total','DESC')
                ->get();

        $totalBulanLayanan = DB::table('transaksi')
        ->where('status_transaksi','LUNAS')
        ->where('jenis_transaksi','Layanan')
        ->whereYear('transaksi.tgl_transaksi',$year)
        ->whereMonth('transaksi.tgl_transaksi',$month)
        ->select(DB::raw('FORMAT(SUM(IFNULL(total_layanan,0)),0) as subtotal'))
        ->first();

        $totalBulanProduk = DB::table('transaksi')
        ->where('status_transaksi','LUNAS')
        ->where('jenis_transaksi','Produk')
        ->whereYear('transaksi.tgl_transaksi',$year)
        ->whereMonth('transaksi.tgl_transaksi',$month)
        ->select(DB::raw('FORMAT(SUM(IFNULL(total_produk,0)),0) as subtotal'))
        ->first();

        $tahun = \DB::table('transaksi')
        ->join('item_transaksi','item_transaksi.id_transaksi','=','transaksi.id_transaksi')
        ->join('produk','item_transaksi.id_produk','=','produk.id_produk')
        ->whereYear('transaksi.tgl_transaksi',$year)
        ->whereMonth('transaksi.tgl_transaksi',$month)
        ->select(DB::raw('DATE_FORMAT(transaksi.tgl_transaksi, "%Y") as thn'))
        ->groupBy('transaksi.tgl_transaksi')
        ->first();

        $bulanSuper = ["","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];

        
        $bulan = \DB::table('transaksi')
        ->join('item_transaksi','item_transaksi.id_transaksi','=','transaksi.id_transaksi')
        ->join('produk','item_transaksi.id_produk','=','produk.id_produk')
        ->whereYear('transaksi.tgl_transaksi',$year)
        ->whereMonth('transaksi.tgl_transaksi',$month)
        ->select(DB::raw('DATE_FORMAT(transaksi.tgl_transaksi, "%M") as bln'),
            DB::raw('DATE_FORMAT(transaksi.tgl_transaksi, "%m") as angka'))
        ->groupBy('transaksi.tgl_transaksi')
        ->first();
        
        $this->data['bulananLayanan'] = $bulananLayanan;
        $this->data['bulananProduk'] = $bulananProduk;
        $this->data['totalBulanLayanan'] = $totalBulanLayanan;
        $this->data['totalBulanProduk'] = $totalBulanProduk;

        $this->data['bulan'] = $bulan;
        $this->data['tahun'] = $tahun;

        // return view('pendapatanBulanan.index', $this->data);

        
        $pdf = PDF::loadview('pendapatanBulanan.bulanan_pdf',$this->data);
        return $pdf->download('laporan_pendapatan_bulanan.pdf');
        }
    }

    public function cetakLaporanTahunan(Request $request,$year){
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else if (Session::get('jabatan_pegawai') != 'Admin') {
            return redirect('/')->with('status', 'Anda bukan merupakan Admin');
        } else {
            for($i = 1; $i <= 12; $i++){
                $pendapatanTahunan[$i] = \DB::table('transaksi')
                ->where('status_transaksi','LUNAS')
                ->whereYear('transaksi.tgl_transaksi',$year)
                ->whereMonth('transaksi.tgl_transaksi',$i)
                ->select(DB::raw('DATE_FORMAT(transaksi.tgl_transaksi,"%M") as bulan'),
                    DB::raw('FORMAT(SUM(total_produk),0) as total_produk'),
                    DB::raw('FORMAT(SUM(total_layanan),0) as total_layanan'),
                    DB::raw('FORMAT(SUM(total_pembayaran_pembelian),0) as subtotal'),
                    DB::raw('FORMAT(SUM(IFNULL(total_layanan,0))+SUM(IFNULL(total_produk,0)),0) as total'))
                ->groupBy('transaksi.tgl_transaksi')
                ->first();
            }
            
            $subtotalsetahun = DB::table('transaksi')
            ->where('status_transaksi','LUNAS')
            ->whereYear('transaksi.tgl_transaksi',$year)
            ->select(DB::raw('FORMAT(SUM(total_pembayaran_pembelian),0) as subtotal'))
            ->first();

            $bulanSuper = ["","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];  
            
            $tahun = \DB::table('transaksi')
            ->join('item_transaksi','item_transaksi.id_transaksi','=','transaksi.id_transaksi')
            ->join('produk','item_transaksi.id_produk','=','produk.id_produk')
            ->whereYear('transaksi.tgl_transaksi',$year)
            ->where('status_transaksi','LUNAS')
            ->select(DB::raw('DATE_FORMAT(transaksi.tgl_transaksi, "%Y") as thn'))
            ->groupBy('transaksi.tgl_transaksi')
            ->first();
            
            $this->data['pendapatanTahunan'] = $pendapatanTahunan;
            $this->data['subtotalsetahun'] = $subtotalsetahun;
            $this->data['bulan'] = $bulanSuper;
            $this->data['tahun'] = $tahun;

            // return view('pendapatanTahunan.index', $this->data);
            $pdf = PDF::loadview('pendapatanTahunan.tahunan_pdf',$this->data);
            return $pdf->download('laporan_pendapatan_tahunan.pdf');

        }
    }

    public function cetakPengadaanBulanan(Request $request,$year,$month){
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else if (Session::get('jabatan_pegawai') != 'Admin') {
            return redirect('/')->with('status', 'Anda bukan merupakan Admin');
        } else {            
            $pengadaanBulan = Pemesanan::select(DB::raw("produk.nama_produk as nama_produk"),
            DB::raw("FORMAT(SUM(pemesanan.total_pembayaran_pemesanan),0) as total"))
            ->join('item_pemesanan','pemesanan.id_pemesanan','=','item_pemesanan.id_pemesanan')
            ->join('produk','item_pemesanan.id_produk','=','produk.id_produk')
            ->where('status_pemesanan','SUKSES')
            ->whereYear('pemesanan.tgl_pemesanan',$year)
            ->whereMonth('pemesanan.tgl_pemesanan',$month)
            ->groupBy('nama_produk')
            ->orderBy('total','DESC')
            ->get();

        $subtotalsebulan = DB::table('pemesanan')
        ->where('status_pemesanan','SUKSES')
        ->whereYear('pemesanan.tgl_pemesanan',$year)
        ->whereMonth('pemesanan.tgl_pemesanan',$month)
        ->select(DB::raw('FORMAT(SUM(IFNULL(total_pembayaran_pemesanan,0)),0) as subtotal'))
        ->first();

        $tahun = \DB::table('pemesanan')
        ->join('item_pemesanan','pemesanan.id_pemesanan','=','item_pemesanan.id_pemesanan')
        ->join('produk','item_pemesanan.id_produk','=','produk.id_produk')
        ->where('status_pemesanan','SUKSES')
        ->whereYear('pemesanan.tgl_pemesanan',$year)
        ->whereMonth('pemesanan.tgl_pemesanan',$month)
        ->select(DB::raw('DATE_FORMAT(pemesanan.tgl_pemesanan, "%Y") as thn'))
        ->groupBy('pemesanan.tgl_pemesanan')
        ->first();

        $bulanSuper = ["","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];

        $bulan = \DB::table('pemesanan')
        ->join('item_pemesanan','pemesanan.id_pemesanan','=','item_pemesanan.id_pemesanan')
        ->join('produk','item_pemesanan.id_produk','=','produk.id_produk')
        ->where('status_pemesanan','SUKSES')
        ->whereYear('pemesanan.tgl_pemesanan',$year)
        ->whereMonth('pemesanan.tgl_pemesanan',$month)
        ->select(DB::raw('DATE_FORMAT(pemesanan.tgl_pemesanan, "%M") as bln'))
        ->groupBy('pemesanan.tgl_pemesanan')
        ->first();

        $bulan1 = $month;
        
        $this->data['pengadaanBulan'] = $pengadaanBulan;
        $this->data['subtotalsebulan'] = $subtotalsebulan;

        // $this->data['subtotalsetahun'] = $subtotalsetahun;
        $this->data['bulan1'] = $bulan1;
        $this->data['bulan'] = $bulan;
        $this->data['tahun'] = $tahun;

        $pdf = PDF::loadview('pengadaanBulanan.pengadaan_bulanan_pdf',$this->data);
        return $pdf->download('laporan_pengadaan_bulanan.pdf');
        }
    }

    public function cetakPengadaanTahunan(Request $request,$year){
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else if (Session::get('jabatan_pegawai') != 'Admin') {
            return redirect('/')->with('status', 'Anda bukan merupakan Admin');
        } else {
            for($i = 1; $i <= 12; $i++){
                $pengadaanTahunan[$i] = \DB::table('pemesanan')
                ->where('status_pemesanan','SUKSES')
                ->whereYear('pemesanan.tgl_pemesanan',$year)
                ->whereMonth('pemesanan.tgl_pemesanan',$i)
                ->select(DB::raw('DATE_FORMAT(pemesanan.tgl_pemesanan,"%M") as bulan'),
                    DB::raw('FORMAT(SUM(total_pembayaran_pemesanan),0) as total'))
                ->groupBy('pemesanan.tgl_pemesanan')
                ->first();
            }
            
            $subtotalsetahun = DB::table('pemesanan')
            ->where('status_pemesanan','SUKSES')
            ->whereYear('pemesanan.tgl_pemesanan',$year)
            ->select(DB::raw('FORMAT(SUM(total_pembayaran_pemesanan),0) as subtotal'))
            ->first();

            $bulanSuper = ["","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
            
            $tahun = \DB::table('pemesanan')
            ->join('item_pemesanan','item_pemesanan.id_pemesanan','=','pemesanan.id_pemesanan')
            ->join('produk','item_pemesanan.id_produk','=','produk.id_produk')
            ->where('status_pemesanan','SUKSES')
            ->whereYear('pemesanan.tgl_pemesanan',$year)
            ->select(DB::raw('DATE_FORMAT(pemesanan.tgl_pemesanan, "%Y") as thn'))
            ->groupBy('pemesanan.tgl_pemesanan')
            ->first();
            
            $this->data['pengadaanTahunan'] = $pengadaanTahunan;
            $this->data['subtotalsetahun'] = $subtotalsetahun;
            $this->data['bulan'] = $bulanSuper;
            $this->data['tahun'] = $tahun;

            $pdf = PDF::loadview('pengadaanTahunan.pengadaan_tahunan_pdf',$this->data);
            return $pdf->download('laporan_pengadaan_tahunan.pdf');
        }
    }

}
