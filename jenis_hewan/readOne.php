<?php
include_once '../header.php';
// get database connection
include_once '../config/database.php';
 
// instantiate participant object
include_once '../controller/JenisHewanController.php';

$database = new Database();
$db = $database->getConnection();
 
// prepare user object
$product = new JenisHewanController($db);

$product->id_jenis = $_POST["id_jenis"];
$stmtOne = $product->readOne();
$rowOne = $stmtOne->fetch(PDO::FETCH_ASSOC);
$redirectedOne = array(
    "id_jenis" => $rowOne['id_jenis'],
    "nama_jenis" => $rowOne['nama_jenis'],

    "jenisHewan_nama_log" => $rowOne['jenisHewan_nama_log'],
 );
 
// make it json format

echo json_encode($redirectedOne);
?>