@extends('layout.home')

@section('title', 'Detail Pegawai')

@section('container')
<div class="container">
    <div class="row">
        <div class="col-6">
            <h4><a href="/pegawai" class="card-link">Kembali</a></h4>
            <h1 class="mt-4">Detail Pegawai</h1>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{$pegawai->nama_pegawai}}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Alamat : {{$pegawai->alamat_pegawai}}</h6>
                    <h6 class="card-subtitle mb-2 text-muted">Tanggal Lahir : {{$pegawai->tgl_lahir_pegawai}}</h6>
                    <h6 class="card-subtitle mb-2 text-muted">No. Telp : {{$pegawai->no_telp_pegawai}}</h6>
                    <h6 class="card-subtitle mb-2 text-muted">Jabatan : {{$pegawai->jabatan_pegawai}}</h6>
                    <h6 class="card-subtitle mb-2 text-muted">Pegawai diinput Oleh : {{$pegawai->pegawai_nama_log}}</h6>
                    <h6 class="card-subtitle mb-2 text-muted">Waktu Pegawai diinput : {{$pegawai->pegawai_create_log}}</h6>
                    <h6 class="card-subtitle mb-2 text-muted">Waktu Pegawai Terakhir diedit : {{$pegawai->pegawai_edit_log}}</h6>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection