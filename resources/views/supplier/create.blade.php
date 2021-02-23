@extends('layout.home')

@section('title', 'Form Tambah Data Supplier')

@section('container')
<div class="container">
    <div class="row">
        <div class="col-6">
            <h4><a href="/supplier" class="card-link">Kembali</a></h4>
            <h1 class="mt-4">Form Tambah Data Supplier</h1>

            <form method="POST" action="/supplier">
                @csrf
                <div class="form-group">
                    <label for="nama_supplier">Nama Lengkap</label>
                    <input type="text" class="form-control @error('nama_supplier') is-invalid @enderror" id="nama_supplier" placeholder="Masukan Nama Lengkap supplier" name="nama_supplier" value="{{ old('nama_supplier') }}">
                    <div class="invalid-feedback">
                        Nama Supplier tidak boleh kosong.
                    </div>
                </div>
                <div class="form-group">
                    <label for="alamat_supplier">Alamat</label>
                    <input type="text" class="form-control @error('alamat_supplier') is-invalid @enderror" id="alamat_supplier" placeholder="Masukan Alamat supplier" name="alamat_supplier" value="{{ old('alamat_supplier') }}">
                    <div class="invalid-feedback">
                        Alamat tidak boleh kosong.
                    </div>
                </div>
                <div class="form-group">
                    <label for="no_telp_supplier">Nomor Telepon</label>
                    <input type="text" class="form-control @error('no_telp_supplier') is-invalid @enderror" id="no_telp_supplier" placeholder="Masukan Nomor Telepon" name="no_telp_supplier" value="{{ old('no_telp_supplier') }}">
                    <div class="invalid-feedback">
                        Nomor Telepon tidak boleh kosong.
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">Tambah Data Supplier</button>
            </form>
        </div>
    </div>
</div>
@endsection