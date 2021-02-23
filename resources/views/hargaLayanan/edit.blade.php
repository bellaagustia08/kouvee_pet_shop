@extends('layout.home')

@section('title', 'Form Ubah Data Harga Layanan')

@section('container')
<div class="container">
    <div class="row">
        <div class="col-6">
            <h4><a href="/hargaLayanan" class="card-link">Kembali</a></h4>
            <h1 class="mt-4">Form Ubah Data Harga Layanan</h1>

            <form method="POST" action="/hargaLayanan/{{$hargaLayanan->id_harga_layanan}}">
                @csrf
                @method('patch')
                <div class="form-group">
                    <label for="id_layanan">Nama Layanan</label><br>
                    <select name="id_layanan" id="id_layanan" class="btn btn-sm dropdown-toggle" style="background:#f5cab3; width:200px">
                        @foreach($layanan as $layanan)
                        <option value="{{ $layanan->id_layanan }}" {{ $layanan->id_layanan == $hargaLayanan->id_layanan ? 'selected' : ''}}>{{ $layanan->nama_layanan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="id_jenis">Jenis Hewan</label><br>
                    <select name="id_jenis" id="id_jenis" class="btn btn-sm dropdown-toggle" style="background:#f5cab3; width:200px">
                        @foreach($jenisHewan as $jenisHewan)
                        <option value="{{ $jenisHewan->id_jenis }}" {{ $jenisHewan->id_jenis == $hargaLayanan->id_jenis ? 'selected' : ''}}>{{$jenisHewan->nama_jenis}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="id_ukuran">Ukuran Hewan</label><br>
                    <select name="id_ukuran" id="id_ukuran" class="btn btn-sm dropdown-toggle" style="background:#f5cab3; width:200px">
                        @foreach($ukuranHewan as $ukuranHewan)
                        <option value="{{ $ukuranHewan->id_ukuran }}" {{ $ukuranHewan->id_ukuran == $hargaLayanan->id_ukuran ? 'selected' : ''}}>{{ $ukuranHewan->nama_ukuran }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="harga_layanan">Harga Layanan</label><br>
                    <input type="text" class="form-control @error('harga_layanan') is-invalid @enderror" id="harga_layanan" placeholder="Masukan Harga Layanan" name="harga_layanan" value="{{ $hargaLayanan->harga_layanan }}">
                    <div class="invalid-feedback">
                        Harga Layanan tidak boleh kosong.
                    </div>
                </div>

                <button class="btn btn-primary" type="submit">Ubah Data Harga Layanan</button>
            </form>
        </div>
    </div>
</div>
@endsection