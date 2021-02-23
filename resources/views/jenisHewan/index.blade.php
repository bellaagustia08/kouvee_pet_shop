@extends('layout.home')

@section('title', 'Data Jenis Hewan')

@section('container')
<div class="container">
    <h1 class="mt-4">DAFTAR DATA JENIS HEWAN</h1>
    <div class="row">
        <div class="col-6">
            <form action="/searchJenisHewan" method="get">
                <div class="input-group">
                    <input type="search" name="search" class="form-control">
                    <span class="input-group-prepend">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </span>
                </div>
            </form>
        </div>
    </div>
    <a href="/jenisHewan/create" class="btn my-3" style="background:#df7861;">Tambah Data Jenis Hewan</a>

    <table class="table table-hover" style="width:750px; background:#ffeadb; border-radius:10px; ">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th style="text-align:center" scope="col">ID Jenis Hewan</th>
                <th scope="col">Nama Jenis Hewan</th>
                <th style="text-align:center" scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach( $jenisHewan as $jenisHewan )
            <tr>

                <th scope="row"></th>
                <td style="text-align:center">{{ $jenisHewan->id_jenis }}</td>
                <td>{{ $jenisHewan->nama_jenis }}</td>
                <td style="text-align:center">
                    <a href="/jenisHewan/{{$jenisHewan->id_jenis}}" class="badge badge-info"
                        style="background:#df7861;">Detail</a>
                    <a href="/jenisHewan/{{$jenisHewan->id_jenis}}/edit" class="badge badge-primary">Ubah</a>
                    <form action="/jenisHewan/{{ $jenisHewan->id_jenis }}" method="post" class="d-inline">
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