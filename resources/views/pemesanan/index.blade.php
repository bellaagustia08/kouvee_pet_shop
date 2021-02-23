@extends('layout.home')

@section('title', 'Data Pemesanan')

@section('container')
<div class="container">
    <h1 class="mt-4" style="color: white">DAFTAR DATA PENGADAAN BELUM TERKONFIRMASI</h1>
    <!--<div class="row">
        <div class="col-6">
            <form action="/searchPemesanan" method="get">
                <div class="input-group">
                    <input type="search" name="search" class="form-control">
                    <span class="input-group-prepend">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </span>
                </div>
            </form>
        </div>
    </div>-->
    <a href="/pemesanan/create" class="btn my-3" style="background:#565d47; color:white;">Tambah Data Pemesanan</a>
    <a href="/pemesanan" class="btn"><i class="material-icons" style="color: whitesmoke">refresh</i></a>

    <table class="table table-hover" id="table-datatables" style="width:1225px; background-color:#c1a57b; border-radius:10px; ">
        <thead>
            <tr>
                <th style="text-align:center" scope="col">ID</th>
                <th style="text-align:center" scope="col">Kode</th>
                <th style="text-align:center" scope="col">Nama Supplier</th>
                <th style="text-align:center" scope="col">Tanggal</th>
                <th style="text-align:center" scope="col">Status</th>
                <th style="text-align:center" scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach( $pemesanan as $pemesanan )
            <tr>
                <td style="text-align:center">{{ $pemesanan->id_pemesanan }}</td>
                <td style="text-align:center">{{ $pemesanan->nama_pemesanan }}</td>
                <td>{{ $pemesanan->Supplier->nama_supplier }}</td>
                <td style="text-align:center">{{ $pemesanan->tgl_pemesanan }}</td>
                <td style="text-align:center">{{ $pemesanan->status_pemesanan }}</td>
                <td style="text-align:center">
                    <a href="/pemesanan/{{$pemesanan->id_pemesanan}}" class="badge badge-info" style="background:#565d47;">Detail</a>
                    <a href="/pemesanan/{{$pemesanan->id_pemesanan}}/edit" class="badge badge-primary">Ubah</a>
                    <form action="/pemesanan/{{ $pemesanan->id_pemesanan }}" method="post" class="d-inline">
                        @method('delete')
                        @csrf
                        <button class="badge badge-danger" id="delete" onclick="return confirm('Yakin ingin Menghapus Data Tersebut?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection