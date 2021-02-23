@extends('layout.home')

@section('title', 'Detail Layanan')

@section('container')
<div class="container">
    <div class="row">
        <div class="col-6">
            <h4><a href="/layanan" class="card-link">Kembali</a></h4>
            <h1 class="mt-4">Detail Layanan</h1>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{$layanan->nama_layanan}}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Layanan diinput Oleh : {{$layanan->layanan_nama_log}}</h6>
                    <h6 class="card-subtitle mb-2 text-muted">Waktu Layanan diinput : {{$layanan->layanan_create_log}}</h6>
                    <h6 class="card-subtitle mb-2 text-muted">Waktu Layanan Terakhir diedit : {{$layanan->layanan_edit_log}}</h6>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection