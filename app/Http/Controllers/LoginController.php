<?php

namespace App\Http\Controllers;

use App\Layanan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Login;
use App\Produk;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produk = Produk::all();
        $layanan = Layanan::all();
        $data = array (
            'produk' => $produk,
            'layanan' => $layanan,
        );
        return view('layout.login', $data);
    }
    
    public function login(Request $request){
       
        $id = $request->get('id_pegawai');

        $pegawai = DB::table('pegawai')
        ->where([
            ['id_pegawai','like','%'.$id.'%'],
        ])
        ->orWhere([
            ['nama_pegawai','like','%'.$id.'%'],
        ])
        ->first();

        if(DB::table('pegawai')
        ->where([
            ['id_pegawai','=', $id],
        ])
        ->orWhere([
            ['nama_pegawai','=', $id],
        ])
        ->exists()){
            if($pegawai->password == $request->input('password')){
                Session::put('id_pegawai',$pegawai->id_pegawai);
                Session::put('nama_pegawai',$pegawai->nama_pegawai);
                Session::put('password',$pegawai->password);
                Session::put('jabatan_pegawai',$pegawai->jabatan_pegawai);
                Session::put('login',TRUE);
                $request->session()->put('pegawai',$pegawai->nama_pegawai);
                if($pegawai->jabatan_pegawai == 'Customer Service'){
                    Session::put('login_cs',TRUE);
                    return redirect('/member')->with('success_login', 'Berhasil Login CS!');
                }
                else if($pegawai->jabatan_pegawai == 'Kasir'){
                    Session::put('login_kasir',TRUE);
                    return redirect('/transaksi')->with('success_login', 'Berhasil Login Kasir!');
                }else if($pegawai->jabatan_pegawai == 'Admin'){
                    Session::put('login_admin',TRUE);
                    $produk = DB::SELECT('SELECT
                        id_produk, 
                        nama_produk, 
                        jumlah_stok_produk, 
                        stok_minimum_produk,
                        gambar
                        FROM produk 
                        WHERE jumlah_stok_produk <= stok_minimum_produk+10 
                        AND produk_delete_log IS NULL');
                    if($produk==NULL){
                        return redirect('/produk')->with('success_login', 'Berhasil Login Admin!');
                    }elseif($produk!=NULL){
                        return redirect('/produk')
                        ->with('success_login', 'Berhasil Login Admin!')
                        ->with('alert_minim', 'ADA PRODUK YANG HAMPIR HABIS! CEK PADA KELOLA DATA MASTER');
                    }
                }
            }
            else{
                return redirect('/')->with('status', 'Akun tidak ditemukan');
                return response()->json('ID Pegawai atau Password Salah', 401);
            }
        }
        else if($pegawai == NULL){
            //return response()->json('Akun tidak ditemukan',404);
            return redirect('/')->with('status', 'Akun tidak ditemukan');
        }
    }

    // menghapus session
	public function logout(Request $request) {
        Session::flush();
        $request->session()->forget('pegawai');
        return redirect('/')->with('status', 'Anda Sudah Berhasil Logout!');
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Login  $login
     * @return \Illuminate\Http\Response
     */
    public function show(Login $login)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Login  $login
     * @return \Illuminate\Http\Response
     */
    public function edit(Login $login)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Login  $login
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Login $login)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Login  $login
     * @return \Illuminate\Http\Response
     */
    public function destroy(Login $login)
    {
        //
    }
}
