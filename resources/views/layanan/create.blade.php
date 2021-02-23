@extends('layout.home')

@section('title', 'Form Tambah Data Layanan')

@section('container')
<div class="container">
    <div class="row">
        <div class="col-6">
            <h4><a href="/layanan" class="card-link">Kembali</a></h4>
            <h1 class="mt-4">Form Tambah Data Layanan</h1>

            <form method="POST" action="/layanan">
                @csrf
                <div class="form-group">
                    <label for="nama_layanan">Nama Layanan</label>
                    <input type="text" class="form-control @error('nama_layanan') is-invalid @enderror" id="nama_layanan" placeholder="Masukan Nama Layanan" name="nama_layanan" value="{{ old('nama_layanan') }}">
                    <div class="invalid-feedback">
                        Nama Layanan tidak boleh kosong.
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">Tambah Data layanan</button>
            </form>
        </div>
    </div>
</div>
@endsection