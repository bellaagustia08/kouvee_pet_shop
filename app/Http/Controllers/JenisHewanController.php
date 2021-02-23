<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\JenisHewan;
use Illuminate\Http\Request;

class JenisHewanController extends Controller
{

    public function index()
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else {
            $jenisHewan = JenisHewan::where('jenisHewan_delete_log', NULL)->get();
            return view('jenisHewan.index', compact('jenisHewan'));
        }
    }

    public function indexMobile()
    {
        $index =  DB::table('jenis_hewan')->get();
        return response()->json($index, 200);
    }

    public function create()
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else {
            return view('jenisHewan.create');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jenis' => 'required',
        ]);

        $jenisHewan = new JenisHewan();
        $jenisHewan->nama_jenis = $request->nama_jenis;
        $jenisHewan->jenisHewan_edit_log = NULL;
        $jenisHewan->jenisHewan_create_log = NOW();
        $jenisHewan->jenisHewan_nama_log = 'ADMIN';

        $jenisHewan->save();

        return redirect('/jenisHewan')->with('status', 'Data Jenis Hewan Berhasil ditambahkan!');
    }


    public function show(JenisHewan $jenisHewan)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else {
            return view('jenisHewan.show', compact('jenisHewan'));
        }
    }

    public function edit(JenisHewan $jenisHewan)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else {
            return view('jenisHewan.edit', compact('jenisHewan'));
        }
    }


    public function update(Request $request, JenisHewan $jenisHewan)
    {
        $request->validate([
            'nama_jenis' => 'required',
        ]);

        JenisHewan::where('id_jenis', $jenisHewan->id_jenis)
            ->update([
                'nama_jenis' => $request->nama_jenis,
                'jenisHewan_edit_log' => NOW()
            ]);

        return redirect('/jenisHewan')->with('status', 'Data Jenis Hewan Berhasil diubah!');
    }


    public function destroy(Request $request, JenisHewan $jenisHewan)
    {
        //JenisHewan::destroy($jenisHewan->id_jenis);
        //return redirect('/jenisHewan')->with('status', 'Data Jenis Hewan Berhasil dihapus!');

        $request->validate([
            'jenisHewan_delete_log' => NOW()
        ]);

        JenisHewan::where('id_jenis', $jenisHewan->id_jenis)
            ->update([
                'jenisHewan_delete_log' => NOW()
            ]);

        return redirect('/jenisHewan')->with('status', 'Data Jenis Hewan Berhasil dihapus!');
    }

    public function search(Request $request)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else {
            $search  = $request->get('search');
            $jenisHewan = DB::table('jenis_hewan')
                ->where([
                    ['nama_jenis', 'like', '%' . $search . '%'],
                    ['jenisHewan_delete_log', NULL],
                ])
                ->orWhere([
                    ['id_jenis', 'like', '%' . $search . '%'],
                    ['jenisHewan_delete_log', NULL],
                ])
                ->get();
            return view('jenisHewan.index', compact('jenisHewan'));
        }
    }
}
