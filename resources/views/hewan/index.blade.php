@extends('layout.home')

@section('title', 'Data Hewan')

@section('container')
<div class="container">
    <h1 class="mt-4">DAFTAR DATA HEWAN</h1>
    <div class="row">
        <div class="col-6">
            <form action="/searchHewan" method="get">
                <div class="input-group">
                    <input type="search" name="search" class="form-control">
                    <span class="input-group-prepend">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </span>
                </div>
            </form>
        </div>
    </div>
    <a href="/hewan/create" class="btn my-3" style="background:#df7861;">Tambah Data Hewan</a>

    <table class="table table-hover" style="width:1225px; background:#ffeadb; border-radius:10px; ">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th style="text-align:center" scope="col">ID Hewan</th>
                <th scope="col">Nama Hewan</th>
                <th scope="col">Tanggal Lahir</th>
                <th scope="col">Jenis Hewan</th>
                <th scope="col">Ukuran Hewan</th>
                <th scope="col">Nama Member</th>
                <th style="text-align:center" scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach( $hewan as $hewan )
            <tr>
                <th scope="row"></th>
                <td style="text-align:center">{{ $hewan->id_hewan }}</td>
                <td>{{ $hewan->nama_hewan }}</td>
                <td>{{ $hewan->tgl_lahir_hewan }}</td>
                <td>{{ $hewan->jenisHewan->nama_jenis }}</td>
                <td>{{ $hewan->ukuranHewan->nama_ukuran }}</td>
                <td>{{ $hewan->member->nama_member }}</td>
                <td style="text-align:center">
                    <a href="/hewan/{{$hewan->id_hewan}}" class="badge badge-info"
                        style="background:#df7861;">Detail</a>
                    <a href="/hewan/{{$hewan->id_hewan}}/edit" class="badge badge-primary">Ubah</a>
                    <form action="/hewan/{{ $hewan->id_hewan }}" method="post" class="d-inline">
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