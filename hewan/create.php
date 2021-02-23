<?php
include_once '../header.php';
// get database connection
include_once '../config/database.php';
 
// instantiate participant object
include_once '../controller/HewanController.php';
 
$database = new Database();
$db = $database->getConnection();

$product = new HewanController($db);
 
// get posted data
$product->nama_hewan = $_POST['nama_hewan'];
$product->tgl_lahir_hewan = $_POST['tgl_lahir_hewan'];
$product->id_jenis = $_POST['id_jenis'];
$product->id_ukuran = $_POST['id_ukuran'];
$product->id_member = $_POST['id_member'];

$product->hewan_nama_log = $_POST['hewan_nama_log'];

if($product->create()){
        $response["value"] = 200;
        $response["message"] = "Hewan berhasil ditambahkan";
        echo json_encode($response);
    }
     
    // if unable to create the product, tell the user
    else{
        $response["value"] = 100;
        $response["message"] = "Hewan gagal ditambahkan";
        echo json_encode($response);
    }
?>