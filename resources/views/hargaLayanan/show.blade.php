@extends('layout.home')

@section('title', 'Detail Harga Layanan')

@section('container')
<div class="container">
    <div class="row">
        <div class="col-6">
            <h4><a href="/hargaLayanan" class="card-link">Kembali</a></h4>
            <h1 class="mt-4">Detail Harga Layanan</h1>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $hargaLayanan->layanan->nama_layanan }} {{ $hargaLayanan->jenisHewan->nama_jenis }} {{ $hargaLayanan->ukuranHewan->nama_ukuran }}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Harga Layanan : {{$hargaLayanan->harga_layanan}}</h6>
                    <h6 class="card-subtitle mb-2 text-muted">Harga Layanan diinput Oleh : {{$hargaLayanan->harga_nama_log}}</h6>
                    <h6 class="card-subtitle mb-2 text-muted">Waktu Harga Layanan diinput : {{$hargaLayanan->harga_create_log}}</h6>
                    <h6 class="card-subtitle mb-2 text-muted">Waktu Harga Layanan Terakhir diedit : {{$hargaLayanan->harga_edit_log}}</h6>
                </div>
            </div>
        </div>
    </div>
@endsection