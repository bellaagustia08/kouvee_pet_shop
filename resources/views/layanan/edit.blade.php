@extends('layout.home')

@section('title', 'Form Ubah Data Layanan')

@section('container')
<div class="container">
    <div class="row">
        <div class="col-6">
            <h4><a href="/layanan" class="card-link">Kembali</a></h4>
            <h1 class="mt-4">Form Ubah Data Layanan</h1>

            <form method="post" action="/layanan/{{$layanan->id_layanan}}">
                @method('patch')
                @csrf
                <div class="form-group">
                    <label for="nama_layanan">Nama Layanan</label>
                    <input type="text" class="form-control @error('nama_layanan') is-invalid @enderror" id="nama_layanan" placeholder="Masukan Nama Layanan" name="nama_layanan" value="{{ $layanan->nama_layanan }}">
                    <div class="invalid-feedback">
                        Nama Layanan tidak boleh kosong.
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">Ubah Data Layanan</button>
            </form>
        </div>
    </div>
</div>
@endsection