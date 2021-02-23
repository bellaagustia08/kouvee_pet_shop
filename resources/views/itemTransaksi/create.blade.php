@extends('layout.home')

@section('title', 'Form Tambah Item Produk')

@section('container')
<div class="container">
    <div class="row">
        <div class="col-6">
            <h4><a href="/penjualanProduk/{{$id}}" class="card-link" style="color:whitesmoke"><i class="fa fa-arrow-circle-left"></i>Kembali</a></h4>
            <h1 class="mt-4">Form Tambah Item Produk {{$id}}</h1>

            <form method="POST" action="/itemTransaksi">
                @csrf
                <div class="form-group">
                    <label for="id_produk">Nama Produk</label><br>
                    <select name="id_produk" id="id_produk" class="btn btn-sm dropdown-toggle" style="background:#565d47; color:white; border-color:#565d47; width:350px">
                        @foreach($produk as $produk)
                            <option value="<?= $produk->id_produk ?>"><?= $produk->nama_produk ?> | <?= $produk->jumlah_stok_produk ?> pcs</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="jumlah_item_transaksi">Jumlah Item</label>
                    <input type="number" class="form-control @error('jumlah_item_transaksi') is-invalid @enderror" id="jumlah_item_transaksi" placeholder="pcs" name="jumlah_item_transaksi" value="{{ old('jumlah_item_transaksi') }}" style="width:100px">
                    <div class="invalid-feedback">
                        Jumlah item tidak boleh kosong.
                    </div>
                </div>
                <input type="hidden" name="id_transaksi" id="id_transaksi" value="{{$id}}">
                <button class="btn btn-primary" type="submit" style="background:#565d47; color:white; border-color:#565d47">Tambah Item Produk</button>
            </form>
        </div>
    </div>
</div>
@endsection