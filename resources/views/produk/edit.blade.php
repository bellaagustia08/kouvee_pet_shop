@extends('layout.home')

@section('title', 'Form Ubah Data Produk')

@section('container')
<div class="container">
    <div class="row">
        <div class="col-6">
        <h4><a href="/produk" class="card-link" style="color:whitesmoke"><i class="fa fa-arrow-circle-left"></i>Kembali</a></h4>
            <h1 class="mt-4">Form Ubah Data Produk</h1>
            <form method="post" action="/produk/{{$produk->id_produk}}" enctype="multipart/form-data">
                @method('patch')
                @csrf
                <div class="form-group">
                    <label for="nama_produk">Nama Produk</label>
                    <input type="text" class="form-control @error('nama_produk') is-invalid @enderror" id="nama_produk" placeholder="Masukan Nama Produk" name="nama_produk" value="{{ $produk->nama_produk }}">
                    <div class="invalid-feedback">
                        Nama Produk tidak boleh kosong.
                    </div>
                </div>
                <div class="form-group">
                    <label for="jumlah_stok_produk">Jumlah Stok</label>
                    <input type="number" class="form-control @error('jumlah_stok_produk') is-invalid @enderror" id="jumlah_stok_produk" placeholder="Masukan Jumlah Stok" name="jumlah_stok_produk" value="{{ $produk->jumlah_stok_produk }}">
                    <div class="invalid-feedback">
                        Jumlah Stok tidak boleh kosong.
                    </div>
                </div>
                <div class="form-group">
                    <label for="stok_minimum_produk">stok Minimum</label>
                    <input type="number" class="form-control @error('stok_minimum_produk') is-invalid @enderror" id="stok_minimum_produk" placeholder="Masukan Stok Minimum" name="stok_minimum_produk" value="{{ $produk->stok_minimum_produk }}">
                    <div class="invalid-feedback">
                        Stok Minimum tidak boleh kosong.
                    </div>
                </div>
                <div class="form-group">
                    <label for="harga_produk">Harga Produk</label>
                    <input type="number" class="form-control @error('harga_produk') is-invalid @enderror" id="harga_produk" placeholder="Masukan Harga Produk" name="harga_produk" value="{{ $produk->harga_produk }}">
                    <div class="invalid-feedback">
                        Harga Produk tidak boleh kosong.
                    </div>
                </div>
                <div>
                    <img src="/gambar/{{$produk->gambar}}" style="width:200px">
                </div>
                <div class="form-group">
                    <label for="gambar">Gambar Produk</label>
                    <br>
                    <input type="file" placeholder="Upload gambar produk disini" name="gambar" value="{{ $produk->gambar }}">
                    <div class="invalid-feedback">
                        Gambar Produk tidak boleh kosong.
                    </div>
                </div>

                <button class="btn btn-primary" type="submit">Ubah Data Produk</button>
            </form>
        </div>
    </div>
</div>
@endsection