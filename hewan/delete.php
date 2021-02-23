<?php
include_once '../header.php';
// get database connection
include_once '../config/database.php';
 
// instantiate participant object
include_once '../controller/HewanController.php';
 
 
// get database connection
$database = new Database();
$db = $database->getConnection();
$product = new HewanController($db);

$product->id_hewan = $_POST["id_hewan"];

$product->hewan_nama_log = $_POST["hewan_nama_log"];
 
// delete the product
if($product->delete()){
    $response["value"] = 200;
    $response["message"] = "Delete Hewan berhasil";
    echo json_encode($response);
}
 
// if unable to create the product, tell the user
else{
    $response["value"] = 100;
    $response["message"] = "Delete Hewan gagal";
    echo json_encode($response);
}
?>