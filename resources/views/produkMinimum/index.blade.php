@extends('layout.home')

@section('title', 'Data Produk Hampir Habis')

@section('container')
<div class="container">
    <h1 class="mt-4" style="color:white;">DAFTAR DATA PRODUK HAMPIR HABIS</h1>
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
    <a href="/produkMinim" class="btn"><i class="material-icons" style="color: whitesmoke">refresh</i></a>
   
    <table class="table table-hover" id="table-datatables" style="width:1225px; background:#ffeadb; border-radius:10px; ">
        <thead>
            <tr>
                <th style="text-align:center" scope="col">ID Produk</th>
                <th scope="col">Nama Produk</th>
                <th scope="col">Jumlah Stok</th>
                <th scope="col">Stok Minimum Produk</th>
                <th style="text-align:center" scope="col">Gambar</th>
            </tr>
        </thead>
        <tbody>
            @foreach( $produk as $produk )
            <tr>
                <td style="text-align:center">{{ $produk->id_produk }}</td>
                <td>{{ $produk->nama_produk }}</td>
                <td style="text-align:center">{{ $produk->jumlah_stok_produk }}</td>
                <td style="text-align:center">{{ $produk->stok_minimum_produk }}</td>
                <td style="text-align:center"><img src="/gambar/{{$produk->gambar}}" style="width:80px"></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


@endsection