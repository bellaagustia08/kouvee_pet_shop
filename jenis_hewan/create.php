<?php
include_once '../header.php';
// get database connection
include_once '../config/database.php';
 
// instantiate participant object
include_once '../controller/JenisHewanController.php';
 
$database = new Database();
$db = $database->getConnection();

$product = new JenisHewanController($db);
 
// get posted data
$product->nama_jenis = $_POST['nama_jenis'];

$product->jenisHewan_nama_log = $_POST['jenisHewan_nama_log'];

if($product->create()){
        $response["value"] = 200;
        $response["message"] = "JenisHewan berhasil ditambahkan";
        echo json_encode($response);
    }
     
    // if unable to create the product, tell the user
    else{
        $response["value"] = 100;
        $response["message"] = "JenisHewan gagal ditambahkan";
        echo json_encode($response);
    }
?>