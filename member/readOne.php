<?php
include_once '../header.php';
// get database connection
include_once '../config/database.php';
 
// instantiate participant object
include_once '../controller/MemberController.php';

$database = new Database();
$db = $database->getConnection();
 
// prepare user object
$product = new MemberController($db);

$product->id_member = $_POST["id_member"];
$stmtOne = $product->readOne();
$rowOne = $stmtOne->fetch(PDO::FETCH_ASSOC);
$redirectedOne = array(
    "id_member" => $rowOne['id_member'],
    "nama_member" => $rowOne['nama_member'],
    "alamat_member" => $rowOne['alamat_member'],
    "tgl_lahir_member" => $rowOne['tgl_lahir_member'],
    "no_telp_member" => $rowOne['no_telp_member'],
    "member_nama_log" => $rowOne['member_nama_log'],
 );
 
// make it json format

echo json_encode($redirectedOne);
?>