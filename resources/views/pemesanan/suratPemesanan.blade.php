<!DOCTYPE html>
<html>

<head>
    <title>Cetak Surat Pemesanan Kouvee Pet Shop</title>
</head>
<style>
    .tabledetail {
        border-collapse: collapse;
        border: 1px solid;
        padding: 5px;
    }

    .putus {
        border: 2px dashed;
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

<body>
    <table border align="center">
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
                <hr>
            </td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td colspan="3">
                <font size="3">
                    <center><strong>SURAT PEMESANAN</strong></center>
                </font>
            </td>
        </tr>
        <tr>
            <td><br></td>
        </tr>
        <tr>
            <td colspan="3" align="right"><strong>No : {{$pemesanan->nama_pemesanan}}</strong></td>
        </tr>
        <tr>
            <td colspan="2" rowspan="3" class="putus" style="padding-left: 12px;">
                Kepada Yth<br>
                {{$pemesanan->Supplier->nama_supplier}}<br>
                {{$pemesanan->Supplier->no_telp_supplier}}
            </td>
            <td align="right"><strong>Tanggal : {{date(' d F Y', strtotime($pemesanan->tgl_pemesanan))}}</strong></center>
            </td>
        </tr>
        <tr>
            <td><br></td>
        </tr>

        <tr>
            <td><br></td>
        </tr>
        <tr>
            <td colspan="3">
                <font size="2">Mohon untuk disediakan produk-produk berikut ini : </font>
            </td>
        </tr>
        <tr>
            <td><br></td>
        </tr>
        <tr>
            <td colspan="3">
                <table cellspacing="0" width='530px' align="center">
                    <thead align="left">
                        <tr>
                            <th class="tabledetail">No</th>
                            <th class="tabledetail">Nama Produk</th>
                            <th class="tabledetail">Satuan</th>
                            <th class="tabledetail">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i=1 @endphp
                        @foreach( $itemPemesanan as $itemPemesanan)
                        @if($itemPemesanan->id_pemesanan == $pemesanan->id_pemesanan)
                        <tr>
                            <td class="tabledetail">
                                <center>{{ $i++ }}</center>
                            </td>
                            <td class="tabledetail" <?= $itemPemesanan->id_produk ?>>
                                <?= $itemPemesanan->Produk->nama_produk ?>
                            </td>
                            <td class="tabledetail">{{ $itemPemesanan-> satuan_item_pemesanan}}</td>
                            <td class="tabledetail">
                                <center>{{ $itemPemesanan-> jumlah_item_pemesanan}}</center>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td><br></td>
        </tr>
        <tr>
            <td><br></td>
        </tr>
        <tr>
            <td><br></td>
        </tr>
        <tr>
            <td colspan="3">
                <table align="right" width='185px'>
                    <tr>
                        <td>Dicetak Tanggal {{$waktu}}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td><br></td>
        </tr>
    </table>
</body>