<?php
include_once '../header.php';
// get database connection
include_once '../config/database.php';
 
// instantiate participant object
include_once '../controller/MemberController.php';
 
 
// get database connection
$database = new Database();
$db = $database->getConnection();
$product = new MemberController($db);

$product->id_member = $_POST["id_member"];
$product->member_nama_log = $_POST["member_nama_log"];
 
// delete the product
if($product->delete()){
    $response["value"] = 200;
    $response["message"] = "Delete Member berhasil";
    echo json_encode($response);
}
 
// if unable to create the product, tell the user
else{
    $response["value"] = 100;
    $response["message"] = "Delete Member gagal";
    echo json_encode($response);
}
?>