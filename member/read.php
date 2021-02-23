<?php
include_once '../header.php';
// get database connection
include_once '../config/database.php';
 
// instantiate participant object
include_once '../controller/MemberController.php';
// instantiate database and product object

$database = new Database();
$db = $database->getConnection();

// initialize object
$product = new MemberController($db);

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
            "id_member" => $id_member,
            "nama_member" => $nama_member,
            "alamat_member" => $alamat_member,
            "tgl_lahir_member" => $tgl_lahir_member,
            "no_telp_member" => $no_telp_member,
            "member_nama_log" => $member_nama_log,
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
