@extends('layout.home')

@section('title', 'Form Ubah Data Pegawai')

@section('container')
<div class="container">
    <div class="row">
        <div class="col-6">
            <h4><a href="/pegawai" class="card-link">Kembali</a></h4>
            <h1 class="mt-4">Form Ubah Data Pegawai</h1>

            <form method="post" action="/pegawai/{{$pegawai->id_pegawai}}">
                @method('patch')
                @csrf
                <div class="form-group">
                    <label for="nama_pegawai">Nama Lengkap</label>
                    <input type="text" class="form-control @error('nama_pegawai') is-invalid @enderror" id="nama_pegawai" placeholder="Masukan Nama Lengkap Pegawai" name="nama_pegawai" value="{{ $pegawai->nama_pegawai }}">
                    <div class="invalid-feedback">
                        Nama Pegawai tidak boleh kosong.
                    </div>
                </div>
                <div class="form-group">
                    <label for="alamat_pegawai">Alamat</label>
                    <input type="text" class="form-control @error('alamat_pegawai') is-invalid @enderror" id="alamat_pegawai" placeholder="Masukan Alamat Pegawai" name="alamat_pegawai" value="{{ $pegawai->alamat_pegawai }}">
                    <div class="invalid-feedback">
                        Alamat tidak boleh kosong.
                    </div>
                </div>
                <div class="form-group">
                    <label for="tgl_lahir_pegawai">Tanggal Lahir</label>
                    <input type="date" class="form-control @error('tgl_lahir_pegawai') is-invalid @enderror" id="tgl_lahir_pegawai" name="tgl_lahir_pegawai" value="{{ $pegawai->tgl_lahir_pegawai }}">
                    <div class="invalid-feedback">
                        Tanggal Lahir harus diisi.
                    </div>
                </div>
                <div class="form-group">
                    <label for="no_telp_pegawai">Nomor Telepon</label>
                    <input type="text" class="form-control @error('no_telp_pegawai') is-invalid @enderror" id="no_telp_pegawai" placeholder="Masukan Nomor Telepon" name="no_telp_pegawai" value="{{ $pegawai->no_telp_pegawai }}">
                    <div class="invalid-feedback">
                        Nomor Telepon tidak boleh kosong.
                    </div>
                </div>
                <div class="form-group">
                    <label for="jabatan_pegawai">Jabatan</label>
                    <select class="custom-select custom-select-sm @error('jabatan_pegawai') is-invalid @enderror" id="jabatan_pegawai" name="jabatan_pegawai">
                        <option value="Kasir" {{ $pegawai->jabatan_pegawai == "Kasir" ? 'selected' : ''}}>Kasir</option>
                        <option value="Customer Service" {{ $pegawai->jabatan_pegawai == "Customer Service" ? 'selected' : ''}}>Customer Service</option>
                        <option value="Admin" {{ $pegawai->jabatan_pegawai == "Admin" ? 'selected' : ''}}>Admin</option>
                    </select>
                    <div class="invalid-feedback">
                        Jabatan tidak boleh kosong.
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="text" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Masukan Password" name="password" value="{{ $pegawai->password }}">
                    <div class="invalid-feedback">
                        Password tidak boleh kosong.
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">Ubah Data Pegawai</button>
            </form>
        </div>
    </div>
</div>
@endsection