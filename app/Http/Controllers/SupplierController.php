<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{

    public function index()
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else {
            $supplier = Supplier::where('supplier_delete_log', NULL)->get();
            return view('supplier.index', compact('supplier'));
        }
    }

    public function indexMobile()
    {
        $index =  DB::table('supplier')->get();
        return response()->json($index, 200);
    }

    public function create()
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else {
            return view('supplier.create');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_supplier' => 'required',
            'alamat_supplier' => 'required',
            'no_telp_supplier' => 'required'
        ]);

        $supplier = new Supplier;
        $supplier->nama_supplier = $request->nama_supplier;
        $supplier->alamat_supplier = $request->alamat_supplier;
        $supplier->no_telp_supplier = $request->no_telp_supplier;
        $supplier->supplier_edit_log = NULL;
        $supplier->supplier_create_log = NOW();
        $supplier->supplier_nama_log = 'ADMIN';

        $supplier->save();

        return redirect('/supplier')->with('status', 'Data Supplier Berhasil ditambahkan!');
    }


    public function show(Supplier $supplier)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else {
            return view('supplier.show', compact('supplier'));
        }
    }

    public function edit(Supplier $supplier)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else {
            return view('supplier.edit', compact('supplier'));
        }
    }


    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'nama_supplier' => 'required',
            'alamat_supplier' => 'required',
            'no_telp_supplier' => 'required'
        ]);

        Supplier::where('id_supplier', $supplier->id_supplier)
            ->update([
                'nama_supplier' => $request->nama_supplier,
                'alamat_supplier' => $request->alamat_supplier,
                'no_telp_supplier' => $request->no_telp_supplier,
                'supplier_edit_log' => NOW()
            ]);

        return redirect('/supplier')->with('status', 'Data Suplier Berhasil diubah!');
    }


    public function destroy(Request $request, Supplier $supplier)
    {
        //Supplier::destroy($supplier->id_supplier);
        //return redirect('/supplier')->with('status', 'Data Supplier Berhasil dihapus!');

        $request->validate([
            'supplier_delete_log' => NOW()
        ]);

        Supplier::where('id_supplier', $supplier->id_supplier)
            ->update([
                'supplier_delete_log' => NOW()
            ]);

        return redirect('/supplier')->with('status', 'Data Supplier Berhasil dihapus!');
    }

    public function search(Request $request)
    {
        if (!Session::get('login')) {
            return redirect('/')->with('status', 'Anda harus login dulu');
        } else {
            $search  = $request->get('search');
            $supplier = DB::table('supplier')->where([
                ['nama_supplier', 'like', '%' . $search . '%'],
                ['supplier_delete_log', NULL],
            ])
                ->orWhere([
                    ['id_supplier', 'like', '%' . $search . '%'],
                    ['supplier_delete_log', NULL],
                ])
                ->get();
            return view('supplier.index',  compact('supplier'));
        }
    }
}
