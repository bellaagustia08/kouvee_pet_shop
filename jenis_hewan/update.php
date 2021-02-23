<?php
include_once '../header.php';
// get database connection
include_once '../config/database.php';
 
// instantiate participant object
include_once '../controller/JenisHewanController.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$product = new JenisHewanController($db);

 
// set ID property of product to be edited
$product->id_jenis =$_POST["id_jenis"];

// set product property values
$product->nama_jenis = $_POST['nama_jenis'];

$product->jenisHewan_nama_log = $_POST['jenisHewan_nama_log'];

    if($product->update()){
        $response["value"] = 200;
        $response["message"] = "Update Data JenisHewan berhasil";
        echo json_encode($response);
    }
     
    // if unable to update the product, tell the user
    else{
        $response["value"] = 100;
        $response["message"] = "Update Data JenisHewan gagal";
        echo json_encode($response);
    }

// update the product

?>