<?php
include_once '../header.php';
// get database connection
include_once '../config/database.php';
 
// instantiate participant object
include_once '../controller/MemberController.php';
 
$database = new Database();
$db = $database->getConnection();

$product = new MemberController($db);
 
// get posted data
$product->nama_member = $_POST['nama_member'];
$product->alamat_member = $_POST['alamat_member'];
$product->tgl_lahir_member = $_POST['tgl_lahir_member'];
$product->no_telp_member = $_POST['no_telp_member'];

$product->member_nama_log = $_POST['member_nama_log'];

if($product->create()){
        $response["value"] = 200;
        $response["message"] = "Member berhasil ditambahkan";
        echo json_encode($response);
    }
     
    // if unable to create the product, tell the user
    else{
        $response["value"] = 100;
        $response["message"] = "Member gagal ditambahkan";
        echo json_encode($response);
    }
?>