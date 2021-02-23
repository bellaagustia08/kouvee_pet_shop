@extends('layout.home')

@section('title', 'Detail Ukuran Hewan')

@section('container')
<div class="container">
    <div class="row">
        <div class="col-6">
            <h4><a href="/ukuranHewan" class="card-link">Kembali</a></h4>
            <h1 class="mt-4">Detail Ukuran Hewan</h1>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{$ukuranHewan->nama_ukuran}}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Ukuran Hewan diinput Oleh : {{$ukuranHewan->ukuranHewan_nama_log}}</h6>
                    <h6 class="card-subtitle mb-2 text-muted">Waktu Ukuran Hewan diinput : {{$ukuranHewan->ukuranHewan_create_log}}</h6>
                    <h6 class="card-subtitle mb-2 text-muted">Waktu Ukuran hewan Terakhir diedit : {{$ukuranHewan->ukuranHewan_edit_log}}</h6>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection