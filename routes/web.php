<?php

use Illuminate\Support\Facades\Route;
/*Route::any('/{any}', function () {
    return view('welcome');
})->where('any', '.*');

Route::any('{page}', function(){return view('welcome');});

Route::get('/admin/{page}', function(){ return view('welcome');});
Route::get('/karyawan/{page}', function(){ return view('welcome');});

Auth::routes();



Route::get('/home', 'HomeController@index')->name('home');*/


Route::get('/', 'LoginController@index');
Route::post('/login', 'LoginController@login');
Route::get('/logout', 'LoginController@logout');
Route::get('/home', 'HomeController@index');
Route::get('/index/cetak_pdf', 'TransaksiController@cetak_pdf');

//Produk
/*Route::get('/produk','ProduksController@index');
Route::get('/produk/create','ProduksController@create');
Route::get('/produk/{produk}','ProduksController@show');
Route::post('/produk','ProduksController@store');
Route::delete('/produk/{produk}','ProduksController@destroy');
Route::get('/produk/{produk}/edit','ProduksController@edit');
Route::patch('/produk/{produk}','ProduksController@update');*/
Route::resource('produk', 'ProdukController');
Route::get('/searchProduk', 'ProdukController@search');
Route::get('/produk/sortHarga', 'ProdukController@sortHarga');
Route::get('/produkMinim', 'ProdukController@produkMinim');


//Layanan
Route::resource('layanan', 'LayananController');
Route::get('/searchLayanan', 'LayananController@search');


//Pegawai
Route::resource('pegawai', 'PegawaiController');
Route::get('/searchPegawai', 'PegawaiController@search');


//Supplier
Route::resource('supplier', 'SupplierController');
Route::get('/searchSupplier', 'SupplierController@search');


//Member
Route::resource('member', 'MemberController');
Route::get('/searchMember', 'MemberController@search');


//Hewan
Route::resource('hewan', 'HewanController');
Route::get('/searchHewan', 'HewanController@search');


//Jenis Hewan
Route::resource('jenisHewan', 'JenisHewanController');
Route::get('/searchJenisHewan', 'JenisHewanController@search');


//Ukuran Hewan
Route::resource('ukuranHewan', 'UkuranHewanController');
Route::get('/searchUkuranHewan', 'UkuranHewanController@search');

//Harga Layanan
Route::resource('hargaLayanan', 'HargaLayananController');
Route::get('/searchHargaLayanan', 'HargaLayananController@search');

//Penjualan Produk
Route::resource('penjualanProduk', 'PenjualanProdukController');
Route::get('/searchPenjualanProduk', 'PenjualanProdukController@search');
Route::patch('/KonfirmasiPenjualanProduk/{penjualanProduk}', 'PenjualanProdukController@konfirmasi');

//Transaksi Layanan
Route::resource('transaksiLayanan', 'TransaksiLayananController');
Route::get('/searchTransaksiLayanan', 'TransaksiLayananController@search');
Route::patch('/KonfirmasiTransaksiLayanan/{itemTransaksi}', 'TransaksiLayananController@konfirmasi');


//Transaksi
Route::resource('transaksi', 'TransaksiController');
Route::get('/transaksi', 'TransaksiController@index');
Route::get('/transaksi/create', 'TransaksiController@create');
Route::get('/transaksi/{transaksi}', 'TransaksiController@show')->name('ShowDetailTransaksi');
Route::post('/transaksi', 'TransaksiController@store');
Route::delete('/transaksi/{transaksi}', 'TransaksiController@destroy');
Route::get('/transaksi/{transaksi}/edit', 'TransaksiController@edit');
Route::patch('/transaksi/{transaksi}', 'TransaksiController@update');
Route::get('/searchTransaksi', 'TransaksiController@search');
Route::patch('/bayar', 'TransaksiController@bayar');
Route::get('/transaksiLunas', 'TransaksiController@indexLunas');
Route::get('/transaksi/{transaksi}/showLunas', 'TransaksiController@showLunas');
Route::get('/cetakStruk/{transaksi}', 'TransaksiController@cetakStruk');


