@extends('layout.home')

@section('title', 'Detail Hewan')

@section('container')
<div class="container">
    <div class="row">
        <div class="col-6">
            <h4><a href="/hewan" class="card-link">Kembali</a></h4>
            <h1 class="mt-4">Detail Hewan</h1>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{$hewan->nama_hewan}}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Tanggal Lahir : {{$hewan->tgl_lahir_hewan}}</h6>
                    <h6 class="card-subtitle mb-2 text-muted">Jenis : {{$hewan->JenisHewan->nama_jenis}}</h6>
                    <h6 class="card-subtitle mb-2 text-muted">Ukuran : {{$hewan->UkuranHewan->nama_ukuran}}</h6>
                    <h6 class="card-subtitle mb-2 text-muted">Nama Member : {{$hewan->Member->nama_member}}</h6>
                    <h6 class="card-subtitle mb-2 text-muted">Hewan diinput Oleh : {{$hewan->hewan_nama_log}}</h6>
                    <h6 class="card-subtitle mb-2 text-muted">Waktu Hewan diinput : {{$hewan->hewan_create_log}}</h6>
                    <h6 class="card-subtitle mb-2 text-muted">Waktu hewan Terakhir diedit : {{$hewan->hewan_edit_log}}</h6>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection