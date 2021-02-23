@extends('../layout/home')

@section('title', 'Detail Pemesanan')

@section('container')
<div class="container">
    <div class="row">
        <div class="col-6">
            <div class="panel">
                <br>
                @if($pemesanan-> status_pemesanan == 'BELUM SUKSES' || $pemesanan-> status_pemesanan == 'BELUM KONFIRMASI' )
                <h4><a href="/pemesanan" class="card-link" style="color:whitesmoke"><i class="fa fa-arrow-circle-left"></i>Kembali</a></h4>
                @else
                <h4><a href="/sudahKonfirmasi" class="card-link" style="color:whitesmoke"><i class="fa fa-arrow-circle-left"></i>Kembali</a></h4>
                @endif
                <h1 class="mt-4">Detail Pemesanan</h1>
                <table class="table table-basic">
                    <tr>
                        <td>ID</td>
                        <td>:</td>
                        <td>{{$pemesanan->id_pemesanan}}</td>
                    </tr>
                    <tr>
                        <td>Nama Pemesanan</td>
                        <td>:</td>
                        <td>{{$pemesanan->nama_pemesanan}}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Pemesanan</td>
                        <td>:</td>
                        <td>{{$pemesanan->tgl_pemesanan}}</td>
                    </tr>
                    <tr>
                        <td>Status Pemesanan</td>
                        <td>:</td>
                        <td>{{$pemesanan->status_pemesanan}}</td>
                    </tr>
                    <tr>
                        <td>Supplier</td>
                        <td>:</td>
                        <td>{{$pemesanan->Supplier->nama_supplier}}</td>
                    </tr>
                    <tr>
                        <td>Total Pembayaran Pemesanan</td>
                        <td>:</td>
                        <td>{{$pemesanan->total_pembayaran_pemesanan}}</td>
                    </tr>
                    <tr>
                        <td>Terakhir Diubah oleh</td>
                        <td>:</td>
                        <td>{{$pemesanan->Pegawai->nama_pegawai}}</td>
                    </tr>
                </table>


                <!-- ITEM PEMESANAN -->
                <h4 class="mt-4">Item Pemesanan</h4>

                @if($pemesanan-> status_pemesanan == 'BELUM SUKSES' || $pemesanan-> status_pemesanan == 'BELUM KONFIRMASI' )
                <a href="/pemesanan/{{ $pemesanan->id_pemesanan}}/createProduk" class="btn my-3" style="background:#565d47; color:white;">Tambah Item Pemesanan</a>
                @endif
                
                @if (session('statusProduk'))
                <div class="alert alert-success text-center">
                    <i class="fa fa-check-circle"></i>
                    {{session('statusProduk')}}
                </div>
                @endif
                <table id="table-datatables" class="table table-hover" style="width:1225px; background:#ffeadb; border-radius:10px; ">
                    <thead>
                        <tr>
                            <th style="text-align:center" scope="col">ID Item Pemesanan</th>
                            <th scope="col">Nama Produk</th>
                            <th scope="col">Jumlah Item Pemesanan</th>
                            <th scope="col">Harga Item Pemesanan</th>
                            <th scope="col">Total Harga Item Pemesanan</th>
                            @if($pemesanan-> status_pemesanan == 'BELUM KONFIRMASI')
                            <th style="text-align:center" scope="col">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $itemPemesanan as $itemPemesanan )
                        <tr>
                            <td style="text-align:center">{{ $itemPemesanan->id_item_pemesanan }}</td>
                            <td <?= $itemPemesanan->id_produk ?>> <?= $itemPemesanan->Produk->nama_produk ?> </td>
                            <td>{{ $itemPemesanan->jumlah_item_pemesanan }}</td>
                            <td>{{ $itemPemesanan->harga_item_pemesanan }}</td>
                            <td>{{ $itemPemesanan->sub_total_item_pemesanan }}</td>
                            <td style="text-align:center">
                                @if($pemesanan-> status_pemesanan == 'BELUM KONFIRMASI')
                                <a href="/pemesanan/{{ $pemesanan->id_pemesanan }}/{{ $itemPemesanan->id_item_pemesanan }}/editProduk" class="badge badge-primary">Ubah</a>
                                <form action="/pemesanan/{{ $pemesanan->id_pemesanan}}/{{$itemPemesanan->id_item_pemesanan}}" method="post" class="d-inline">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" class="badge badge-danger" id="delete" onclick="return confirm('Yakin ingin Menghapus Data Tersebut?')">Hapus</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>


                <hr>
                @if($pemesanan-> status_pemesanan == 'BELUM KONFIRMASI')
                <div class="text-left">
                    <form action="/konfirmasi/{{$pemesanan->id_pemesanan}}" method="post" route='Konfirmasi'>
                        @method('patch')
                        @csrf
                        <button class="btn" style="background-color: green; color: white; font-size:18px;" onclick="return confirm('Apakah Anda Yakin ingin Mengonfirmasi Pemesanan  ?')">KONFIRMASI</button>
                    </form>
                </div>
                @endif

                <br>

                @if($pemesanan-> status_pemesanan == 'BELUM KONFIRMASI' || $pemesanan-> status_pemesanan == 'SUKSES')
                <a href="/cetakSurat/{{$pemesanan->id_pemesanan}}" class="btn" style="background-color: darkorange; color:black">
                    <i class="material-icons">print</i>
                    CETAK SURAT PEMESANAN
                </a>
                @endif

                <br><br>

            </div>
        </div>
    </div>
</div>

@endsection