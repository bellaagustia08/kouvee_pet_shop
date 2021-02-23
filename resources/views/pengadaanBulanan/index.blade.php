@extends('layout.home')

@section('title', 'Data Pengadaan Bulanan')

@section('container')
<div class="container">
    <h1 class="mt-4" style="color: white">DATA PENGADAAN BULANAN</h1>
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
    <a href="/pengadaanBulanan" class="btn"><i class="material-icons" style="color: whitesmoke">refresh</i></a>
    <form action="/pengadaanBulanan" method="get">
        <div class="form-group">
            <!-- <label for="tahun" style="color: whitesmoke">Tahun</label><br> -->
            <select name="tahun" id="tahun" class="btn btn-sm dropdown-toggle" style="background:#565d47; color:white;" value="{{ old('tahun') }}">
                <option value="none" selected disabled hidden>TAHUN TRANSAKSI</option>
                <option value="2020">2020</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
                <option value="2026">2026</option>
            </select>
            <select name="bulan" id="bulan" class="btn btn-sm dropdown-toggle" style="background:#565d47; color:white;" value="{{ old('bulan') }}">
                <option value="none" selected disabled hidden>BULAN TRANSAKSI</option>
                <option value="1">JANUARI</option>
                <option value="2">FEBRUARI</option>
                <option value="3">MARET</option>
                <option value="4">APRIL</option>
                <option value="5">MEI</option>
                <option value="6">JUNI</option>
                <option value="7">JULI</option>
                <option value="8">AGUSTUS</option>
                <option value="9">SEPTEMBER</option>
                <option value="10">OKTOBER</option>
                <option value="11">NOVEMBER</option>
                <option value="12">DESEMBER</option>
            </select>

            <button type="submit" class="btn btn-primary">Cari</button>
            </br>
            @if($tahun!=NULL && $bulan!=NULL)
            <a href="/pengadaanBulanan/pengadaan_bulanan_pdf/{{$tahun->thn}}/{{$bulan1}}" class="btn" style="background-color: green; color: white;">
                <i class="material-icons" onclick="myFunction()">print</i>
            </a>
            @endif
        </div>
    </form>

    @if($tahun!=NULL && $bulan!=NULL)
    <h6 class="mt-4" style="color: white">Data Pengadaan Bulan {{$bulan->bln}} Tahun {{$tahun->thn}}</h6>
    @elseif($tahun==NULL && $bulan==NULL)
    <h6 class="mt-4" style="color: white">DATA PENGADAAN TAHUN TERSEBUT KOSONG</h6>
    @endif

    <table class="table table-hover" style="width:1000px; background-color:white; border-radius:10px; ">
        <thead>
            <tr>
                <th style="text-align:center" scope="col">No</th>
                <th style="text-align:center" scope="col">Nama Produk</th>
                <th style="text-align:center" scope="col">Jumlah Pengeluaran</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                @php($i=1)
                @foreach( $pengadaanBulan as $pb )
                <td style="text-align:center">{{$i}}</td>
                @php($i++)
                @if($pb == NULL)
                <td style="text-align:center">-</td>
                <td style="text-align:center">-</td>
                @elseif($pb != NULL)
                <td style="text-align:center">{{ $pb->nama_produk }}</td>
                <td style="text-align:center">Rp. {{ $pb->total }}</td>
                @endif
            </tr>
            @endforeach
            <tr>
                <td style="text-align:center"> </td>
                <td style="text-align:center"> </td>
                <th colspan="3" style="text-align:center">Rp. {{ $subtotalsebulan->subtotal }}</th>
            </tr>
        </tbody>
    </table>
</div>
@endsection