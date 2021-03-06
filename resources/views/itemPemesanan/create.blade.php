@extends('layout.home')

@section('title', 'Form Tambah Data Produk Pemesanan')

@section('container')
<div class="container">
    <div class="row">
        <div class="col-6">
            <hr>
            <h4><a href="/pemesanan/{{$pemesanan->id_pemesanan}}" class="card-link" style="color:whitesmoke"><i class="fa fa-arrow-circle-left"></i>Kembali</a></h4>
            <h1 class="mt-4">Form Tambah Data Produk Pemesanan</h1>

            <form method="post" action="/pemesanan/{{$pemesanan->id_pemesanan}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="id_produk" style="color: white">Nama Produk</label><br>
                    <select name="id_produk" id="id_produk" class="btn btn-sm dropdown-toggle" style="background:white; width:350px; color:black;">
                        @foreach($produk as $produk)
                        @if($produk->produk_delete_log == NULL)
                        <option value="{{ $produk->id_produk }}">{{$produk->nama_produk}} || Rp {{$produk->harga_produk}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="satuan_item_pemesanan" style="color: white">Satuan Item</label><br>
                    <select name="satuan_item_pemesanan" id="satuan_item_pemesanan" class="btn btn-sm dropdown-toggle" style="background:white; width:350px; color:black;">
                        <option value="PACK">PACK</option>
                        <option value="ITEM">ITEM</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="jumlah_item_pemesanan" style="color: white">Jumlah Item</label>
                    <input type="number" class="form-control @error('jumlah_item_pemesanan') is-invalid @enderror" id="jumlah_item_pemesanan" name="jumlah_item_pemesanan" placeholder="Masukkan Jumlah Item" value="{{old('jumlah_item_pemesanan')}}" style="width:350px;">
                    <div class="invalid-feedback">
                        Jumlah Item tidak boleh kosong.
                    </div>
                </div>

                <button class="btn" type="submit" style="background:#565d47; color:white;">Tambah Data Produk Pemesanan</button>
            </form>
        </div>
    </div>
</div>
@endsection