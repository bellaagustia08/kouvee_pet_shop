<?php
include_once '../header.php';
// get database connection
include_once '../config/database.php';
 
// instantiate participant object
include_once '../controller/SupplierController.php';
 
 
// get database connection
$database = new Database();
$db = $database->getConnection();
$product = new SupplierController($db);

$product->id_supplier = $_POST["id_supplier"];
$product->supplier_nama_log = $_POST["supplier_nama_log"];
 
// delete the product
if($product->delete()){
    $response["value"] = 200;
    $response["message"] = "Delete Supplier berhasil";
    echo json_encode($response);
}
 
// if unable to create the product, tell the user
else{
    $response["value"] = 100;
    $response["message"] = "Delete Supplier gagal";
    echo json_encode($response);
}
?>