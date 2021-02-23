<?php
include_once '../header.php';
// get database connection
include_once '../config/database.php';
 
// instantiate participant object
include_once '../controller/PegawaiController.php';
// instantiate database and product object

$database = new Database();
$db = $database->getConnection();

// initialize object
$product = new PegawaiController($db);

// query products
$stmt = $product->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){
 
    // products array
    $products_arr=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $product_item=array(
            "id_pegawai" => $id_pegawai,
            "nama_pegawai" => $nama_pegawai,
            "alamat_pegawai" => $alamat_pegawai,
            "tgl_lahir_pegawai" => $tgl_lahir_pegawai,
            "no_telp_pegawai" => $no_telp_pegawai,
            "jabatan_pegawai" => $jabatan_pegawai,
            "password" => $password,
            "pegawai_nama_log" => $pegawai_nama_log,
         );
 
        array_push($products_arr, $product_item);
    }
 
    //FOR TESTING
    echo json_encode($products_arr);
}
 
else{
    
    $response["value"] = 503;
    $response["message"] = "Read gagal";
    echo json_encode($response);
}

?>
