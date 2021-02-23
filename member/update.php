<?php
include_once '../header.php';
// get database connection
include_once '../config/database.php';
 
// instantiate participant object
include_once '../controller/MemberController.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$product = new MemberController($db);

 
// set ID property of product to be edited
$product->id_member =$_POST["id_member"];

// set product property values
$product->nama_member = $_POST['nama_member'];
$product->alamat_member = $_POST['alamat_member'];
$product->tgl_lahir_member = $_POST['tgl_lahir_member'];
$product->no_telp_member = $_POST['no_telp_member'];

$product->member_nama_log = $_POST['member_nama_log'];

    if($product->update()){
        $response["value"] = 200;
        $response["message"] = "Update Data Member berhasil";
        echo json_encode($response);
    }
     
    // if unable to update the product, tell the user
    else{
        $response["value"] = 100;
        $response["message"] = "Update Data Member gagal";
        echo json_encode($response);
    }

// update the product

?>