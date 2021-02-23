@extends('layout.home')

@section('title', 'Data Antrian Hewan')

@section('container')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
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

    submitForms = function(){
        document.getElementById("form0").submit();
    }

    submitForms2 = function(){
        document.getElementById("form2").submit();
        return true;
    }
</script>

<div class="container">
    <h1 class="mt-4">DAFTAR ANTRIAN HEWAN</h1>
    <br>
    <table id="table" class="table table-hover" style="width:1225px; background:#ffeadb; border-radius:10px; ">
        <thead>
            <tr>
                <th style="text-align:center" scope="col">ID Transaksi</th>
                <th scope="col">Nama Layanan</th>
                <th scope="col">Nama Member</th>
                <th scope="col">Nama Hewan</th>
                <th scope="col">Status Transaksi</th>
                <th scope="col">Total Pembayaran Pembelian</th>
                <th style="text-align:center" scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach( $itemTransaksi as $itemTransaksi )
            <tr>
                <td style="text-align:center">{{ $itemTransaksi->Transaksi->nama_transaksi }}</td>
                <td>{{ $itemTransaksi->HargaLayanan->Layanan->nama_layanan }}</td>
                @if($itemTransaksi->Transaksi->id_hewan == NULL)
                <td>-</td>
                @elseif($itemTransaksi->Transaksi->Hewan->nama_hewan != NULL)
                <td>{{ $itemTransaksi->Transaksi->Hewan->Member->nama_member }}</td>
                @endif
                @if($itemTransaksi->Transaksi->id_hewan == NULL)
                    <td>-</td>
                    <form id="form0" method="POST"
                        action="/KonfirmasiTransaksiLayanan/{{$itemTransaksi->id_item_transaksi}}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <!-- <button type="submit" class="badge badge-success" data-toggle="modal"
                        data-target="#konfirmasi">Layanan Selesai</button> -->
                    </form>
                @elseif($itemTransaksi->Transaksi->Hewan->nama_hewan != NULL)
                    <td>{{ $itemTransaksi->Transaksi->Hewan->nama_hewan }}</td> 
                    <form id="form1" method="POST"
                        action="/KonfirmasiTransaksiLayanan/{{$itemTransaksi->id_item_transaksi}}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <!-- <button type="submit" class="badge badge-success" data-toggle="modal"
                        data-target="#konfirmasi">Layanan Selesai</button> -->
                    </form>
                    <form id="form2" method="post"
                            action="/kirimSms/{{$itemTransaksi->id_item_transaksi}}"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="namaTransaksi" id="namaTransaksi" value="{{$itemTransaksi->Transaksi->nama_transaksi}}">
                            <input type="hidden" name="mobile" id="mobile" value="{{$itemTransaksi->Transaksi->Hewan->Member->no_telp_member}}">
                            <input type="hidden" name="layanan" id="layanan" value="{{$itemTransaksi->HargaLayanan->Layanan->nama_layanan}}">
                            <input type="hidden" name="jenis" id="jenis" value="{{$itemTransaksi->HargaLayanan->JenisHewan->nama_jenis}}">
                            <input type="hidden" name="ukuran" id="ukuran" value="{{$itemTransaksi->HargaLayanan->UkuranHewan->nama_ukuran}}">
                            <input type="hidden" name="harga" id="harga" value="{{$itemTransaksi->sub_total_item_transaksi}}">
                            <!-- <button type="submit" class="badge badge-success" data-toggle="modal">Kirim SMS</button> -->
                    </form>
                @endif
                <td>{{ $itemTransaksi->Transaksi->status_transaksi }}</td>
                <td>{{ $itemTransaksi->Transaksi->total_pembayaran_pembelian }}</td>
                <td style="text-align:center">
                @if($itemTransaksi->Transaksi->id_hewan == NULL)
                    <button type="button" class="badge badge-success" data-toggle="modal" onclick="submitForms()">Layanan Selesai</button>
                @elseif($itemTransaksi->Transaksi->Hewan->nama_hewan != NULL)
                    <button type="button" class="badge badge-success" data-toggle="modal" onclick="submitForms2()">Layanan Selesai</button>
                @endif
                </td>
            </tr>   
            @endforeach
        </tbody>
    </table>
</div>
@endsection