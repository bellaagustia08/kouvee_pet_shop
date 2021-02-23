@extends('layout.home')

@section('title', 'Detail Member')

@section('container')
<div class="container">
    <div class="row">
        <div class="col-6">
            <h4><a href="/pegawai" class="card-link">Kembali</a></h4>
            <h1 class="mt-4">Detail Member</h1>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{$member->nama_member}}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Alamat : {{$member->alamat_member}}</h6>
                    <h6 class="card-subtitle mb-2 text-muted">Tanggal Lahir : {{$member->tgl_lahir_member}}</h6>
                    <h6 class="card-subtitle mb-2 text-muted">No. Telp : {{$member->no_telp_member}}</h6>
                    <h6 class="card-subtitle mb-2 text-muted">Member diinput Oleh : {{$member->member_nama_log}}</h6>
                    <h6 class="card-subtitle mb-2 text-muted">Waktu Member diinput : {{$member->member_create_log}}</h6>
                    <h6 class="card-subtitle mb-2 text-muted">Waktu Member Terakhir diedit : {{$member->member_edit_log}}</h6>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection