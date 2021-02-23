@extends('layout.home')

@section('title', 'Data Produk')

@section('container')
<div class="container">
    <h1 class="mt-4" style="color:white;">DAFTAR DATA PRODUK</h1>
    <!-- <div class="row">
        <div class="col-6">
            <form action="/searchProduk" method="get">
                <div class="input-group">
                    <input type="search" name="search" class="form-control">
                    <span class="input-group-prepend">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>

                </div>
            </form>
        </div>
    </div> -->


    <a href="/produk/create" class="btn my-3" style="background:#565d47; color:white;">Tambah Data Produk</a>
    <a href="/produk" class="btn"><i class="material-icons" style="color: whitesmoke">refresh</i></a>
   
    <table class="table table-hover" id="table-datatables" style="width:1225px; background:#ffeadb; border-radius:10px; ">
        <thead>
            <tr>
                <th style="text-align:center" scope="col">ID Produk</th>
                <th scope="col">Nama Produk</th>
                <th scope="col">Jumlah Stok</th>
                <th scope="col">Stok Minimum Produk</th>
                <th scope="col">Harga Produk</th>
                <th style="text-align:center" scope="col">Gambar</th>
                <th style="text-align:center" scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach( $produk as $produk )
            <tr>
                <td style="text-align:center">{{ $produk->id_produk }}</td>
                <td>{{ $produk->nama_produk }}</td>
                <td style="text-align:center">{{ $produk->jumlah_stok_produk }}</td>
                <td style="text-align:center">{{ $produk->stok_minimum_produk }}</td>
                <td style="text-align:center">{{ $produk->harga_produk }}</td>
                <td style="text-align:center"><img src="/gambar/{{$produk->gambar}}" style="width:80px"></td>
                <td style="text-align:center">
                    <a href="/produk/{{$produk->id_produk}}" class="badge badge-info" style="background:#565d47;">Detail</a>
                    <a href="/produk/{{$produk->id_produk}}/edit" class="badge badge-primary">Ubah</a>

                    <form action="/produk/{{ $produk->id_produk }}" method="post" class="d-inline">
                        @method('delete')
                        @csrf
                        <button class="badge badge-danger" id="delete" onclick="return confirm('Yakin ingin menghapus data tersebut?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


@endsection