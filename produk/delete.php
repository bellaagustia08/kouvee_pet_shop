<?php
include_once '../header.php';
// get database connection
include_once '../config/database.php';
 
// instantiate participant object
include_once '../controller/ProdukController.php';
 
 
// get database connection
$database = new Database();
$db = $database->getConnection();
$product = new ProdukController($db);

$product->id_produk = $_POST["id_produk"];

$product->produk_nama_log = $_POST["produk_nama_log"];
 
// delete the product
if($product->delete()){
    $response["value"] = 200;
    $response["message"] = "Delete Produk berhasil";
    echo json_encode($response);
}
 
// if unable to create the product, tell the user
else{
    $response["value"] = 100;
    $response["message"] = "Delete Produk gagal";
    echo json_encode($response);
}
?>