@extends('layout.home')

@section('title', 'Data Layanan')

@section('container')
<div class="container">
    <h1 class="mt-4">DAFTAR DATA LAYANAN</h1>
    <div class="row">
        <div class="col-6">
            <form action="/searchLayanan" method="get">
                <div class="input-group">
                    <input type="search" name="search" class="form-control">
                    <span class="input-group-prepend">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </span>
                </div>
            </form>
        </div>
    </div>
    <a href="/layanan/create" class="btn my-3" style="background:#df7861;">Tambah Data Layanan</a>

    <table class="table table-hover" style="width:750px; background:#ffeadb; border-radius:10px; ">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th style="text-align:center" scope="col">ID Layanan</th>
                <th scope="col">Nama Layanan</th>
                <th style="text-align:center" scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach( $layanan as $layanan )
            <tr>
                <th scope="row"></th>
                <td style="text-align:center">{{ $layanan->id_layanan }}</td>
                <td>{{ $layanan->nama_layanan }}</td>
                <td style="text-align:center">
                    <a href="/layanan/{{$layanan->id_layanan}}" class="badge badge-info" style="background:#df7861;">Detail</a>
                    <a href="/layanan/{{$layanan->id_layanan}}/edit" class="badge badge-primary">Ubah</a>
                <form action="/layanan/{{ $layanan->id_layanan }}" method="post" class="d-inline">
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