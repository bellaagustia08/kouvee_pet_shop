<?php
include_once '../header.php';
// get database connection
include_once '../config/database.php';
 
// instantiate participant object
include_once '../controller/SupplierController.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$product = new SupplierController($db);

 
// set ID property of product to be edited
$product->id_supplier =$_POST["id_supplier"];

// set product property values
$product->nama_supplier = $_POST['nama_supplier'];
$product->alamat_supplier = $_POST['alamat_supplier'];
$product->no_telp_supplier = $_POST['no_telp_supplier'];
$product->supplier_nama_log = $_POST['supplier_nama_log'];

    if($product->update()){
        $response["value"] = 200;
        $response["message"] = "Update Data Supplier berhasil";
        echo json_encode($response);
    }
     
    // if unable to update the product, tell the user
    else{
        $response["value"] = 100;
        $response["message"] = "Update Data Supplier gagal";
        echo json_encode($response);
    }

// update the product

?>