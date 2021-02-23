<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\HargaLayanan;
use App\JenisHewan;
use App\UkuranHewan;
use App\Layanan;
use Illuminate\Http\Request;
use League\CommonMark\Extension\Table\Table;

class HargaLayananController extends Controller
{

    public function index()
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else {
            $hargaLayanan = HargaLayanan::with('JenisHewan', 'UkuranHewan', 'Layanan')->where('harga_delete_log', NULL)->get();
            return view('hargaLayanan.index', compact('hargaLayanan'));
        }
    }

    public function indexMobile()
    {
        $index =  DB::table('harga_layanan')->get();
        return response()->json($index, 200);
    }

    public function create()
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else {
            $jenisHewan = JenisHewan::where('jenisHewan_delete_log', NULL)->get();
            $ukuranHewan = UkuranHewan::where('ukuranHewan_delete_log', NULL)->get();
            $layanan = Layanan::where('layanan_delete_log', NULL)->get();
            $data = array(
                'jenisHewan' => $jenisHewan,
                'ukuranHewan' => $ukuranHewan,
                'layanan' => $layanan
            );
            return view('hargaLayanan.create', $data);
        }
    }


    public function store(Request $request)
    {
        $request->validate([
            'id_layanan' => 'required',
            'id_jenis' => 'required',
            'id_ukuran' => 'required',
            'harga_layanan' => 'required',
            'harga_create_log' => NOW()
        ]);

        $hargaLayanan = new HargaLayanan;
        $hargaLayanan->id_layanan = $request->id_layanan;
        $hargaLayanan->id_jenis = $request->id_jenis;
        $hargaLayanan->id_ukuran = $request->id_ukuran;
        $hargaLayanan->harga_layanan = $request->harga_layanan;
        $hargaLayanan->harga_edit_log = NULL;
        $hargaLayanan->harga_create_log = NOW();
        $hargaLayanan->harga_nama_log = 'ADMIN';

        $hargaLayanan->save();

        return redirect('/hargaLayanan')->with('status', 'Data Harga Layanan Berhasil ditambahkan!');
    }


    public function show(HargaLayanan $hargaLayanan)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else {
            return view('hargaLayanan.show', compact('hargaLayanan'));
        }
    }

    public function edit(HargaLayanan $hargaLayanan)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else {
            $hargaLayanan = $hargaLayanan;
            $jenisHewan = JenisHewan::all();
            $ukuranHewan = UkuranHewan::all();
            $layanan = Layanan::all();
            $data = array(
                'hargaLayanan' => $hargaLayanan,
                'jenisHewan' => $jenisHewan,
                'ukuranHewan' => $ukuranHewan,
                'layanan' => $layanan
            );
            return view('hargaLayanan.edit', $data);
        }

        //return view('hewan.edit', compact('hewan'));
    }


    public function update(Request $request, HargaLayanan $hargaLayanan)
    {
        $request->validate([
            'id_layanan' => 'required',
            'id_jenis' => 'required',
            'id_ukuran' => 'required',
            'harga_layanan' => 'required'
        ]);

        HargaLayanan::where('id_harga_layanan', $hargaLayanan->id_harga_layanan)
            ->update([
                'id_layanan' => $request->id_layanan,
                'id_jenis' => $request->id_jenis,
                'id_ukuran' => $request->id_ukuran,
                'harga_layanan' => $request->harga_layanan,
                'harga_edit_log' => NOW()
            ]);

        return redirect('/hargaLayanan')->with('status', 'Data Harga Layanan Berhasil diubah!');
    }


    public function destroy(Request $request, HargaLayanan $hargaLayanan)
    {
        //Hewan::destroy($hewan->id_hewan);
        //return redirect('/hewan')->with('status', 'Data Hewan Berhasil dihapus!');

        $request->validate([
            'harga_delete_log' => NOW()
        ]);

        HargaLayanan::where('id_harga_layanan', $hargaLayanan->id_harga_layanan)
            ->update([
                'harga_delete_log' => NOW()
            ]);

        return redirect('/hargaLayanan')->with('status', 'Data Harga Layanan Berhasil dihapus!');
    }

    public function search(Request $request)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else {
            $search  = $request->get('search');
            $hargaLayanan = HargaLayanan::with('jenisHewan', 'ukuranHewan', 'Layanan')
                ->where([
                    ['id_harga_layanan', 'like', '%' . $search . '%'],
                    ['harga_delete_log', NULL],
                ])
                ->get();
            return view('hargaLayanan.index',  compact('hargaLayanan'));
        }
    }
}
