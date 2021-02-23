<!DOCTYPE html>
<html>

<head>
    <title>Cetak Laporan Pendapatan Tahunan Kouvee Pet Shop</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <style>
          .tabledetail {
        border-collapse: collapse;
        border: 1px solid;
        padding: 1px;
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
                    <center><strong>LAPORAN PENDAPATAN TAHUNAN</strong></center>
                </font><br>
                <left>
                    <font size="2">Tahun: {{$tahun->thn}}</font><br>
                </left>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <table class='table table-bordered' style="border: 1px solid black; border-collapse: collapse;" cellspacing="0" width='250px' align="center">
                    <thead align="left">
                        <tr>
                            <th class="tabledetail">No</th>
                            <th class="tabledetail">Bulan</th>
                            <th class="tabledetail">Jasa Layanan</th>
                            <th class="tabledetail">Produk</th>
                            <th class="tabledetail">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $now = date("d M Y") @endphp
                        @php $i=1 @endphp
                        @foreach($pendapatanTahunan as $pt)
                        <tr>
                            <td class="tabledetail">
                                <center>{{$i}}</center>
                            </td>
                            <td class="tabledetail">{{$bulan[$i]}}</td>
                            @php $i++ @endphp
                            @if($pt == NULL)
                                <td class="tabledetail">-</td>
                                <td class="tabledetail">
                                    <center>-</center>
                                </td>
                                <td class="tabledetail">-</td>
                            @elseif($pt != NULL)
                                <td class="tabledetail">Rp. {{$pt->total_layanan}}</td>
                                <td class="tabledetail">Rp. {{$pt->total_produk}}</td>
                                <td class="tabledetail">
                                    <center>Rp. {{$pt->total}}</center>
                                </td>
                            @endif
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="5" align="right">
                                <font size="2">Total Rp. {{$subtotalsetahun->subtotal}}</font>
                            </td>
                        </tr>
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