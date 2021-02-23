<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{

    public function index()
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else {
            $pegawai = Pegawai::where('pegawai_delete_log', NULL)->get();
            return view('pegawai.index', compact('pegawai'));
        }
    }

    public function indexMobile()
    {
        $index =  DB::table('pegawai')->get();
        return response()->json($index, 200);
    }

    public function create()
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else {
            return view('pegawai.create');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pegawai' => 'required',
            'alamat_pegawai' => 'required',
            'no_telp_pegawai' => 'required',
            'jabatan_pegawai' => 'required',
            'password' => 'required'

        ]);

        $pegawai = new Pegawai;
        $pegawai->nama_pegawai = $request->nama_pegawai;
        $pegawai->alamat_pegawai = $request->alamat_pegawai;
        $pegawai->tgl_lahir_pegawai = $request->tgl_lahir_pegawai;
        $pegawai->no_telp_pegawai = $request->no_telp_pegawai;
        $pegawai->jabatan_pegawai = $request->jabatan_pegawai;
        $pegawai->password = $request->password;
        $pegawai->pegawai_edit_log = NULL;
        $pegawai->pegawai_create_log = NOW();
        $pegawai->pegawai_nama_log = 'ADMIN';

        $pegawai->save();

        return redirect('/pegawai')->with('status', 'Data Pegawai Berhasil ditambahkan!');
    }


    public function show(Pegawai $pegawai)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else {
            return view('pegawai.show', compact('pegawai'));
        }
    }

    public function edit(Pegawai $pegawai)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else {
            return view('pegawai.edit', compact('pegawai'));
        }
    }

    public function update(Request $request, Pegawai $pegawai)
    {
        $request->validate([
            'nama_pegawai' => 'required',
            'alamat_pegawai' => 'required',
            'tgl_lahir_pegawai' => 'required',
            'no_telp_pegawai' => 'required',
            'jabatan_pegawai' => 'required',
            'password' => 'required'
        ]);

        Pegawai::where('id_pegawai', $pegawai->id_pegawai)
            ->update([
                'nama_pegawai' => $request->nama_pegawai,
                'alamat_pegawai' => $request->alamat_pegawai,
                'tgl_lahir_pegawai' => $request->tgl_lahir_pegawai,
                'no_telp_pegawai' => $request->no_telp_pegawai,
                'jabatan_pegawai' => $request->jabatan_pegawai,
                'password' => $request->password,
                'pegawai_edit_log' => NOW()
            ]);

        return redirect('/pegawai')->with('status', 'Data Pegawai Berhasil diubah!');
    }


    public function destroy(Request $request, Pegawai $pegawai)
    {
        //Pegawai::destroy($pegawai->id_pegawai);
        //return redirect('/pegawai')->with('status', 'Data Pegawai Berhasil dihapus!');

        $request->validate([
            'pegawai_delete_log' => NOW()
        ]);

        Pegawai::where('id_pegawai', $pegawai->id_pegawai)
            ->update([
                'pegawai_delete_log' => NOW()
            ]);

        return redirect('/pegawai')->with('status', 'Data Pegawai Berhasil dihapus!');
    }

    public function search(Request $request)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else {
            $search  = $request->get('search');
            $pegawai = DB::table('pegawai')->where([
                ['nama_pegawai', 'like', '%' . $search . '%'],
                ['pegawai_delete_log', NULL],
            ])
                ->orWhere([
                    ['id_pegawai', 'like', '%' . $search . '%'],
                    ['pegawai_delete_log', NULL],
                ])
                ->get();
            return view('pegawai.index',  compact('pegawai'));
        }
    }
}
