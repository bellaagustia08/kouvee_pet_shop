<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Layanan;
use Illuminate\Http\Request;

class LayananController extends Controller
{

    public function index()
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else {
            $layanan = Layanan::where('layanan_delete_log', NULL)->get();
            return view('layanan.index', compact('layanan'));
        }
    }

    public function indexMobile()
    {
        $index =  DB::table('layanan')->get();
        return response()->json($index, 200);
    }

    public function create()
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else {
            return view('layanan.create');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_layanan' => 'required',
        ]);

        $layanan = new Layanan;
        $layanan->nama_layanan = $request->nama_layanan;
        $layanan->layanan_edit_log = NULL;
        $layanan->layanan_create_log = NOW();
        $layanan->layanan_nama_log = 'ADMIN';

        $layanan->save();

        return redirect('/layanan')->with('status', 'Data Layanan Berhasil ditambahkan!');
    }


    public function show(Layanan $layanan)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else {
            return view('layanan.show', compact('layanan'));
        }
    }

    public function edit(Layanan $layanan)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else {
            return view('layanan.edit', compact('layanan'));
        }
    }


    public function update(Request $request, Layanan $layanan)
    {
        $request->validate([
            'nama_layanan' => 'required',
        ]);

        Layanan::where('id_layanan', $layanan->id_layanan)
            ->update([
                'nama_layanan' => $request->nama_layanan,
                'layanan_Edit_log' => NOW()
            ]);

        return redirect('/layanan')->with('status', 'Data Layanan Berhasil diubah!');
    }


    public function destroy(Request $request, Layanan $layanan)
    {
        //Layanan::destroy($layanan->id_layanan);
        //return redirect('/layanan')->with('status', 'Data Layanan Berhasil dihapus!');

        $request->validate([
            'layanan_delete_log' => NOW()
        ]);

        Layanan::where('id_layanan', $layanan->id_layanan)
            ->update([
                'layanan_delete_log' => NOW()
            ]);

        return redirect('/layanan')->with('status', 'Data Layanan Berhasil dihapus!');
    }

    public function search(Request $request)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else {
            $search  = $request->get('search');
            $layanan = DB::table('layanan')->where([
                ['nama_layanan', 'like', '%' . $search . '%'],
                ['layanan_delete_log', NULL],
            ])
                ->orWhere([
                    ['id_layanan', 'like', '%' . $search . '%'],
                    ['layanan_delete_log', NULL],
                ])
                ->get();
            return view('layanan.index',  ['layanan' => $layanan]);
        }
    }
}
