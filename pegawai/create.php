<?php
include_once '../header.php';
// get database connection
include_once '../config/database.php';
 
// instantiate participant object
include_once '../controller/PegawaiController.php';
 
$database = new Database();
$db = $database->getConnection();

$product = new PegawaiController($db);
 
// get posted data
$product->nama_pegawai = $_POST['nama_pegawai'];
$product->alamat_pegawai = $_POST['alamat_pegawai'];
$product->tgl_lahir_pegawai = $_POST['tgl_lahir_pegawai'];
$product->no_telp_pegawai = $_POST['no_telp_pegawai'];
$product->jabatan_pegawai = $_POST['jabatan_pegawai'];
$product->password = $_POST['password'];

$product->pegawai_nama_log = $_POST['pegawai_nama_log'];

if($product->create()){
        $response["value"] = 200;
        $response["message"] = "Pegawai berhasil ditambahkan";
        echo json_encode($response);
    }
     
    // if unable to create the product, tell the user
    else{
        $response["value"] = 100;
        $response["message"] = "Pegawai gagal ditambahkan";
        echo json_encode($response);
    }
?>