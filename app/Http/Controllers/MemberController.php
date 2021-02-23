<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
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
            $member = Member::where('member_delete_log', NULL)->get();
            return view('member.index', compact('member'));
        }
    }

    public function indexMobile()
    {
        $index =  DB::table('member')->get();
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
            return view('member.create');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_member' => 'required',
            'alamat_member' => 'required',
            'no_telp_member' => 'required'

        ]);

        $member = new Member;
        $member->nama_member = $request->nama_member;
        $member->alamat_member = $request->alamat_member;
        $member->tgl_lahir_member = $request->tgl_lahir_member;
        $member->no_telp_member = $request->no_telp_member;
        $member->member_edit_log = NULL;
        $member->member_create_log = NOW();
        $member->member_nama_log = 'ADMIN';

        $member->save();

        return redirect('/member')->with('status', 'Data Member Berhasil ditambahkan!');
    }


    public function show(Member $member)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        }
        else if(Session::get('jabatan_pegawai') != 'Customer Service' && Session::get('jabatan_pegawai') != 'Admin'){
            return redirect('/')->with('status','Anda bukan merupakan CS atau admin');
        } 
        else {
            return view('member.show', compact('member'));
        }
    }

    public function edit(Member $member)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        }
        else if(Session::get('jabatan_pegawai') != 'Customer Service' && Session::get('jabatan_pegawai') != 'Admin'){
            return redirect('/')->with('status','Anda bukan merupakan CS atau admin');
        } 
        else {
            return view('member.edit', compact('member'));
        }
    }


    public function update(Request $request, Member $member)
    {
        $request->validate([
            'nama_member' => 'required',
            'alamat_member' => 'required',
            'no_telp_member' => 'required',
            'tgl_lahir_member' => 'required'

        ]);

        Member::where('id_member', $member->id_member)
            ->update([
                'nama_member' => $request->nama_member,
                'alamat_member' => $request->alamat_member,
                'tgl_lahir_member' => $request->tgl_lahir_member,
                'no_telp_member' => $request->no_telp_member,
                'member_edit_log' => NOW()
            ]);

        return redirect('/member')->with('status', 'Data Member Berhasil diubah!');
    }


    public function destroy(Request $request, Member $member)
    {
        //Member::destroy($member->id_member);
        //return redirect('/member')->with('status', 'Data Member Berhasil dihapus!');

        $request->validate([
            'member_delete_log' => NOW()
        ]);

        Member::where('id_member', $member->id_member)
            ->update([
                'member_delete_log' => NOW()
            ]);

        return redirect('/member')->with('status', 'Data Member Berhasil dihapus!');
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
            $member = DB::table('member')->where([
                ['nama_member', 'like', '%' . $search . '%'],
                ['member_delete_log', NULL],
            ])
                ->orWhere([
                    ['id_member', 'like', '%' . $search . '%'],
                    ['member_delete_log', NULL],
                ])
                ->get();
            return view('member.index',  compact('member'));
        }
    }
}
