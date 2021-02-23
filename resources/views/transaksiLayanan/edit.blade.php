@extends('layout.home')

@section('title', 'Form Ubah Layanan')

@section('container')
<div class="container">
    <div class="row">
        <div class="col-6">
            <h4><a href="/transaksiLayanan/{{$transaksiLayanan->id_transaksi}}" class="card-link">Kembali</a></h4>
            <h1 class="mt-4">Form Ubah Layanan</h1>
            <form method="POST" action="/transaksiLayanan/{{$transaksiLayanan->id_item_transaksi}}" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <div class="form-group">
                    <label for="id_harga_layanan">Layanan </label>
                    <select name="id_harga_layanan" id="id_harga_layanan" class="btn btn-sm dropdown-toggle" style="background:#f5cab3; width:350px">
                        @foreach($hargaLayanan as $hargaLayanan)
                            <option value="{{ $hargaLayanan->id_harga_layanan }}" {{ $hargaLayanan->id_harga_layanan == $transaksiLayanan->id_harga_layanan ? 'selected' : ''}}><?= $hargaLayanan->Layanan->nama_layanan ?> <?= $hargaLayanan->JenisHewan->nama_jenis ?> <?= $hargaLayanan->UkuranHewan->nama_ukuran ?></option>
                        @endforeach
                    </select>
                </div>
                <button class="btn btn-primary" type="submit">Ubah Data Penjualan</button>
            </form>
        </div>
    </div>
</div>
@endsection