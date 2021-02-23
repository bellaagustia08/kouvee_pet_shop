<!DOCTYPE html>
<html>

<head>
    <title>Cetak Struk Kouvee Pet Shop</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <style type="text/css">
        table tr td,
        table tr th {
            font-size: 9pt;
        }
    </style>

    <br>
    <center>
        <br>
        <h5>Cetak Struk Kouvee Pet Shop</h4><br>
    </center>
    <table class='table table-bordered'>

        <thead>
            <tr>
                <th>No</th>
                <th>Nama Transaksi</th>
                <th>Tanggal Transaksi</th>
                <th>Jenis Transaksi</th>
                <!-- <th>Image</th> -->
            </tr>
        </thead>
        <tbody>
            @php $i=1 @endphp
            @foreach($transaksi as $transaksi)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{$transaksi->nama_transaksi}}</td>
                <td>{{$transaksi->tgl_transaksi}}</td>
                <td>{{$transaksi->jenis_transaksi}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>