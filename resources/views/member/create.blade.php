@extends('layout.home')

@section('title', 'Form Tambah Data Member')

@section('container')
<div class="container">
    <div class="row">
        <div class="col-6">
            <h4><a href="/member" class="card-link">Kembali</a></h4>
            <h1 class="mt-4">Form Tambah Data Member</h1>

            <form method="POST" action="/member">
                @csrf
                <div class="form-group">
                    <label for="nama_member">Nama Lengkap</label>
                    <input type="text" class="form-control @error('nama_member') is-invalid @enderror" id="nama_member" placeholder="Masukan Nama Lengkap member" name="nama_member" value="{{ old('nama_member') }}">
                    <div class="invalid-feedback">
                        Nama Member tidak boleh kosong.
                    </div>
                </div>
                <div class="form-group">
                    <label for="alamat_member">Alamat</label>
                    <input type="text" class="form-control @error('alamat_member') is-invalid @enderror" id="alamat_member" placeholder="Masukan Alamat member" name="alamat_member" value="{{ old('alamat_member') }}">
                    <div class="invalid-feedback">
                        Alamat tidak boleh kosong.
                    </div>
                </div>
                <div class="form-group">
                    <label for="tgl_lahir_member">Tanggal Lahir</label>
                    <input type="date" class="form-control @error('tgl_lahir_member') is-invalid @enderror" id="tgl_lahir_member" name="tgl_lahir_member" value="{{ old('tgl_lahir_member') }}">
                    <div class="invalid-feedback">
                        Tanggal Lahir harus diisi.
                    </div>
                </div>
                <div class="form-group">
                    <label for="no_telp_member">Nomor Telepon +62</label>
                    <input type="text" class="form-control @error('no_telp_member') is-invalid @enderror" id="no_telp_member" placeholder="8121212121" name="no_telp_member" value="{{ old('no_telp_member') }}">
                    <div class="invalid-feedback">
                        Nomor Telepon tidak boleh kosong.
                    </div>
                </div>

                <button class="btn btn-primary" type="submit">Tambah Data Member</button>
            </form>
        </div>
    </div>
</div>
@endsection