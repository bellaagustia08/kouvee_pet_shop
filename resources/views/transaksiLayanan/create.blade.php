@extends('layout.home')

@section('title', 'Form Tambah Transaksi Layanan')

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
            <h4><a href="/transaksiLayanan" class="card-link">Kembali</a></h4>
            <h1 class="mt-4">Form Tambah Transaksi Layanan</h1>

            <form method="POST" action="/transaksiLayanan">
                @csrf
                <div class="form-group">
                    <label for="id_harga_layanan">Layanan </label><br>
                    <select name="id_harga_layanan" id="id_harga_layanan" class="btn btn-sm dropdown-toggle" style="background:#f5cab3; width:350px">
                        @foreach($hargaLayanan as $hargaLayanan)
                            <option value="<?= $hargaLayanan->id_harga_layanan ?>"><?= $hargaLayanan->Layanan->nama_layanan ?> <?= $hargaLayanan->JenisHewan->nama_jenis ?> <?= $hargaLayanan->UkuranHewan->nama_ukuran ?></option>
                        @endforeach
                    </select>
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

                <!-- <div id="nonMember">
                    <input type="hidden" name="id_hewan" id="id_hewan" class="kosong" value=NULL>
                </div> -->

                <button class="btn btn-primary" type="submit">Tambah Transaksi Layanan</button>
            </form>
        </div>
    </div>
</div>
@endsection