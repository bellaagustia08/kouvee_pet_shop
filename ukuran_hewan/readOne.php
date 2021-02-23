<?php
include_once '../header.php';
// get database connection
include_once '../config/database.php';
 
// instantiate participant object
include_once '../controller/UkuranHewanController.php';

$database = new Database();
$db = $database->getConnection();
 
// prepare user object
$product = new UkuranHewanController($db);

$product->id_ukuran = $_POST["id_ukuran"];
$stmtOne = $product->readOne();
$rowOne = $stmtOne->fetch(PDO::FETCH_ASSOC);
$redirectedOne = array(
    "id_ukuran" => $rowOne['id_ukuran'],
    "nama_ukuran" => $rowOne['nama_ukuran'],
    "ukuranHewan_nama_log" => $rowOne['ukuranHewan_nama_log'],
 );
 
// make it json format

echo json_encode($redirectedOne);
?>