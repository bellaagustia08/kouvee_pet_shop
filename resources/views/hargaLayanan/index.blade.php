@extends('layout.home')

@section('title', 'Data Harga Layanan')

@section('container')
<div class="container">
    <h1 class="mt-4">DAFTAR DATA HARGA LAYANAN</h1>
    <div class="row">
        <div class="col-6">
            <form action="/searchHargaLayanan" method="get">
                <div class="input-group">
                    <input type="search" name="search" class="form-control">
                    <span class="input-group-prepend">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </span>
                </div>
            </form>
        </div>
    </div>
    <a href="/hargaLayanan/create" class="btn my-3" style="background:#df7861;">Tambah Data Harga Layanan</a>

    <table class="table table-hover" style="width:1225px; background:#ffeadb; border-radius:10px; ">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th style="text-align:center" scope="col">ID Harga Layanan</th>
                <th scope="col">Nama Layanan</th>
                <th scope="col">Jenis Hewan</th>
                <th scope="col">Ukuran Hewan</th>
                <th scope="col">Harga Layanan</th>
                <th style="text-align:center" scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach( $hargaLayanan as $hargaLayanan )
            <tr>

                <th scope="row"></th>
                <td style="text-align:center">{{ $hargaLayanan->id_harga_layanan }}</td>
                <td>{{ $hargaLayanan->layanan->nama_layanan }}</td>
                <td>{{ $hargaLayanan->jenisHewan->nama_jenis }}</td>
                <td>{{ $hargaLayanan->ukuranHewan->nama_ukuran }}</td>
                <td>{{ $hargaLayanan->harga_layanan }}</td>
                <td style="text-align:center">
                    <a href="/hargaLayanan/{{$hargaLayanan->id_harga_layanan}}" class="badge badge-info" style="background:#df7861;">Detail</a>
                    <a href="/hargaLayanan/{{$hargaLayanan->id_harga_layanan}}/edit" class="badge badge-primary">Ubah</a>
                
                <form action="/hargaLayanan/{{ $hargaLayanan->id_harga_layanan }}" method="post" class="d-inline">
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