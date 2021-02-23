<?php
include_once '../header.php';
// get database connection
include_once '../config/database.php';
 
// instantiate participant object
include_once '../controller/SupplierController.php';

$database = new Database();
$db = $database->getConnection();
 
// prepare user object
$product = new SupplierController($db);

$product->id_supplier = $_POST["id_supplier"];
$stmtOne = $product->readOne();
$rowOne = $stmtOne->fetch(PDO::FETCH_ASSOC);
$redirectedOne = array(
    "id_supplier" => $rowOne['id_supplier'],
    "nama_supplier" => $rowOne['nama_supplier'],
    "alamat_supplier" => $rowOne['alamat_supplier'],
    "no_telp_supplier" => $rowOne['no_telp_supplier'],
    "supplier_nama_log" => $rowOne['supplier_nama_log'],
 );
 
// make it json format

echo json_encode($redirectedOne);
?>