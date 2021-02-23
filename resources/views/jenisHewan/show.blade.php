@extends('layout.home')

@section('title', 'Detail Jenis Hewan')

@section('container')
<div class="container">
    <div class="row">
        <div class="col-6">
            <h4><a href="/jenisHewan" class="card-link">Kembali</a></h4>
            <h1 class="mt-4">Detail Jenis Hewan</h1>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{$jenisHewan->nama_jenis}}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Jenis hewan diinput Oleh : {{$jenisHewan->jenisHewan_nama_log}}</h6>
                    <h6 class="card-subtitle mb-2 text-muted">Waktu Jenis Hewan diinput : {{$jenisHewan->jenisHewan_create_log}}</h6>
                    <h6 class="card-subtitle mb-2 text-muted">Waktu Jenis Hewan Terakhir diedit : {{$jenisHewan->jenisHewan_edit_log}}</h6>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection