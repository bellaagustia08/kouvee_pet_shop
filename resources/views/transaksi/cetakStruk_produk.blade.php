<!DOCTYPE html>
<html>

<head>
    <title>Cetak Struk Kouvee Pet Shop</title>
</head>
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

<body>
    <table align="center">
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
                    <center><strong>NOTA LUNAS</strong></center>
                </font>
            </td>
        </tr>
        <tr>
            <td><br></td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td align="right">{{$waktu}}</center>
            </td>
        </tr>
        <tr>
            <td>{{$transaksi->nama_transaksi}}</td>
        </tr>
        <tr>
            <td><br></td>
        </tr>
        <tr>
            @if($transaksi->id_hewan != NULL)
            <td>Member : {{$transaksi->Hewan->Member->nama_member}} ( {{$hewan->nama_hewan}} - {{$transaksi->Hewan->JenisHewan->nama_jenis}} )</td>
            @else
            <td>Pelanggan Kouvee Pet Shop</td>
            @endif

            <td align="right" colspan="2">CS : {{$pegawaics->nama_pegawai}}</td>
        </tr>
        <tr>
            @if($transaksi->id_hewan != NULL)
            <td>Telepon : {{$transaksi->Hewan->Member->no_telp_member}}</td>
            @else
            <td style="text-align: left">Telepon : 0815568789</td>
            @endif
            <td align="right" colspan="2">Kasir : {{Session::get('nama_pegawai')}}</td>
        </tr>
        <tr>
            <td><br></td>
        </tr>
        <tr>
            <td colspan="3">
                <hr>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <font size="3">
                    <center><strong>Produk</strong></center>
                </font>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <hr>
            </td>
        </tr>
        <tr>
            <td><br></td>
        </tr>
        <tr>
            <td colspan="3">
                <table cellspacing="0" width='610px' align="center">
                    <thead align="left">
                        <tr>
                            <th class="tabledetail">No</th>
                            <th class="tabledetail">Nama Produk</th>
                            <th class="tabledetail">Harga</th>
                            <th class="tabledetail">Jumlah</th>
                            <th class="tabledetail">Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $i=1
                        @endphp
                        @foreach( $itemTransaksi as $itemTransaksi)
                        <tr>
                            <td class="tabledetail">
                                <center>{{ $i++ }}</center>
                            </td>
                            <td class="tabledetail" <?= $itemTransaksi->id_produk ?>>
                                <?= $itemTransaksi->Produk->nama_produk ?>
                            </td>
                            <td class="tabledetail">Rp. {{$itemTransaksi->harga_item_transaksi}},-</td>
                            <td class="tabledetail">
                                <center>{{$itemTransaksi->jumlah_item_transaksi }}</center>
                            </td>
                            <td class="tabledetail">Rp. {{$itemTransaksi->sub_total_item_transaksi}},-</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td><br></td>
        </tr>
        <tr>
            <td colspan="3">
                <hr>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <table align="right" width='185px'>

                    @php
                    $subtotal = $transaksi->total_pembayaran_pembelian + $transaksi->diskon
                    @endphp

                    <tr>
                        <td>Sub Total</td>
                        <td>Rp. {{$subtotal}}, - </td>
                    </tr>
                    <tr>
                        <td>Diskon</td>
                        <td>Rp. {{$transaksi->diskon}}, - </td>
                    </tr>
                    <tr>
                        <td><strong>Total</strong></td>
                        <td>Rp. {{$transaksi->total_pembayaran_pembelian}}, - </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td><br></td>
        </tr>
    </table>
</body>