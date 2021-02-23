<?php
include_once '../header.php';
// get database connection
include_once '../config/database.php';
 
// instantiate participant object
include_once '../controller/ProdukController.php';
 
$database = new Database();
$db = $database->getConnection();

$product = new ProdukController($db);
 
// get posted data
$product->nama_produk = $_POST['nama_produk'];
$product->jumlah_stok_produk = $_POST['jumlah_stok_produk'];
$product->stok_minimum_produk = $_POST['stok_minimum_produk'];
$product->harga_produk = $_POST['harga_produk'];
$product->gambar = $_FILES['gambar']['name'];

$file_tmp = $_FILES['gambar']['tmp_name'];

move_uploaded_file($file_tmp,'../gambar/'.$_FILES['gambar']['name']);

if($product->create()){
        $response["value"] = 200;
        $response["message"] = "Produk berhasil ditambahkan";
        echo json_encode($response);
    }
     
    // if unable to create the product, tell the user
    else{
        $response["value"] = 100;
        $response["message"] = "Produk gagal ditambahkan";
        echo json_encode($response);
    }
?>