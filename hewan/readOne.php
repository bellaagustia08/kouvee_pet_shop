<?php
include_once '../header.php';
// get database connection
include_once '../config/database.php';
 
// instantiate participant object
include_once '../controller/HewanController.php';

$database = new Database();
$db = $database->getConnection();
 
// prepare user object
$product = new HewanController($db);

$product->id_hewan = $_POST["id_hewan"];
$stmtOne = $product->readOne();
$rowOne = $stmtOne->fetch(PDO::FETCH_ASSOC);
$redirectedOne = array(
    "id_hewan" => $rowOne['id_hewan'],
    "nama_hewan" => $rowOne['nama_hewan'],
    "tgl_lahir_hewan" => $rowOne['tgl_lahir_hewan'],
    "id_jenis" => $rowOne['id_jenis'],
    "id_ukuran" => $rowOne['id_ukuran'],
    "id_member" => $rowOne['id_member'],
    "hewan_nama_log" => $rowOne['hewan_nama_log'],
 );
 
// make it json format

echo json_encode($redirectedOne);
?>