<!DOCTYPE html>
<html>

<head>
    <title>Cetak Laporan Produk Terlaris Kouvee Pet Shop</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <style>
          .tabledetail {
        border-collapse: collapse;
        border: 1px solid;
        padding: 5px;
    }

    body {
        border-collapse: collapse;
        border: 2px solid;
        font-family: arial, sans-serif;
        font-size: 12px;
        width: 700px;
        margin: 0 auto;
    }
    </style>

</head>

<body>
    <table class='table table-bordered' style="border: 1px solid black; border-collapse: collapse;">
        <tr>
            <td><br></td>
        </tr>
        <tr>
            <td colspan="2" align="center"><img src="{{ public_path("images/Logo.png") }}" width="200px"></td>
            <td>
                <center>
                    <font size="5">KOUVEE PET SHOP</font><br>
                    <font size="3"> Jl. Moses Gatotkaca No. 22 Yogyakarta 55281</font><br>
                    <font size="3">Telp. (0274) 357735 </font><br>
                    <font size="3">http://www.sayanghewan.com</font>
                </center>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <font size="6">
                    <center><strong>LAPORAN PRODUK TERLARIS</strong></center>
                </font>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <font size="2">Tahun: {{$tahun->thn}}</font>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <table class='table table-bordered' style="border: 1px solid black; border-collapse: collapse;" cellspacing="0" width='610px' align="center">
                    <thead align="left">
                        <tr>
                            <th class="tabledetail">No</th>
                            <th class="tabledetail">Bulan</th>
                            <th class="tabledetail">Nama Produk</th>
                            <th class="tabledetail">Jumlah Penjualan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $now = date("d M Y") @endphp
                        @php $i=1 @endphp
                        @foreach($transaksi as $t)
                        <tr>
                            <td class="tabledetail">
                                <center>{{$i}}</center>
                            </td>
                            <td class="tabledetail">{{$bulan[$i]}}</td>
                            @php($i++)
                            @if($t == NULL)
                                <td class="tabledetail">-</td>
                                <td class="tabledetail">
                                    <center>-</center>
                                </td>
                            @elseif($t != NULL)
                                <td class="tabledetail">{{$t->nama_produk}}</td>
                                <td class="tabledetail">
                                    <center>{{$t->count}}</center>
                                </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="3" align="right">
                <font size="2">Dicetak pada {{$now}}</font>
            </td>
        </tr>
    </table>
</body>

</html>