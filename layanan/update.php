<?php
include_once '../header.php';
// get database connection
include_once '../config/database.php';
 
// instantiate participant object
include_once '../controller/LayananController.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$product = new LayananController($db);

 
// set ID property of product to be edited
$product->id_layanan =$_POST["id_layanan"];

// set product property values
$product->nama_layanan = $_POST['nama_layanan'];

$product->layanan_nama_log = $_POST['layanan_nama_log'];

    if($product->update()){
        $response["value"] = 200;
        $response["message"] = "Update Data Layanan berhasil";
        echo json_encode($response);
    }
     
    // if unable to update the product, tell the user
    else{
        $response["value"] = 100;
        $response["message"] = "Update Data Layanan gagal";
        echo json_encode($response);
    }

// update the product

?>