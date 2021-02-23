@extends('layout.home')

@section('title', 'Form Ubah Item Transaksi')

@section('container')
<div class="container">
    <div class="row">
        <div class="col-6">
            @if (session('login_kasir'))
            <h4><a href="/transaksi/{{$itemTransaksi->id_transaksi}}" class="card-link" style="color:whitesmoke"><i class="fa fa-arrow-circle-left"></i>Kembali</a></h4>
            @endif

            @if (session('login_cs') && $itemTransaksi->id_harga_layanan == NULL)
            <h4><a href="/penjualanProduk/{{$itemTransaksi->id_transaksi}}" class="card-link" style="color:whitesmoke"><i class="fa fa-arrow-circle-left"></i>Kembali</a></h4>
            @elseif (session('login_cs') && $itemTransaksi->id_produk == NULL)
            <h4><a href="/transaksiLayanan/{{$itemTransaksi->id_transaksi}}" class="card-link" style="color:whitesmoke"><i class="fa fa-arrow-circle-left"></i>Kembali</a></h4>
            @endif

            @if (session('login_admin') && $itemTransaksi->id_harga_layanan == NULL)
            <h4><a href="/penjualanProduk/{{$itemTransaksi->id_transaksi}}" class="card-link" style="color:whitesmoke"><i class="fa fa-arrow-circle-left"></i>Kembali</a></h4>
            @elseif (session('login_admin') && $itemTransaksi->id_produk == NULL)
            <h4><a href="/transaksiLayanan/{{$itemTransaksi->id_transaksi}}" class="card-link" style="color:whitesmoke"><i class="fa fa-arrow-circle-left"></i>Kembali</a></h4>
            @endif

            <h1 class="mt-4">Edit Item Transaksi</h1>
            <form method="post" action="/itemTransaksi/{{$itemTransaksi->id_item_transaksi}}" enctype="multipart/form-data">
                @method('patch')
                @csrf

                @if($itemTransaksi->id_harga_layanan == NULL)
                <div class="form-group">
                    <label for="jumlah_item_transaksi">Jumlah Item</label><br>
                    <input style="width:350px" type="number" class="form-control @error('jumlah_item_transaksi') is-invalid @enderror" id="jumlah_item_transaksi" placeholder="pcs" name="jumlah_item_transaksi" value="{{ $itemTransaksi->jumlah_item_transaksi }}">
                    <div class="invalid-feedback">
                        Jumlah Item tidak boleh kosong.
                    </div>
                </div>
                <button class="btn" type="submit" style="background:#565d47; color:white; border-color:#565d47">Ubah Data Item Produk</button>

                @elseif($itemTransaksi->id_produk == NULL)
                <div class="form-group">
                    <label for="id_harga_layanan">Layanan </label><br>
                    <select name="id_harga_layanan" id="id_harga_layanan" class="btn btn-sm dropdown-toggle" style="background:#565d47; color:white; border-color:#565d47; width:350px">
                        @foreach($hargaLayanan as $hargaLayanan)
                        <option value="{{ $hargaLayanan->id_harga_layanan }}" {{ $hargaLayanan->id_harga_layanan == $itemTransaksi->id_harga_layanan ? 'selected' : ''}}><?= $hargaLayanan->Layanan->nama_layanan ?> <?= $hargaLayanan->JenisHewan->nama_jenis ?> <?= $hargaLayanan->UkuranHewan->nama_ukuran ?></option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="jumlah_item_transaksi">Jumlah Item</label><br>
                    <input style="width:350px" type="number" class="form-control @error('jumlah_item_transaksi') is-invalid @enderror" id="jumlah_item_transaksi" placeholder="pcs" name="jumlah_item_transaksi" value="{{ $itemTransaksi->jumlah_item_transaksi }}">
                    <div class="invalid-feedback">
                        Jumlah Item tidak boleh kosong.
                    </div>
                </div>
                <button class="btn btn-primary" type="submit" style="background:#565d47; color:white; border-color:#565d47">Ubah Data Item Layanan</button>

                @endif
            </form>
        </div>
    </div>
</div>
@endsection