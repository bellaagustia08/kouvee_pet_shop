<?php
include_once '../header.php';
// get database connection
include_once '../config/database.php';
 
// instantiate participant object
include_once '../controller/SupplierController.php';
// instantiate database and product object

$database = new Database();
$db = $database->getConnection();

// initialize object
$product = new SupplierController($db);

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
            "id_supplier" => $id_supplier,
            "nama_supplier" => $nama_supplier,
            "alamat_supplier" => $alamat_supplier,
            "no_telp_supplier" => $no_telp_supplier,
            "supplier_nama_log" => $supplier_nama_log,
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
