<?php
include_once '../header.php';
// get database connection
include_once '../config/database.php';
 
// instantiate participant object
include_once '../controller/UkuranHewanController.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$product = new UkuranHewanController($db);

 
// set ID property of product to be edited
$product->id_ukuran =$_POST["id_ukuran"];

// set product property values
$product->nama_ukuran = $_POST['nama_ukuran'];
$product->ukuranHewan_nama_log = $_POST['ukuranHewan_nama_log'];

    if($product->update()){
        $response["value"] = 200;
        $response["message"] = "Update Data Ukuran Hewan berhasil";
        echo json_encode($response);
    }
     
    // if unable to update the product, tell the user
    else{
        $response["value"] = 100;
        $response["message"] = "Update Data Ukuran Hewan gagal";
        echo json_encode($response);
    }

// update the product

?>