@extends('layout.home')

@section('title', 'Data Pemesanan')

@section('container')
<div class="container">
    <h1 class="mt-4" style="color: white">DATA PRODUK TERLARIS</h1>
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
    <a href="/produkTerlaris" class="btn"><i class="material-icons" style="color: whitesmoke">refresh</i></a>
    <form action="/produkTerlaris" method="get">
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

            <button type="submit" class="btn btn-primary">Cari</button>
            <br>
            @if($tahun!=NULL)
            <a href="/produkTerlaris/produk_pdf/{{$tahun->thn}}" class="btn" style="background-color: green; color: white;">
                <i class="material-icons" onclick="myFunction()">print</i>
            </a>
            @endif
        </div>
    </form>

    @if($tahun!=NULL)
    <h6 class="mt-4" style="color: white">DATA PRODUK TAHUN {{$tahun->thn}}</h6>
    @elseif($tahun==NULL)
    <h6 class="mt-4" style="color: white">DATA PRODUK TAHUN TERSEBUT KOSONG</h6>
    @endif
    <table class="table table-hover" style="width:1000px; background-color:white; border-radius:10px; ">
        <thead>
            <tr>
                <th style="text-align:center" scope="col">Bulan</th>
                <th style="text-align:center" scope="col">ID Produk</th>
                <th style="text-align:center" scope="col">Nama Produk</th>
                <th style="text-align:center" scope="col">Jumlah Produk Terjual @pcs</th>
            </tr>
        </thead>
        <tbody>

            <tr>
                @php($i=0)
                @foreach( $transaksi as $transaksi)
                <td style="text-align:center">{{$bulan[$i]}}</td>
                @php($i++)
                @if($transaksi == NULL)
                <td style="text-align:center">-</td>
                <td style="text-align:center">-</td>
                <td style="text-align:center">-</td>
                @elseif($transaksi != NULL)
                <td style="text-align:center">{{ $transaksi->id_produk }}</td>
                <td>{{ $transaksi->nama_produk }}</td>
                <td style="text-align:center">{{ $transaksi->count }}</td>
                @endif

            </tr>
            @endforeach

        </tbody>
    </table>
</div>

<script>

</script>

@endsection