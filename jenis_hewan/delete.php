<?php
include_once '../header.php';
// get database connection
include_once '../config/database.php';
 
// instantiate participant object
include_once '../controller/JenisHewanController.php';
 
 
// get database connection
$database = new Database();
$db = $database->getConnection();
$product = new JenisHewanController($db);

$product->id_jenis = $_POST["id_jenis"];

$product->jenisHewan_nama_log = $_POST["jenisHewan_nama_log"];
 
// delete the product
if($product->delete()){
    $response["value"] = 200;
    $response["message"] = "Delete JenisHewan berhasil";
    echo json_encode($response);
}
 
// if unable to create the product, tell the user
else{
    $response["value"] = 100;
    $response["message"] = "Delete JenisHewan gagal";
    echo json_encode($response);
}
?>