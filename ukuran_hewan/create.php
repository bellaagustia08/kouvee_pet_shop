<?php
include_once '../header.php';
// get database connection
include_once '../config/database.php';
 
// instantiate participant object
include_once '../controller/UkuranHewanController.php';
 
$database = new Database();
$db = $database->getConnection();

$product = new UkuranHewanController($db);
 
// get posted data
$product->nama_ukuran = $_POST['nama_ukuran'];
$product->ukuranHewan_nama_log = $_POST['ukuranHewan_nama_log'];

if($product->create()){
        $response["value"] = 200;
        $response["message"] = "Ukuran Hewan berhasil ditambahkan";
        echo json_encode($response);
    }
     
    // if unable to create the product, tell the user
    else{
        $response["value"] = 100;
        $response["message"] = "Ukuran Hewan gagal ditambahkan";
        echo json_encode($response);
    }
?>