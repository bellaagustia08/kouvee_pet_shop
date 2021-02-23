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
        $('#table').DataTable({
            //dom: 'Bfrtip',
            //buttons: []
        });
    });
</script>

<div class="container">
    <div class="row">
        <div class="col-6">
        <h4><a href="/transaksiLayanan" class="card-link" style="color:whitesmoke"><i class="fa fa-arrow-circle-left"></i>Kembali</a></h4>
            <h1 class="mt-4">Detail Transaksi</h1>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{$transaksiLayanan->transaksi->nama_transaksi}}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Jenis Transaksi : {{$transaksiLayanan->transaksi->jenis_transaksi}}</h6>
                    <h6 class="card-subtitle mb-2 text-muted">Status Transaksi : {{$transaksiLayanan->transaksi->status_transaksi}}</h6>
                    <h6 class="card-subtitle mb-2 text-muted">Total Pembayaran : {{$transaksiLayanan->transaksi->total_pembayaran_pembelian}}</h6>
                </div>
            </div>
            <h1 class="mt-4">Item Transaksi</h1>
            <table id="table" class="table table-hover" style="width:1225px; background:#ffeadb; border-radius:10px; ">
                <thead>
                    <tr>
                        <th style="text-align:center" scope="col">ID Layanan</th>
                        <th style="text-align:center" scope="col">Nama</th>
                        <th style="text-align:center" scope="col">Jumlah</th>
                        <th style="text-align:center" scope="col">Harga</th>
                        <th style="text-align:center" scope="col">Total</th>
                        <th style="text-align:center" scope="col">Status Layanan</th>
                        <th style="text-align:center" scope="col">Nama Hewan</th>
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
                        <td <?= $itemTransaksi->id_harga_layanan ?> 
                            <?= $itemTransaksi->HargaLayanan->id_layanan ?>>
                            <?= $itemTransaksi->HargaLayanan->Layanan->nama_layanan ?>
                            <?= $itemTransaksi->HargaLayanan->JenisHewan->nama_jenis ?>
                            <?= $itemTransaksi->HargaLayanan->UkuranHewan->nama_ukuran ?>
                        </td>
                        @endif
                        <td>{{ $itemTransaksi->jumlah_item_transaksi }}</td>
                        <td>{{ $itemTransaksi->harga_item_transaksi }}</td>
                        <td>{{ $itemTransaksi->sub_total_item_transaksi }}</td>
                        <td>{{ $itemTransaksi->status_layanan_item_transaksi }}</td>
                        @if($itemTransaksi->Transaksi->id_hewan == NULL)
                            <td style="text-align:center">-</td>
                        @elseif($itemTransaksi->Transaksi->Hewan->nama_hewan != NULL)
                            <td>{{ $itemTransaksi->Transaksi->Hewan->nama_hewan }}</td>
                        @endif
                        <td style="text-align:center">
                            <a href="/itemTransaksi/{{$itemTransaksi->id_item_transaksi}}/edit" class="badge badge-primary">Edit</a>
                        </td>
                    </tr>
                     <!-- MODEL KONFIRMASI -->
                <!-- <div class="modal modal-danger fade" id="konfirmasi" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title text-center" id="myModalLabel">Konfirmasi Penjualan</h4>
                            </div>
                            <form method="POST"
                                action="/KonfirmasiTransaksiLayanan/{{$itemTransaksi->id_item_transaksi}}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('patch')
                                <div class="modal-body">
                                    <p class="text-center">
                                        Apakah Yakin ingin Konfirmasi?
                                    </p>
                                    <input type="hidden" name="status_layanan_item_transaksi"
                                        id="status_layanan_item_transaksi" value="TERKONFIRMASI">

                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Ya, Konfirmasi</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tidak, Kembali</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> -->
                    @endforeach
                </tbody>
            </table>
            <br></br>
        </div>
    </div>
</div>
@endsection