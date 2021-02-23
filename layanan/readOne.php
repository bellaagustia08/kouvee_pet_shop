<?php
include_once '../header.php';
// get database connection
include_once '../config/database.php';
 
// instantiate participant object
include_once '../controller/LayananController.php';

$database = new Database();
$db = $database->getConnection();
 
// prepare user object
$product = new LayananController($db);

$product->id_layanan = $_POST["id_layanan"];
$stmtOne = $product->readOne();
$rowOne = $stmtOne->fetch(PDO::FETCH_ASSOC);
$redirectedOne = array(
    "id_layanan" => $rowOne['id_layanan'],
    "nama_layanan" => $rowOne['nama_layanan'],

    "layanan_nama_log" => $rowOne['layanan_nama_log'],
 );
 
// make it json format

echo json_encode($redirectedOne);
?>