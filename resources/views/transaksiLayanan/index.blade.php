@extends('layout.home')

@section('title', 'Data Transaksi Layanan')

@section('container')
<div class="container">
    <h1 class="mt-4">DAFTAR DATA TRANSAKSI LAYANAN</h1>
    <!--<div class="row">
        <div class="col-6">
            <form action="/searchTransaksiLayanan" method="get">
                <div class="input-group">
                    <input type="search" name="search" class="form-control">
                    <span class="input-group-prepend">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </span>
                </div>
            </form>
        </div>
    </div>-->
    <a href="/transaksiLayanan/create" class="btn my-3" style="background:#565d47; color:white;">Tambah Transaksi Layanan</a>
    <br></br>
    <table id="table-datatables" class="table table-hover" style="width:1225px; background:#ffeadb; border-radius:10px; ">
        <thead>
            <tr>
                <th style="text-align:center" scope="col">ID Transaksi</th>
                <th scope="col">Nama Transaksi</th>
                <th scope="col">Status Transaksi</th>
                <th scope="col">Total Pembayaran Pembelian</th>
                <th style="text-align:center" scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach( $transaksi as $itemTransaksi )
            <tr>
                <td style="text-align:center">{{ $itemTransaksi->id_transaksi }}</td>
                <td>{{ $itemTransaksi->nama_transaksi }}</td>  
                <td>{{ $itemTransaksi->status_transaksi }}</td>
                <td>{{ $itemTransaksi->total_pembayaran_pembelian }}</td>
                <td style="text-align:center">
                    <a href="/transaksiLayanan/{{$itemTransaksi->id_transaksi}}" class="badge badge-info" style="background:#565d47; color:white;">Detail</a>
                @if($itemTransaksi->total_pembayaran_pembelian == 0)
                    <form action="/transaksiLayanan/{{$itemTransaksi->id_transaksi}}" method="post" class="d-inline">
                        @method('delete')
                        @csrf
                        <button type="submit" class="badge badge-danger" data-toggle="modal" data-target="#delete">Hapus</button>
                    </form>
                @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection