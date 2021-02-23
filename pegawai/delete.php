<?php
include_once '../header.php';
// get database connection
include_once '../config/database.php';
 
// instantiate participant object
include_once '../controller/PegawaiController.php';
 
 
// get database connection
$database = new Database();
$db = $database->getConnection();
$product = new PegawaiController($db);

$product->id_pegawai = $_POST["id_pegawai"];
$product->pegawai_nama_log = $_POST["pegawai_nama_log"];
 
// delete the product
if($product->delete()){
    $response["value"] = 200;
    $response["message"] = "Delete Pegawai berhasil";
    echo json_encode($response);
}
 
// if unable to create the product, tell the user
else{
    $response["value"] = 100;
    $response["message"] = "Delete Pegawai gagal";
    echo json_encode($response);
}
?>