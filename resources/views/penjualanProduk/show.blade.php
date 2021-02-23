@extends('layout.home')

@section('title', 'Detail Transaksi')

@section('container')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>

<script>
 $(document).ready(function() {
        $('#table').DataTable();
    });
</script>

<div class="container">
    <div class="row">
        <div class="col-6">
        <h4><a href="/penjualanProduk" class="card-link" style="color:whitesmoke"><i class="fa fa-arrow-circle-left"></i>Kembali</a></h4>
            <h1 class="mt-4">Detail Transaksi</h1>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{$penjualanProduk->nama_transaksi}}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Jenis Transaksi : {{$penjualanProduk->jenis_transaksi}}</h6>
                    <h6 class="card-subtitle mb-2 text-muted">Status Transaksi : {{$penjualanProduk->status_transaksi}}</h6>
                    <h6 class="card-subtitle mb-2 text-muted">Total Pembayaran : {{$penjualanProduk->total_pembayaran_pembelian}}</h6>
                    <h6 class="card-subtitle mb-2 text-muted">Tanggal Transaksi : {{$penjualanProduk->tgl_transaksi}}</h6>
                </div>
            </div>
            <h1 class="mt-4">Item Transaksi</h1>
            
            <a href="/itemTransaksi/{{$penjualanProduk->id_transaksi}}/create" class="btn my-3" style="background:#565d47; color:white;">Tambah Item Produk</a>
            <table id="table" class="table table-hover" style="width:1225px; background:#ffeadb; border-radius:10px; ">
                <thead>
                    <tr>
                        <th style="text-align:center" scope="col">ID Item</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Total</th>
                        <th style="text-align:center" scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach( $itemTransaksi as $itemTransaksi )
                    <tr>
                        <td style="text-align:center">{{ $itemTransaksi->id_item_transaksi }}</td>
                        @if($itemTransaksi->id_harga_layanan == NULL)
                        <td <?= $itemTransaksi->id_produk ?>> <?= $itemTransaksi->Produk->nama_produk ?> </td>
                        @elseif($itemTransaksi->id_produk == NULL)
                        <td <?= $itemTransaksi->id_harga_layanan ?> <?= $itemTransaksi->HargaLayanan->id_layanan ?>>
                            <?= $itemTransaksi->HargaLayanan->Layanan->nama_layanan ?>
                            <?= $itemTransaksi->HargaLayanan->JenisHewan->nama_jenis ?>
                            <?= $itemTransaksi->HargaLayanan->UkuranHewan->nama_ukuran ?>
                        </td>
                        @endif
                        <td>{{ $itemTransaksi->jumlah_item_transaksi }}</td>
                        <td>{{ $itemTransaksi->harga_item_transaksi }}</td>
                        <td>{{ $itemTransaksi->sub_total_item_transaksi }}</td>
                        <td style="text-align:center">
                            <a href="/itemTransaksi/{{$itemTransaksi->id_item_transaksi}}/edit" class="badge badge-primary">Ubah</a>
                            <form action="/itemTransaksi/{{$itemTransaksi->id_item_transaksi}}" method="post" class="d-inline">
                                @method('delete')
                                @csrf
                                <button type="submit" class="badge badge-danger" data-toggle="modal" data-target="#delete">Hapus</button>
                            </form>
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
                                <form action="/itemTransaksi/{{$itemTransaksi->id_item_transaksi}}" method="post" class="d-inline">
                                    @method('delete')
                                    @csrf
                                    <div class="modal-body">
                                        <p class="text-center">
                                            Apakah Yakin ingin Hapus Item {{$itemTransaksi->id_item_transaksi}} ?
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
    </div>
</div>
@endsection