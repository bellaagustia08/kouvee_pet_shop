<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Hewan;
use App\JenisHewan;
use App\Member;
use App\UkuranHewan;
use Illuminate\Http\Request;
use League\CommonMark\Extension\Table\Table;

class HewanController extends Controller
{

    public function index()
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        }
        else if(Session::get('jabatan_pegawai') != 'Customer Service' && Session::get('jabatan_pegawai') != 'Admin'){
            return redirect('/')->with('status','Anda bukan merupakan CS atau admin');
        } 
        else {
            $hewan = Hewan::with('JenisHewan', 'UkuranHewan', 'Member')
            ->where('hewan_delete_log', NULL)->get();
            return view('hewan.index', compact('hewan'));
        }
    }

    public function indexMobile()
    {
        $index =  DB::table('hewan')->get();
        return response()->json($index, 200);
    }

    public function create()
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } 
        else if(Session::get('jabatan_pegawai') != 'Customer Service' && Session::get('jabatan_pegawai') != 'Admin'){
            return redirect('/')->with('status','Anda bukan merupakan CS atau admin');
        }
        else {
            $jenisHewan = JenisHewan::where('jenisHewan_delete_log', NULL)->get();
            $ukuranHewan = UkuranHewan::where('ukuranHewan_delete_log', NULL)->get();
            $member = Member::where('member_delete_log', NULL)->get();
            $data = array(
                'jenisHewan' => $jenisHewan,
                'ukuranHewan' => $ukuranHewan,
                'member' => $member
            );
            return view('hewan.create', $data);
        }
    }


    public function store(Request $request)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } 
        else if(Session::get('jabatan_pegawai') != 'Customer Service' && Session::get('jabatan_pegawai') != 'Admin'){
            return redirect('/')->with('status','Anda bukan merupakan CS atau admin');
        } 
        else {
            $request->validate([
                'nama_hewan' => 'required',
                'tgl_lahir_hewan' => 'required',
                'id_jenis' => 'required',
                'id_ukuran' => 'required',
                'id_member' => 'required',
                'hewan_create_log' => NOW()
            ]);

            $hewan = new Hewan;
            $hewan->nama_hewan = $request->nama_hewan;
            $hewan->tgl_lahir_hewan = $request->tgl_lahir_hewan;
            $hewan->id_jenis = $request->id_jenis;
            $hewan->id_ukuran = $request->id_ukuran;
            $hewan->id_member = $request->id_member;
            $hewan->hewan_edit_log = NULL;
            $hewan->hewan_create_log = NOW();
            $hewan->hewan_nama_log = 'ADMIN';

            $hewan->save();

            return redirect('/hewan')->with('status', 'Data Hewan Berhasil ditambahkan!');
        }
    }


    public function show(Hewan $hewan)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } 
        else if(Session::get('jabatan_pegawai') != 'Customer Service' && Session::get('jabatan_pegawai') != 'Admin'){
            return redirect('/')->with('status','Anda bukan merupakan CS atau admin');
        }
        else {
            return view('hewan.show', compact('hewan'));
        }
    }

    public function edit(Hewan $hewan)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } 
        else if(Session::get('jabatan_pegawai') != 'Customer Service' && Session::get('jabatan_pegawai') != 'Admin'){
            return redirect('/')->with('status','Anda bukan merupakan CS atau admin');
        }
        else {
            $hewan = $hewan;
            $jenisHewan = JenisHewan::all();
            $ukuranHewan = UkuranHewan::all();
            $member = Member::all();
            $data = array(
                'hewan' => $hewan,
                'jenisHewan' => $jenisHewan,
                'ukuranHewan' => $ukuranHewan,
                'member' => $member
            );
            return view('hewan.edit', $data);
            //return view('hewan.edit', compact('hewan'));
        }
    }


    public function update(Request $request, Hewan $hewan)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } 
        else if(Session::get('jabatan_pegawai') != 'Customer Service' && Session::get('jabatan_pegawai') != 'Admin'){
            return redirect('/')->with('status','Anda bukan merupakan CS atau admin');
        }
        else {
            $request->validate([
                'nama_hewan' => 'required',
                'tgl_lahir_hewan' => 'required',
                'id_jenis' => 'required',
                'id_ukuran' => 'required',
                'id_member' => 'required'
            ]);

            Hewan::where('id_hewan', $hewan->id_hewan)
                ->update([
                    'nama_hewan' => $request->nama_hewan,
                    'tgl_lahir_hewan' => $request->tgl_lahir_hewan,
                    'id_jenis' => $request->id_jenis,
                    'id_ukuran' => $request->id_ukuran,
                    'id_member' => $request->id_member,
                    'hewan_edit_log' => NOW()
                ]);

            return redirect('/hewan')->with('status', 'Data Hewan Berhasil diubah!');
        }
    }


    public function destroy(Request $request, Hewan $hewan)
    {
        //Hewan::destroy($hewan->id_hewan);
        //return redirect('/hewan')->with('status', 'Data Hewan Berhasil dihapus!');

        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } 
        else if(Session::get('jabatan_pegawai') != 'Customer Service' && Session::get('jabatan_pegawai') != 'Admin'){
            return redirect('/')->with('status','Anda bukan merupakan CS atau admin');
        }
        else {
            $request->validate([
                'hewan_delete_log' => NOW()
            ]);

            Hewan::where('id_hewan', $hewan->id_hewan)
                ->update([
                    'hewan_delete_log' => NOW()
                ]);

            return redirect('/hewan')->with('status', 'Data Hewan Berhasil dihapus!');
        }
    }

    public function search(Request $request)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } 
        else if(Session::get('jabatan_pegawai') != 'Customer Service' && Session::get('jabatan_pegawai') != 'Admin'){
            return redirect('/')->with('status','Anda bukan merupakan CS atau admin');
        }
        else {
            $search  = $request->get('search');

            $hewan = Hewan::with('JenisHewan', 'UkuranHewan', 'Member')
                ->where([
                    ['nama_hewan', 'like', '%' . $search . '%'],
                    ['hewan_delete_log', NULL],
                ])
                ->orWhere([
                    ['id_hewan', 'like', '%' . $search . '%'],
                    ['hewan_delete_log', NULL],
                ])
                ->get();
            return view('hewan.index',  compact('hewan'));
        }
    }
}
