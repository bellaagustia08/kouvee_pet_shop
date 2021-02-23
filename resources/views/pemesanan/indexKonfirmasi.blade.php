@extends('layout.home')

@section('title', 'Data Pemesanan')

@section('container')
<div class="container">
    <h1 class="mt-4" style="color: white">DAFTAR DATA PENGADAAN SUDAH TERKONFIRMASI</h1>
    <!--<div class="row">
        <div class="col-6">
            <form action="/searchPemesanan" method="get">
                <div class="input-group">
                    <input type="search" name="search" class="form-control">
                    <span class="input-group-prepend">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </span>
                </div>
            </form>
        </div>
    </div>-->

    <h6><a href="/sudahKonfirmasi" class="btn"><i class="material-icons" style="color: whitesmoke">refresh</i>Refresh</a></h6>


    <table class="table table-hover" id="table-datatables" style="width:1225px; background-color:#c1a57b; border-radius:10px; ">
        <thead>
            <tr>
                <th style="text-align:center" scope="col">ID</th>
                <th style="text-align:center" scope="col">Kode</th>
                <th style="text-align:center" scope="col">Nama Supplier</th>
                <th style="text-align:center" scope="col">Tanggal</th>
                <th style="text-align:center" scope="col">Status</th>
                <th style="text-align:center" scope="col">Total Pembayaran</th>
                <th style="text-align:center" scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach( $pemesanan as $pemesanan )
            <tr>
                <td style="text-align:center">{{ $pemesanan->id_pemesanan }}</td>
                <td style="text-align:center">{{ $pemesanan->nama_pemesanan }}</td>
                <td>{{ $pemesanan->Supplier->nama_supplier }}</td>
                <td style="text-align:center">{{ $pemesanan->tgl_pemesanan }}</td>
                <td style="text-align:center">{{ $pemesanan->status_pemesanan }}</td>
                <td style="text-align:center">{{ $pemesanan->total_pembayaran_pemesanan }}</td>
                <td style="text-align:center">
                    <a href="/pemesanan/{{$pemesanan->id_pemesanan}}" class="badge badge-info" style="background:#565d47;">Detail</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection