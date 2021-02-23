@extends('layout.home')

@section('title', 'Data Pegawai')

@section('container')
<div class="container">
    <h1 class="mt-4">DAFTAR DATA PEGAWAI</h1>
    <div class="row">
        <div class="col-6">
            <form action="/searchPegawai" method="get">
                <div class="input-group">
                    <input type="search" name="search" class="form-control">
                    <span class="input-group-prepend">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </span>
                </div>
            </form>
        </div>
    </div>
    <a href="/pegawai/create" class="btn my-3" style="background:#df7861;">Tambah Data Pegawai</a>

    <table class="table table-hover" style="width:1225px; background:#ffeadb; border-radius:10px; ">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th style="text-align:center" scope="col">ID Pegawai</th>
                <th scope="col">Nama Pegawai</th>
                <th scope="col">Tanggal Lahir</th>
                <th scope="col">Alamat</th>
                <th scope="col">Nomor Telepon</th>
                <th scope="col">Jabatan</th>
                <th style="text-align:center" scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach( $pegawai as $pegawai )
            <tr>

                <th scope="row"></th>
                <td style="text-align:center">{{ $pegawai->id_pegawai }}</td>
                <td>{{ $pegawai->nama_pegawai }}</td>
                <td>{{ $pegawai->tgl_lahir_pegawai }}</td>
                <td>{{ $pegawai->alamat_pegawai }}</td>
                <td>{{ $pegawai->no_telp_pegawai }}</td>
                <td>{{ $pegawai->jabatan_pegawai }}</td>
                <td style="text-align:center">
                    <a href="/pegawai/{{$pegawai->id_pegawai}}" class="badge badge-info"
                        style="background:#df7861;">Detail</a>
                    <a href="/pegawai/{{$pegawai->id_pegawai}}/edit" class="badge badge-primary">Ubah</a>
                    <form action="/pegawai/{{ $pegawai->id_pegawai }}" method="post" class="d-inline">
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