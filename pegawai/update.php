<?php
include_once '../header.php';
// get database connection
include_once '../config/database.php';
 
// instantiate participant object
include_once '../controller/PegawaiController.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$product = new PegawaiController($db);

 
// set ID property of product to be edited
$product->id_pegawai =$_POST["id_pegawai"];

// set product property values
$product->nama_pegawai = $_POST['nama_pegawai'];
$product->alamat_pegawai = $_POST['alamat_pegawai'];
$product->tgl_lahir_pegawai = $_POST['tgl_lahir_pegawai'];
$product->no_telp_pegawai = $_POST['no_telp_pegawai'];
$product->jabatan_pegawai = $_POST['jabatan_pegawai'];
$product->password = $_POST['password'];

$product->pegawai_nama_log = $_POST['pegawai_nama_log'];

    if($product->update()){
        $response["value"] = 200;
        $response["message"] = "Update Data Pegawai berhasil";
        echo json_encode($response);
    }
     
    // if unable to update the product, tell the user
    else{
        $response["value"] = 100;
        $response["message"] = "Update Data Pegawai gagal";
        echo json_encode($response);
    }

// update the product

?>