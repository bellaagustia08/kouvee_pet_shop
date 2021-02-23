<?php
include_once '../header.php';
// get database connection
include_once '../config/database.php';
 
// instantiate participant object
include_once '../controller/SupplierController.php';
 
$database = new Database();
$db = $database->getConnection();

$product = new SupplierController($db);
 
// get posted data
$product->nama_supplier = $_POST['nama_supplier'];
$product->alamat_supplier = $_POST['alamat_supplier'];
$product->no_telp_supplier = $_POST['no_telp_supplier'];
$product->supplier_nama_log = $_POST['supplier_nama_log'];

if($product->create()){
        $response["value"] = 200;
        $response["message"] = "Supplier berhasil ditambahkan";
        echo json_encode($response);
    }
     
    // if unable to create the product, tell the user
    else{
        $response["value"] = 100;
        $response["message"] = "Supplier gagal ditambahkan";
        echo json_encode($response);
    }
?>