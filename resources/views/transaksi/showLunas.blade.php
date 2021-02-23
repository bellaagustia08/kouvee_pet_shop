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
    function getInputValue() {
        var bayar = document.getElementById("jumlah_bayar").value;
        var subtotal = document.getElementById("sub_total").value;

        if (bayar < subtotal) {
            confirm("Uang Anda Kurang !");
        } else {
            // Selecting the input element and get its value
            $inputVal = (document.getElementById("jumlah_bayar").value - document.getElementById("diskon").value - document.getElementById("sub_total").value);

            // Displaying the value
            confirm("TOTAL KEMBALIAN : Rp " + $inputVal);
        }

    }

    $(document).ready(function() {
        $('#table').DataTable({
            dom: 'Bfrtip',
            buttons: []
        });
    });
</script>

<div class="container">
    <div class="row">
        <div class="col-6">
            <br>
            <h4><a href="/transaksiLunas" class="card-link" style="color:whitesmoke"><i class="fa fa-arrow-circle-left"></i>Kembali</a></h4>
            <br>
            @if($transaksi->id_hewan == NULL)
            <h6 class="card-subtitle mb-2 text-muted">Pelanggan Kouvee Pet Shop</h6>
            @endif
            @if($transaksi->id_hewan != NULL)
            <h6 class="card-subtitle mb-2 text-muted">Member : {{$transaksi->Hewan->Member->nama_member}} ( {{$hewan->nama_hewan}} - {{$transaksi->Hewan->JenisHewan->nama_jenis}} )</h6>
            @endif

            <br>
            <h6 class="card-subtitle mb-2 text-muted">Customer Service : {{$pegawaics->nama_pegawai}}</h6>
            <h6 class="card-subtitle mb-2 text-muted">Kasir : {{$pegawaikasir->nama_pegawai}}</h6>

            <h2 class="mt-4">Detail Transaksi</h2>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{$transaksi->nama_transaksi}}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Jenis Transaksi : {{$transaksi->jenis_transaksi}}</h6>
                    <h6 class="card-subtitle mb-2 text-muted">Status Transaksi : {{$transaksi->status_transaksi}}</h6>
                    <h6 class="card-subtitle mb-2 text-muted">Total Pembayaran : {{$transaksi->total_pembayaran_pembelian}}</h6>
                </div>
            </div>

            <!--<br>
            <div class="row">
                <div class="col-6">
                    <form action="/searchItemTransaksi" method="get">
                        <div class="input-group">
                            <input type="search" name="search" class="form-control">
                            <span class="input-group-prepend">
                                <button type="submit" class="btn btn-primary">Cari</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>-->

            <h4 class="mt-4">Item Transaksi</h4>
            <table id="table" class="table table-hover" style="width:1225px; background:#ffeadb; border-radius:10px; ">
                <thead>
                    <tr>
                        <th style="text-align:center" scope="col">ID Item</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Total</th>
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
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <br>

            <a href="/cetakStruk/{{$transaksi->id_transaksi}}" class="btn" style="background-color: green; color: white;">
                <i class="material-icons">print</i>
            </a>
            <br>

        </div>
    </div>
</div>

@endsection