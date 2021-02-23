@extends('layout.home')

@section('title', 'Data Supplier')

@section('container')
<div class="container">
    <h1 class="mt-4">DAFTAR DATA SUPPLIER</h1>
    <div class="row">
        <div class="col-6">
            <form action="/searchSupplier" method="get">
                <div class="input-group">
                    <input type="search" name="search" class="form-control">
                    <span class="input-group-prepend">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </span>
                </div>
            </form>
        </div>
    </div>
    <a href="/supplier/create" class="btn my-3" style="background:#df7861;">Tambah Data Supplier</a>

    <table class="table table-hover" style="width:1225px; background:#ffeadb; border-radius:10px; ">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th style="text-align:center" scope="col">ID Supplier</th>
                <th scope="col">Nama Supplier</th>
                <th scope="col">Alamat</th>
                <th scope="col">Nomor Telepon</th>
                <th style="text-align:center" scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach( $supplier as $supplier )
            <tr>

                <th scope="row"></th>
                <td style="text-align:center">{{ $supplier->id_supplier }}</td>
                <td>{{ $supplier->nama_supplier }}</td>
                <td>{{ $supplier->alamat_supplier }}</td>
                <td>{{ $supplier->no_telp_supplier }}</td>
                <td style="text-align:center">
                    <a href="/supplier/{{$supplier->id_supplier}}" class="badge badge-info"
                        style="background:#df7861;">Detail</a>
                    <a href="/supplier/{{$supplier->id_supplier}}/edit" class="badge badge-primary">Ubah</a>
                    <form action="/supplier/{{ $supplier->id_supplier }}" method="post" class="d-inline">
                        @method('delete')
                        @csrf
                        <button class="badge badge-danger" data-toggle="modal" data-target="#delete">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection