<?php
include_once '../header.php';
// get database connection
include_once '../config/database.php';
 
// instantiate participant object
include_once '../controller/ProdukController.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$product = new ProdukController($db);

 
// set ID property of product to be edited
$product->id_produk =$_POST["id_produk"];

// set product property values
$product->nama_produk = $_POST['nama_produk'];
$product->jumlah_stok_produk = $_POST['jumlah_stok_produk'];
$product->stok_minimum_produk = $_POST['stok_minimum_produk'];
$product->harga_produk = $_POST['harga_produk'];
$product->gambar = $_FILES['gambar'];
$product->produk_nama_log = $_POST['produk_nama_log'];

    if($product->update()){
        $response["value"] = 200;
        $response["message"] = "Update Data Produk berhasil";
        echo json_encode($response);
    }
     
    // if unable to update the product, tell the user
    else{
        $response["value"] = 100;
        $response["message"] = "Update Data Produk gagal";
        echo json_encode($response);
    }

// update the product

?>