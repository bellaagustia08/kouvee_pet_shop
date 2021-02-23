<?php
include_once '../header.php';
// get database connection
include_once '../config/database.php';
 
// instantiate participant object
include_once '../controller/LayananController.php';
 
 
// get database connection
$database = new Database();
$db = $database->getConnection();
$product = new LayananController($db);

$product->id_layanan = $_POST["id_layanan"];

$product->layanan_nama_log = $_POST["layanan_nama_log"];
 
// delete the product
if($product->delete()){
    $response["value"] = 200;
    $response["message"] = "Delete Layanan berhasil";
    echo json_encode($response);
}
 
// if unable to create the product, tell the user
else{
    $response["value"] = 100;
    $response["message"] = "Delete Layanan gagal";
    echo json_encode($response);
}
?>