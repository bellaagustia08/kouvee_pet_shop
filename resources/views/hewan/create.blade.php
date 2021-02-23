@extends('layout.home')

@section('title', 'Form Tambah Data Hewan')

@section('container')
<div class="container">
    <div class="row">
        <div class="col-6">
            <h4><a href="/hewan" class="card-link">Kembali</a></h4>
            <h1 class="mt-4">Form Tambah Data Hewan</h1>

            <form method="POST" action="/hewan">
                @csrf
                <div class="form-group">
                    <label for="nama_hewan">Nama hewan</label>
                    <input type="text" class="form-control @error('nama_hewan') is-invalid @enderror" id="nama_hewan" placeholder="Masukan Nama Hewan" name="nama_hewan" value="{{ old('nama_hewan') }}">
                    <div class="invalid-feedback">
                        Nama Hewan tidak boleh kosong.
                    </div>
                </div>
                <div class="form-group">
                    <label for="tgl_lahir_hewan">Tanggal Lahir</label>
                    <input type="date" class="form-control @error('tgl_lahir_hewan') is-invalid @enderror" id="tgl_lahir_hewan" placeholder="Masukan Tanggal Lahir" name="tgl_lahir_hewan" value="{{ old('tgl_lahir_hewan') }}">
                    <div class="invalid-feedback">
                        Tanggal Lahir harus diisi.
                    </div>
                </div>
                <div class="form-group">
                    <label for="id_jenis">Jenis Hewan</label><br>
                    <select name="id_jenis" id="id_jenis" class="btn btn-sm dropdown-toggle" style="background:#f5cab3; width:200px">
                        @foreach($jenisHewan as $jenisHewan)
                        <option value="<?= $jenisHewan->id_jenis ?>"><?= $jenisHewan->nama_jenis ?></option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="id_ukuran">Ukuran Hewan</label><br>
                    <select name="id_ukuran" id="id_ukuran" class="btn btn-sm dropdown-toggle" style="background:#f5cab3; width:200px">
                        @foreach($ukuranHewan as $ukuranHewan)
                        <option value="<?= $ukuranHewan->id_ukuran ?>"><?= $ukuranHewan->nama_ukuran ?></option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="id_member">Nama Member</label><br>
                    <select name="id_member" id="id_member" class="btn btn-sm dropdown-toggle" style="background:#f5cab3; width:200px">
                        @foreach($member as $member)
                        <option value="<?= $member->id_member ?>"><?= $member->nama_member ?></option>
                        @endforeach
                    </select>
                </div>

                <button class="btn btn-primary" type="submit">Tambah Data Hewan</button>
            </form>
        </div>
    </div>
</div>
@endsection