//Item Transaksi
Route::resource('itemTransaksi', 'ItemTransaksiController');
Route::get('/itemTransaksi/{penjualanProduk}/create', 'ItemTransaksiController@create');
Route::get('/searchItemTransaksi', 'ItemTransaksiController@search');
Route::post('/kirimSms/{itemTransaksi}', 'ItemTransaksiController@sendSms');

//Antrian Hewan
Route::resource('antrianHewan', 'AntrianHewanController');

//Hewan Selesai
Route::resource('hewanSelesai', 'HewanSelesaiController');

//Pemesanan
Route::resource('pemesanan', 'PemesananController');
Route::get('/pemesanan', 'PemesananController@index');
Route::get('/sudahKonfirmasi', 'PemesananController@indexKonfirmasi');
Route::get('/pemesanan/create', 'PemesananController@create');
Route::post('/pemesanan', 'PemesananController@store');
Route::get('/pemesanan/{pemesanan}', 'PemesananController@show')->name('ShowDetailPemesanan');
Route::delete('/pemesanan/{pemesanan}', 'PemesananController@destroy');
Route::get('/pemesanan/{pemesanan}/edit', 'PemesananController@edit');
Route::patch('/pemesanan/{pemesanan}', 'PemesananController@update')->name('Edit');
Route::get('/search_pemesanan', 'PemesananController@search');
Route::get('/cetakSurat/{pemesanan}', 'PemesananController@cetakSurat');


//Item Pemesanan
Route::get('/pemesanan/{pemesanan}/createProduk', 'PemesananController@createProduk');
Route::post('/pemesanan/{pemesanan}', 'PemesananController@storeProduk');
Route::get('/pemesanan/{pemesanan}/{itemPemesanan}/editProduk', 'PemesananController@editProduk');
Route::patch('/pemesanan/{pemesanan}/{itemPemesanan}', 'PemesananController@updateProduk');
Route::delete('/pemesanan/{pemesanan}/{itemPemesanan}', 'PemesananController@destroyProduk');
Route::patch('/konfirmasi/{pemesanan}', 'PemesananController@konfirmasi')->name('Konfirmasi');

//produk terlaris 
Route::get('/produkTerlaris', 'LaporanController@produkTerlaris');
Route::get('/produkTerlaris/produk_pdf/{year}','LaporanController@cetakLaporanProduk');

//produk terlaris 
Route::get('/layananTerlaris', 'LaporanController@layananTerlaris');
Route::get('/layananTerlaris/layanan_pdf/{year}','LaporanController@cetakLaporanLayanan');

//pendapatan tahunan 
Route::get('/pendapatanTahunan', 'LaporanController@pendapatanTahunan');
Route::get('/pendapatanTahunan/tahunan_pdf/{year}','LaporanController@cetakLaporanTahunan');

//pendapatan bulanan 
Route::get('/pendapatanBulanan', 'LaporanController@pendapatanBulanan');
Route::get('/pendapatanBulanan/bulanan_pdf/{year}/{month}','LaporanController@cetakLaporanBulanan');

//pengadaan  bulanan 
Route::get('/pengadaanBulanan', 'LaporanController@pengadaanBulanan');
Route::get('/pengadaanBulanan/pengadaan_bulanan_pdf/{year}/{month}','LaporanController@cetakPengadaanBulanan');

//pengadaan  tahunan 
Route::get('/pengadaanTahunan', 'LaporanController@pengadaanTahunan');
Route::get('/pengadaanTahunan/pengadaan_tahunan_pdf/{year}','LaporanController@cetakPengadaanTahunan');

//SMS
// Route::get('/nomor', function() {
//     return view('transaksiLayanan.index');
// });
