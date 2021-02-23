@extends('layout.home')

@section('title', 'Data Penjualan Produk')

@section('container')

<script>
 $(document).ready(function() {
        $('#table-datatables').DataTable({
            //dom: 'Bfrtip',
            //buttons: []
        });
    });
</script>
<div class="container">
    <h1 class="mt-4">DAFTAR DATA PENJUALAN PRODUK</h1>
    <!--<div class="row">
        <div class="col-6">
            <form action="/searchPenjualanProduk" method="get">
                <div class="input-group">
                    <input type="search" name="search" class="form-control">
                    <span class="input-group-prepend">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </span>
                </div>
            </form>
        </div>
    </div>-->
    <a href="/penjualanProduk/create" class="btn my-3" style="background:#565d47; color:white;">Tambah Data Penjualan</a>
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
            @foreach($penjualanProduk as $penjualanProduk)
            <tr>
                <td style="text-align:center">{{ $penjualanProduk->id_transaksi }}</td>
                <td>{{ $penjualanProduk->nama_transaksi }}</td>
                <td>{{ $penjualanProduk->status_transaksi }}</td>
                <td>{{ $penjualanProduk->total_pembayaran_pembelian }}</td>
                <td style="text-align:center">
                    <a href="/penjualanProduk/{{$penjualanProduk->id_transaksi}}" class="badge badge-info" style="background:#565d47; color:white;">Detail</a>
                    @if($penjualanProduk->total_pembayaran_pembelian == 0)
                    <form action="/penjualanProduk/{{$penjualanProduk->id_transaksi}}" method="post" class="d-inline">
                        @method('delete')
                        @csrf
                        <button type="submit" class="badge badge-danger" data-toggle="modal" data-target="#delete">Hapus</button>
                    </form>
                    @endif
                </td>
            </tr>
            <!-- Modal Delete
            <div class="modal modal-danger fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content"> 
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title text-center" id="myModalLabel">Konfirmasi Hapus</h4>
                        </div>
                        <form action="/penjualanProduk/{{$penjualanProduk->id_transaksi}}" method="post" class="d-inline">
                            @method('delete')
                            @csrf
                            <div class="modal-body">
                                <p class="text-center">
                                    Apakah Yakin ingin Hapus?
                                </p>
                                <input type="hidden" name="category_id" id="cat_id" value="">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" data-dismiss="modal">Tidak, Kembali</button>
                                <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div> -->
            @endforeach
        </tbody>
    </table>
</div>
@endsection