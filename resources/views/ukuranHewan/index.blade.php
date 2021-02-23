@extends('layout.home')

@section('title', 'Data Ukuran Hewan')

@section('container')
<div class="container">
    <h1 class="mt-4">DAFTAR DATA UKURAN HEWAN</h1>
    <div class="row">
        <div class="col-6">
            <form action="/searchUkuranHewan" method="get">
                <div class="input-group">
                    <input type="search" name="search" class="form-control">
                    <span class="input-group-prepend">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </span>
                </div>
            </form>
        </div>
    </div>
    <a href="/ukuranHewan/create" class="btn my-3" style="background:#df7861;">Tambah Data Ukuran Hewan</a>

    <table class="table table-hover" style="width:750px; background:#ffeadb; border-radius:10px; ">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th style="text-align:center" scope="col">ID Ukuran Hewan</th>
                <th scope="col">Nama Ukuran Hewan</th>
                <th style="text-align:center" scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach( $ukuranHewan as $ukuranHewan )
            <tr>

                <th scope="row"></th>
                <td style="text-align:center">{{ $ukuranHewan->id_ukuran }}</td>
                <td>{{ $ukuranHewan->nama_ukuran }}</td>
                <td style="text-align:center">
                    <a href="/ukuranHewan/{{$ukuranHewan->id_ukuran}}" class="badge badge-info"
                        style="background:#df7861;">Detail</a>
                    <a href="/ukuranHewan/{{$ukuranHewan->id_ukuran}}/edit" class="badge badge-primary">Ubah</a>
                    <form action="/ukuranHewan/{{ $ukuranHewan->id_ukuran }}" method="post" class="d-inline">
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