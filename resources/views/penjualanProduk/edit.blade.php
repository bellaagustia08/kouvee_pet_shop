@extends('layout.home')

@section('title', 'Form Ubah Penjualan')

@section('container')
<div class="container">
    <div class="row">
        <div class="col-6">
            <h4><a href="/penjualanProduk/{{$penjualanProduk->id_transaksi}}" class="card-link">Kembali</a></h4>
            <h1 class="mt-4">Form Ubah Item Penjualan</h1>
            <form method="POST" action="/penjualanProduk/{{$penjualanProduk->id_item_transaksi}}" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <div class="form-group">
                    <label for="jumlah_item_transaksi">Jumlah Item</label><br>
                    <input type="number" class="form-control @error('jumlah_item_transaksi') is-invalid @enderror" id="jumlah_item_transaksi" placeholder="pcs" name="jumlah_item_transaksi" value="{{ $penjualanProduk->jumlah_item_transaksi }}">
                    <div class="invalid-feedback">
                        Jumlah Item tidak boleh kosong.
                    </div>
                </div>
                <button class="btn btn-primary" type="submit" >Ubah Data Penjualan</button>
            </form>
        </div>
    </div>
</div>
@endsection