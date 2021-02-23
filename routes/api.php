<?php

use Illuminate\Http\Request;

//web api
//oute::get('/users','UserController@index');
//-- produk
Route::get('/produk','ProdukController@index');
Route::post('/produk/add','ProdukController@store');
Route::patch('/produk/update/{id}','ProdukController@update');
Route::delete('/produk/delete/{id}','ProdukController@destroy');

//--member
Route::get('/member','MemberController@index');
Route::post('/member/add','MemberController@store');
Route::patch('/member/update/{id}','MemberController@update');
Route::delete('/member/delete/{id}','MemberController@destroy');

//--pegawai
Route::get('/pegawai','PegawaiController@index');
Route::post('/pegawai/add','PegawaiController@store');
Route::patch('/pegawai/update/{id}','PegawaiController@update');
Route::delete('/pegawai/delete/{id}','PegawaiController@destroy');

//--supplier
Route::get('/supplier','SupplierController@index');
Route::post('/supplier/add','SupplierController@store');
Route::patch('/supplier/update/{id}','SupplierController@update');
Route::delete('/supplier/delete/{id}','SupplierController@destroy');

//--ukuran hewan
Route::get('/ukuranHewan','UkuranHewanController@index');
Route::post('/ukuranHewan/add','UkuranHewanController@store');
Route::patch('/ukuranHewan/update/{id}','UkuranHewanController@update');
Route::delete('/ukuranHewan/delete/{id}','UkuranHewanController@destroy');

//--layanan
Route::get('/layanan','LayananController@index');
Route::post('/layanan/add','LayananController@store');
Route::patch('/layanan/update/{id}','LayananController@update');
Route::delete('/layanan/delete/{id}','LayananController@destroy');

//-- jenis hewan
Route::get('/jenisHewan','JenisHewanController@index');
Route::post('/jenisHewan/add','JenisHewanController@store');
Route::patch('/jenisHewan/update/{id}','JenisHewanController@update');
Route::delete('/jenisHewan/delete/{id}','JenisHewanController@destroy');


//-- hewan
Route::get('/hewan','HewanController@index');
Route::post('/hewan/add','HewanController@store');
Route::patch('/hewan/update/{id}','HewanController@update');
Route::delete('/hewan/delete/{id}','HewanController@destroy');


//mobile api
Route::get('/produk-mobile','ProdukController@indexMobile');