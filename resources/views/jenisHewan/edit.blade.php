@extends('layout.home')

@section('title', 'Form Ubah Data Jenis Hewan')

@section('container')
<div class="container">
    <div class="row">
        <div class="col-6">
            <h4><a href="/jenisHewan" class="card-link">Kembali</a></h4>
            <h1 class="mt-4">Form Ubah Data Jenis Hewan</h1>

            <form method="post" action="/jenisHewan/{{$jenisHewan->id_jenis}}">
                @method('patch')
                @csrf
                <div class="form-group">
                    <label for="nama_jenis">Nama Jenis Hewan</label>
                    <input type="text" class="form-control @error('nama_jenis') is-invalid @enderror" id="nama_jenis" placeholder="Masukan Nama Jenis Hewan" name="nama_jenis" value="{{ $jenisHewan->nama_jenis }}">
                    <div class="invalid-feedback">
                        Nama Jenis Hewan tidak boleh kosong.
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">Ubah Data Jenis Hewan</button>
            </form>
        </div>
    </div>
</div>
@endsection