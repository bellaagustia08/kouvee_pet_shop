<?php
include_once '../header.php';
// get database connection
include_once '../config/database.php';
 
// instantiate participant object
include_once '../controller/HewanController.php';
// instantiate database and product object

$database = new Database();
$db = $database->getConnection();

// initialize object
$product = new HewanController($db);

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
            "id_hewan" => $id_hewan,
            "nama_hewan" => $nama_hewan,
            "tgl_lahir_hewan" => $tgl_lahir_hewan,
            "id_jenis" => $id_jenis,
            "id_ukuran" => $id_ukuran,
            "id_member" => $id_member,
            "hewan_nama_log" => $hewan_nama_log,
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
