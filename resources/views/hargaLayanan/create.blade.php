@extends('layout.home')

@section('title', 'Form Tambah Data Harga Layanan')

@section('container')
<div class="container">
    <div class="row">
        <div class="col-6">
            <h4><a href="/hargaLayanan" class="card-link">Kembali</a></h4>
            <h1 class="mt-4">Form Tambah Data Harga Layanan</h1>

            <form method="POST" action="/hargaLayanan">
                @csrf
                <div class="form-group">
                    <label for="id_layanan">Nama Layanan</label><br>
                    <select name="id_layanan" id="id_layanan" class="btn btn-sm dropdown-toggle" style="background:#f5cab3; width:200px" value="{{ old('nama_layanan') }}">
                        @foreach($layanan as $layanan)
                        <option value="<?= $layanan->id_layanan ?>"><?= $layanan->nama_layanan ?></option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="id_jenis">Jenis Hewan</label><br>
                    <select name="id_jenis" id="id_jenis" class="btn btn-sm dropdown-toggle" style="background:#f5cab3; width:200px" value="{{ old('id_jenis') }}">
                        @foreach($jenisHewan as $jenisHewan)
                        <option value="<?= $jenisHewan->id_jenis ?>"><?= $jenisHewan->nama_jenis ?></option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="id_ukuran">Ukuran Hewan</label><br>
                    <select name="id_ukuran" id="id_ukuran" class="btn btn-sm dropdown-toggle" style="background:#f5cab3; width:200px" value="{{ old('id_ukuran') }}">
                        @foreach($ukuranHewan as $ukuranHewan)
                        <option value="<?= $ukuranHewan->id_ukuran ?>"><?= $ukuranHewan->nama_ukuran ?></option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="harga_layanan">Harga Layanan (Rp)</label>
                    <input type="number" class="form-control @error('harga_layanan') is-invalid @enderror" id="harga_layanan" placeholder="Masukan Harga Layanan" name="harga_layanan" value="{{ old('harga_layanan') }}">
                    <div class="invalid-feedback">
                        Harga Layanan tidak boleh kosong.
                    </div>
                </div>

                <button class="btn btn-primary" type="submit">Tambah Data Harga Layanan</button>
            </form>
        </div>
    </div>
</div>
@endsection