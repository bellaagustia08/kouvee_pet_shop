@extends('layout.home')

@section('title', 'Detail Supplier')

@section('container')
<div class="container">
    <div class="row">
        <div class="col-6">
            <h4><a href="/supplier" class="card-link">Kembali</a></h4>
            <h1 class="mt-4">Detail Supplier</h1>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{$supplier->nama_supplier}}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Alamat : {{$supplier->alamat_supplier}}</h6>
                    <h6 class="card-subtitle mb-2 text-muted">No. Telp : {{$supplier->no_telp_supplier}}</h6>
                    <h6 class="card-subtitle mb-2 text-muted">Supplier diinput Oleh : {{$supplier->supplier_nama_log}}</h6>
                    <h6 class="card-subtitle mb-2 text-muted">Waktu supplier diinput : {{$supplier->supplier_create_log}}</h6>
                    <h6 class="card-subtitle mb-2 text-muted">Waktu supplier Terakhir diedit : {{$supplier->supplier_edit_log}}</h6>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection