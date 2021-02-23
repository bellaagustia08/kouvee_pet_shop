@extends('layout.home')

@section('title', 'Form Tambah Penjualan Produk')

@section('container')
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript">
        $(function () {
            $("input[name='member']").click(function () {
                if ($("#memberYes").is(":checked")) {
                    $("#hewan *").show();
                    $("#hewan *").attr('disabled',false);
                    $("#nonMember *").attr('disabled',true);
                    $(".kosong *").attr('disabled',true);
                } else if ($("#memberNo").is(":checked")) {
                    $("#hewan *").hide();
                    $("#hewan *").attr('disabled',true);
                    $("#nonMember *").attr('disabled',false);
                    $(".kosong *").attr('disabled',false);
                    
                }
            });
        });
</script>

<div class="container">
    <div class="row">
        <div class="col-6">
            <h4><a href="/penjualanProduk" class="card-link">Kembali</a></h4>
            <h1 class="mt-4">Form Tambah Penjualan Produk</h1>

            <form method="POST" action="/penjualanProduk">
                @csrf
                <div class="form-group">
                    <label for="id_produk">Nama Produk</label><br>
                    <select name="id_produk" id="id_produk" class="btn btn-sm dropdown-toggle" style="background:#f5cab3; width:350px">
                        @foreach($produk as $produk)
                            <option value="<?= $produk->id_produk ?>"><?= $produk->nama_produk ?> | <?= $produk->jumlah_stok_produk ?> pcs</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="jumlah_item_transaksi">Jumlah Item</label>
                    <input type="number" class="form-control @error('jumlah_item_transaksi') is-invalid @enderror" id="jumlah_item_transaksi" placeholder="pcs" name="jumlah_item_transaksi" value="{{ old('jumlah_item_transaksi') }}" style="width:100px">
                    <div class="invalid-feedback">
                        Jumlah item tidak boleh kosong.
                    </div>
                </div>
                <div class="form-group">
                    <label for="member">Apakah Anda Member ? </label><br>
                    <input type="radio" Name="member" id="memberYes" name="member" value="Yes" checked="Yes">Ya
                    <input type="radio" Name="member" id="memberNo" name="member" value="No">Tidak
                </div>

                <div id="hewan" class="form-group">
                    <label for="id_hewan">Hewan</label><br>
                    <select name="id_hewan" id="id_hewan" class="btn btn-sm dropdown-toggle" style="background:#f5cab3; width:350px">
                        @foreach($hewan as $hewan)
                            <option value="<?= $hewan->id_hewan ?>"><?= $hewan->nama_hewan ?></option>
                        @endforeach
                    </select>
                </div>
                <button class="btn btn-primary" type="submit">Tambah Penjualan Produk</button>
            </form>
        </div>
    </div>
</div>
@endsection