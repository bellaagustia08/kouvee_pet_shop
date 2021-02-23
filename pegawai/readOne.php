<?php
include_once '../header.php';
// get database connection
include_once '../config/database.php';
 
// instantiate participant object
include_once '../controller/PegawaiController.php';

$database = new Database();
$db = $database->getConnection();
 
// prepare user object
$product = new PegawaiController($db);

$product->id_pegawai = $_POST["id_pegawai"];
$stmtOne = $product->readOne();
$rowOne = $stmtOne->fetch(PDO::FETCH_ASSOC);
$redirectedOne = array(
    "id_pegawai" => $rowOne['id_pegawai'],
    "nama_pegawai" => $rowOne['nama_pegawai'],
    "alamat_pegawai" => $rowOne['alamat_pegawai'],
    "tgl_lahir_pegawai" => $rowOne['tgl_lahir_pegawai'],
    "no_telp_pegawai" => $rowOne['no_telp_pegawai'],
    "jabatan_pegawai" => $rowOne['jabatan_pegawai'],
    "password" => $rowOne['password'],
    "pegawai_nama_log" => $rowOne['pegawai_nama_log'],
 );
 
// make it json format

echo json_encode($redirectedOne);
?>