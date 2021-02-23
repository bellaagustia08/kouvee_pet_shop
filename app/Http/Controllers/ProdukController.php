<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illiminate\Support\Collection;
use App\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{

    public function index()
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } 
        else if(Session::get('jabatan_pegawai') != 'Admin'){
            return redirect('/')->with('status','Anda bukan merupakan CS atau admin');
        }
        else {
            $produk = Produk::where('produk_delete_log',NULL)->orderBy('harga_produk','DESC')->get();
            return view('produk.index', compact('produk'));
        }
    }


    public function indexMobile()
    {
        $index =  DB::table('produk')->get();
        return response()->json($index, 200);
    }

    public function create()
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else {
            return view('produk.create');
        }
    }

    public function store(Request $request)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } 
        else if(Session::get('jabatan_pegawai') != 'Admin'){
            return redirect('/')->with('status','Anda bukan merupakan CS atau admin');
        }
        else {
            $request->validate([
                'nama_produk' => 'required',
                'jumlah_stok_produk' => 'required',
                'stok_minimum_produk' => 'required',
                'harga_produk' => 'required',
                'gambar' => 'required',
                'produk_create_log' => NOW()
            ]);

            $file = $request->file('gambar');
            $nama_file = time() . '_' . $_FILES['gambar']['name'];

            $tujuan = '../public/gambar/' . $nama_file;
            move_uploaded_file($_FILES['gambar']['tmp_name'], $tujuan);

            $produk = new Produk;
            $produk->nama_produk = $request->nama_produk;
            $produk->jumlah_stok_produk = $request->jumlah_stok_produk;
            $produk->stok_minimum_produk = $request->stok_minimum_produk;
            $produk->harga_produk = $request->harga_produk;
            $produk->gambar = $nama_file;
            $produk->produk_create_log = NOW();
            $produk->produk_edit_log = NULL;
            $produk->produk_nama_log = 'ADMIN';

            $produk->save();

            return redirect('/produk')->with('status', 'Data Produk Berhasil ditambahkan!');
        }
    }


    public function show(Produk $produk)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } 
        else if(Session::get('jabatan_pegawai') != 'Admin'){
            return redirect('/')->with('status','Anda bukan merupakan CS atau admin');
        }
        else {
            return view('produk.show', compact('produk'));
        }
    }

    public function edit(Produk $produk)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } 
        else if(Session::get('jabatan_pegawai') != 'Admin'){
            return redirect('/')->with('status','Anda bukan merupakan CS atau admin');
        }
        else {
            return view('produk.edit', compact('produk'));
        }
    }


    public function update(Request $request, Produk $produk)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } 
        else if(Session::get('jabatan_pegawai') != 'Admin'){
            return redirect('/')->with('status','Anda bukan merupakan CS atau admin');
        }
        else {
            $request->validate([
                'nama_produk' => 'required',
                'jumlah_stok_produk' => 'required',
                'stok_minimum_produk' => 'required',
                'harga_produk' => 'required',
                'gambar' => 'required',
                'produk_edit_log' => NOW()
            ]);

            $file = $request->file('gambar');
            $nama_file = time() . '_' . $_FILES['gambar']['name'];

            $tujuan = '../public/gambar/' . $nama_file;
            move_uploaded_file($_FILES['gambar']['tmp_name'], $tujuan);

            Produk::where('id_produk', $produk->id_produk)
                ->update([
                    'nama_produk' => $request->nama_produk,
                    'jumlah_stok_produk' => $request->jumlah_stok_produk,
                    'stok_minimum_produk' => $request->stok_minimum_produk,
                    'harga_produk' => $request->harga_produk,
                    'gambar' => $nama_file,
                    'produk_edit_log' => NOW()
                ]);

            return redirect('/produk')->with('status', 'Data Produk Berhasil diubah!');
        }
    }

    public function destroy(Request $request, Produk $produk)
    {
        // Produk::destroy($produk->id_produk);
        // return redirect('/produk')->with('status', 'Data Produk Berhasil dihapus!');

        $request->validate([
            'produk_delete_log' => NOW()
        ]);

        Produk::where('id_produk', $produk->id_produk)
            ->update([
                'produk_delete_log' => NOW()
            ]);

        return redirect('/produk')->with('status', 'Data Produk Berhasil dihapus!');
    }

    public function search(Request $request)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        }
        else if(Session::get('jabatan_pegawai') != 'Admin'){
            return redirect('/')->with('status','Anda bukan merupakan CS atau admin');
        }
        else {

            $search  = $request->get('search');
            $produk = DB::table('produk')->where([
                ['nama_produk', 'like', '%' . $search . '%'],
                ['produk_delete_log', NULL],
            ])
                ->orWhere([
                    ['id_produk', 'like', '%' . $search . '%'],
                    ['produk_delete_log', NULL],
                ])
                ->get();
            return view('produk.index', compact('produk'));
        }
    }

    public function produkMinim()
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } 
        else if(Session::get('jabatan_pegawai') != 'Admin'){
            return redirect('/')->with('status','Anda bukan merupakan CS atau admin');
        }
        else {
            $produk = DB::SELECT('SELECT
                id_produk, 
                nama_produk, 
                jumlah_stok_produk, 
                stok_minimum_produk,
                gambar
                FROM produk WHERE jumlah_stok_produk <= stok_minimum_produk+10 AND produk_delete_log IS NULL');
            // ->where("jumlah_stok_produk > 1")

            $this->data['produk'] = $produk;
            return view('produkMinimum.index', $this->data);

            // return response()->json([
            //     'produk' => $produk
            // ]);
        }
    }
}
