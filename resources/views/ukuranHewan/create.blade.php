@extends('layout.home')

@section('title', 'Form Tambah Data Ukuran Hewan')

@section('container')
<div class="container">
    <div class="row">
        <div class="col-6">
            <h4><a href="/ukuranHewan" class="card-link">Kembali</a></h4>
            <h1 class="mt-4">Form Tambah Data Ukuran Hewan</h1>

            <form method="POST" action="/ukuranHewan">
                @csrf
                <div class="form-group">
                    <label for="nama_ukuran">Nama Ukuran Hewan</label>
                    <input type="text" class="form-control @error('nama_ukuran') is-invalid @enderror" id="nama_ukuran" placeholder="Masukan Nama Ukuran Hewan" name="nama_ukuran" value="{{ old('nama_ukuran') }}">
                    <div class="invalid-feedback">
                        Nama Ukuran Hewan tidak boleh kosong.
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">Tambah Data Ukuran Hewan</button>
            </form>
        </div>
    </div>
</div>
@endsection