<?php
include_once '../header.php';
// get database connection
include_once '../config/database.php';
 
// instantiate participant object
include_once '../controller/HewanController.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$product = new HewanController($db);

 
// set ID property of product to be edited
$product->id_hewan =$_POST["id_hewan"];

// set product property values
$product->nama_hewan = $_POST['nama_hewan'];
$product->tgl_lahir_hewan = $_POST['tgl_lahir_hewan'];
$product->id_jenis = $_POST['id_jenis'];
$product->id_ukuran = $_POST['id_ukuran'];
$product->id_member = $_POST['id_member'];

$product->hewan_nama_log = $_POST['hewan_nama_log'];

    if($product->update()){
        $response["value"] = 200;
        $response["message"] = "Update Data Hewan berhasil";
        echo json_encode($response);
    }
     
    // if unable to update the product, tell the user
    else{
        $response["value"] = 100;
        $response["message"] = "Update Data Hewan gagal";
        echo json_encode($response);
    }

// update the product

?>