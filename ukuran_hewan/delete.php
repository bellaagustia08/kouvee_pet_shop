<?php
include_once '../header.php';
// get database connection
include_once '../config/database.php';
 
// instantiate participant object
include_once '../controller/UkuranHewanController.php';
 
 
// get database connection
$database = new Database();
$db = $database->getConnection();
$product = new UkuranHewanController($db);

$product->id_ukuran = $_POST["id_ukuran"];
$product->ukuranHewan_nama_log = $_POST["ukuranHewan_nama_log"];
 
// delete the product
if($product->delete()){
    $response["value"] = 200;
    $response["message"] = "Delete Ukuran Hewan berhasil";
    echo json_encode($response);
}
 
// if unable to create the product, tell the user
else{
    $response["value"] = 100;
    $response["message"] = "Delete Ukuran Hewan gagal";
    echo json_encode($response);
}
?>