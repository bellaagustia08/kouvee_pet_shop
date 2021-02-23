@extends('layout.home')

@section('title', 'Data Member')

@section('container')
<div class="container">
    <h1 class="mt-4">DAFTAR DATA MEMBER</h1>
    <div class="row">
        <div class="col-6">
            <form action="/searchMember" method="get">
                <div class="input-group">
                    <input type="search" name="search" class="form-control">
                    <span class="input-group-prepend">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </span>
                </div>
            </form>
        </div>
    </div>
    <a href="/member/create" class="btn my-3" style="background:#df7861;">Tambah Data Member</a>

    <table class="table table-hover" style="width:1225px; background:#ffeadb; border-radius:10px; ">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th style="text-align:center" scope="col">ID Member</th>
                <th scope="col">Nama Member</th>
                <th scope="col">Tanggal Lahir</th>
                <th scope="col">Alamat</th>
                <th scope="col">Nomor Telepon</th>
                <th style="text-align:center" scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach( $member as $member )
            <tr>

                <th scope="row"></th>
                <td style="text-align:center">{{ $member->id_member }}</td>
                <td>{{ $member->nama_member }}</td>
                <td>{{ $member->tgl_lahir_member }}</td>
                <td>{{ $member->alamat_member }}</td>
                <td>{{ $member->no_telp_member }}</td>
                <td style="text-align:center">
                    <a href="/member/{{$member->id_member}}" class="badge badge-info"
                        style="background:#df7861;">Detail</a>
                    <a href="/member/{{$member->id_member}}/edit" class="badge badge-primary">Ubah</a>
                    <form action="/member/{{ $member->id_member }}" method="post" class="d-inline">
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