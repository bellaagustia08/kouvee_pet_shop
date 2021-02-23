@extends('../layout/home')

@section('title', 'Detail Produk')

@section('container')
<div class="container">
    <div class="row">
        <div class="col-6">
            <hr>
            <h4><a href="/produk" class="card-link" style="color:whitesmoke"><i class="fa fa-arrow-circle-left"></i>Kembali</a></h4>
            <h1 class="mt-4">Detail Produk</h1>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{$produk->nama_produk}}</h5>
                    <h5><img src="/gambar/{{$produk->gambar}}" style="width:200px"></h5>
                    <h6 class="card-subtitle mb-2 text-muted">Jumlah Stok : {{$produk->jumlah_stok_produk}}</h6>
                    <h6 class="card-subtitle mb-2 text-muted">Stok Minimum Produk : {{$produk->stok_minimum_produk}}</h6>
                    <h6 class="card-subtitle mb-2 text-muted">Harga Produk : {{$produk->harga_produk}}</h6>
                    <h6 class="card-subtitle mb-2 text-muted">Produk diinput Oleh : {{$produk->produk_nama_log}}</h6>
                    <h6 class="card-subtitle mb-2 text-muted">Waktu Produk diinput : {{$produk->produk_create_log}}</h6>
                    <h6 class="card-subtitle mb-2 text-muted">Waktu Produk Terakhir diedit : {{$produk->produk_edit_log}}</h6>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection