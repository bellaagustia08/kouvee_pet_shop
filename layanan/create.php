<?php
include_once '../header.php';
// get database connection
include_once '../config/database.php';
 
// instantiate participant object
include_once '../controller/LayananController.php';
 
$database = new Database();
$db = $database->getConnection();

$product = new LayananController($db);
 
// get posted data
$product->nama_layanan = $_POST['nama_layanan'];

$product->layanan_nama_log = $_POST['layanan_nama_log'];

if($product->create()){
        $response["value"] = 200;
        $response["message"] = "Layanan berhasil ditambahkan";
        echo json_encode($response);
    }
     
    // if unable to create the product, tell the user
    else{
        $response["value"] = 100;
        $response["message"] = "Layanan gagal ditambahkan";
        echo json_encode($response);
    }
?>