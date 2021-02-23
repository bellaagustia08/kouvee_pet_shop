<?php
include_once '../header.php';
// get database connection
include_once '../config/database.php';
 
// instantiate participant object
include_once '../controller/ProdukController.php';

$database = new Database();
$db = $database->getConnection();
 
// prepare user object
$product = new ProdukController($db);

$product->id_produk = $_POST["id_produk"];
$stmtOne = $product->readOne();
$rowOne = $stmtOne->fetch(PDO::FETCH_ASSOC);
$redirectedOne = array(
    "id_produk" => $rowOne['id_produk'],
    "nama_produk" => $rowOne['nama_produk'],
    "jumlah_stok_produk" => $rowOne['jumlah_stok_produk'],
    "stok_minimum_produk" => $rowOne['stok_minimum_produk'],
    "harga_produk" => $rowOne['harga_produk'],
    "gambar" => $rowOne['gambar'],
    "produk_nama_log" => $rowOne['produk_nama_log'],
 );
 
// make it json format

echo json_encode($redirectedOne);
?>