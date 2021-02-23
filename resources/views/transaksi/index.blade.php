@extends('layout.home')

@section('title', 'Data Transaksi')

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
            dom: 'Bfrtip',
            buttons: []
        });
    });
</script>

<div class="container">
    <h1 class="mt-4">DAFTAR DATA TRANSAKSI</h1>
    <!--
    <div class="row">
        <div class="col-6">
            <form action="/searchTransaksi" method="get">
                <div class="input-group">
                    <input type="search" name="search" class="form-control">
                    <span class="input-group-prepend">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </span>
                </div>
            </form>
        </div>
    </div>
-->
    <br></br>
    <table id="table" class="table table-hover" style="width:1225px; background:#ffeadb; border-radius:10px; ">
        <thead>
            <tr>
                <th style="text-align:center" scope="col">ID Transaksi</th>
                <th scope="col">Nama Transaksi</th>
                <th scope="col">Jenis Transaksi</th>
                <th scope="col">Status Transaksi</th>
                <th scope="col">Total Pembayaran Pembelian</th>
                <th style="text-align:center" scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>

            @foreach( $transaksi as $transaksi )
            <tr>
                <td style="text-align:center">{{ $transaksi->id_transaksi }}</td>
                <td>{{ $transaksi->nama_transaksi }}</td>
                <td>{{ $transaksi->jenis_transaksi }}</td>
                <td>{{ $transaksi->status_transaksi }}</td>
                <td>{{ $transaksi->total_pembayaran_pembelian }}</td>
                <td style="text-align:center">
                    <a href="/transaksi/{{$transaksi->id_transaksi}}" class="badge badge-info" style="background:#df7861;">PROSES TRANSAKSI</a>
                    @if($transaksi->total_pembayaran_pembelian == 0)
                    <form action="/transaksi/{{$transaksi->id_transaksi}}" method="post" class="d-inline">
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