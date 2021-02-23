<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\UkuranHewan;
use Illuminate\Http\Request;

class UkuranHewanController extends Controller
{

    public function index()
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else {
            $ukuranHewan = UkuranHewan::where('ukuranHewan_delete_log', NULL)->get();
            return view('ukuranHewan.index', compact('ukuranHewan'));
        }
    }

    public function indexMobile()
    {
        $index =  DB::table('ukuran_hewan')->get();
        return response()->json($index, 200);
    }

    public function create()
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else {
            return view('ukuranHewan.create');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_ukuran' => 'required',
        ]);

        $ukuranHewan = new UkuranHewan();
        $ukuranHewan->nama_ukuran = $request->nama_ukuran;
        $ukuranHewan->ukuranHewan_edit_log = NULL;
        $ukuranHewan->ukuranHewan_create_log = NOW();
        $ukuranHewan->ukuranHewan_nama_log = 'ADMIN';

        $ukuranHewan->save();

        return redirect('/ukuranHewan')->with('status', 'Data Jenis Hewan Berhasil ditambahkan!');
    }


    public function show(UkuranHewan $ukuranHewan)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else {
            return view('ukuranHewan.show', compact('ukuranHewan'));
        }
    }

    public function edit(UkuranHewan $ukuranHewan)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else {
            return view('ukuranHewan.edit', compact('ukuranHewan'));
        }
    }


    public function update(Request $request, UkuranHewan $ukuranHewan)
    {
        $request->validate([
            'nama_ukuran' => 'required',
        ]);

        UkuranHewan::where('id_ukuran', $ukuranHewan->id_ukuran)
            ->update([
                'nama_ukuran' => $request->nama_ukuran,
                'ukuranHewan_edit_log' => NOW()
            ]);

        return redirect('/ukuranHewan')->with('status', 'Data Ukuran Hewan Berhasil diubah!');
    }


    public function destroy(Request $request, UkuranHewan $ukuranHewan)
    {
        //UkuranHewan::destroy($ukuranHewan->id_ukuran);
        //return redirect('/ukuranHewan')->with('status', 'Data Jenis Hewan Berhasil dihapus!');

        $request->validate([
            'ukuranHewan_delete_log' => NOW()
        ]);

        UkuranHewan::where('id_ukuran', $ukuranHewan->id_ukuran)
            ->update([
                'ukuranHewan_delete_log' => NOW()
            ]);

        return redirect('/ukuranHewan')->with('status', 'Data Ukuran Hewan Berhasil dihapus!');
    }

    public function search(Request $request)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else {
            $search  = $request->get('search');
            $ukuranHewan = DB::table('ukuran_hewan')->where([
                ['nama_ukuran', 'like', '%' . $search . '%'],
                ['ukuranHewan_delete_log', NULL],
            ])
                ->orWhere([
                    ['id_ukuran', 'like', '%' . $search . '%'],
                    ['ukuranHewan_delete_log', NULL],
                ])
                ->get();
            return view('ukuranHewan.index', compact('ukuranHewan'));
        }
    }
}
