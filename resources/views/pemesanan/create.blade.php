@extends('layout.home')

@section('title', 'Form Tambah Data Pemesanan')

@section('container')
<div class="container">
    <div class="row">
        <div class="col-6">
            <hr>
            <h4><a href="/pemesanan" class="card-link" style="color:whitesmoke"><i class="fa fa-arrow-circle-left"></i>Kembali</a></h4>
            <h1 class="mt-4">Form Tambah Pemesanan</h1>

            <form method="POST" action="/pemesanan">
                @csrf
                <div class="form-group">
                    <label for="id_supplier" style="color: white">Nama Supplier</label><br>
                    <select name="id_supplier" id="id_supplier" class="btn btn-sm dropdown-toggle" style="background:white; width:350px; color:black;">
                        @foreach($supplier as $supplier)
                        <option value="{{ $supplier->id_supplier }}">{{$supplier->nama_supplier}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="tgl_pemesanan" style="color: white">Tanggal Pemesanan </label>
                    <input type="date" class="form-control @error('tgl_pemesanan') is-invalid @enderror" id="tgl_pemesanan" name="tgl_pemesanan" placeholder="Masukkan tanggal pemesanan" value="{{old('tgl_pemesanan')}}" style="width:350px;">
                    <div class="invalid-feedback">
                        Tanggal tidak boleh kosong.
                    </div>
                </div>

                <button class="btn" type="submit" style="background:#565d47; color:white;">Tambah Data Pemesanan</button>
            </form>
        </div>
    </div>
</div>
@endsection