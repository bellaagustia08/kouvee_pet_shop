<?php
class SupplierController {
    private $conn; 
    private $table_name = "supplier";

    public $id_supplier, $nama_supplier, $alamat_supplier, $no_telp_supplier, $supplier_nama_log, $supplier_create_tgl_log, $supplier_edit_tgl_log, $supplier_delete_tgl_log;

    //constructor 
    public function __construct($db)    {
        $this->conn = $db; 
    }

    //INSERT RESEP KE DALAM TABEL
    function create()   {
        $query = "INSERT INTO " . $this->table_name . 
                 " SET 
                       nama_supplier = :nama_supplier,
                       alamat_supplier = :alamat_supplier, 
                       no_telp_supplier = :no_telp_supplier, 
                       supplier_nama_log = :supplier_nama_log
                       "; 
        
        //prepare query 
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->nama_supplier = htmlspecialchars(strip_tags($this->nama_supplier));
        $this->alamat_supplier = htmlspecialchars(strip_tags($this->alamat_supplier));
        $this->no_telp_supplier = htmlspecialchars(strip_tags($this->no_telp_supplier));
        $this->supplier_nama_log = htmlspecialchars(strip_tags($this->supplier_nama_log));
        // $this->supplier_create_tgl_log = htmlspecialchars(strip_tags($this->supplier_create_tgl_log));
        // $this->supplier_edit_tgl_log = htmlspecialchars(strip_tags($this->supplier_edit_tgl_log));
        // $this->supplier_delete_tgl_log = htmlspecialchars(strip_tags($this->supplier_delete_tgl_log));
        

        //bind values 
        $stmt->bindParam(":nama_supplier", $this->nama_supplier);
        $stmt->bindParam(":alamat_supplier", $this->alamat_supplier);
        $stmt->bindParam(":no_telp_supplier", $this->no_telp_supplier);
        $stmt->bindParam(":supplier_nama_log", $this->supplier_nama_log);
        // $stmt->bindParam(":supplier_create_tgl_log", $this->supplier_create_tgl_log);
        // $stmt->bindParam(":supplier_edit_tgl_log", $this->supplier_edit_tgl_log);
        // $stmt->bindParam(":supplier_delete_tgl_log", $this->supplier_delete_tgl_log);

        //execute query 
        if ( $stmt->execute() ) {
            return true; 
        }
        
        return false; 
    }


    function read(){

        // select all query
        $query = "SELECT *
                FROM
                    " . $this->table_name . " ";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    //update
    function update(){
    // update query
        $query = "UPDATE
                    " . $this->table_name . 
                 " SET 
                 nama_supplier = :nama_supplier,
                 alamat_supplier = :alamat_supplier, 
                 no_telp_supplier = :no_telp_supplier, 
                 supplier_nama_log = :supplier_nama_log
                WHERE
                    id_supplier = :id_supplier";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        //sanitize
        $this->id_supplier = htmlspecialchars(strip_tags($this->id_supplier));
        $this->nama_supplier = htmlspecialchars(strip_tags($this->nama_supplier));
        $this->alamat_supplier = htmlspecialchars(strip_tags($this->alamat_supplier));
        $this->no_telp_supplier = htmlspecialchars(strip_tags($this->no_telp_supplier));
        $this->supplier_nama_log = htmlspecialchars(strip_tags($this->supplier_nama_log));

        //bind values 
        $stmt->bindParam(":id_supplier", $this->id_supplier);
        $stmt->bindParam(":nama_supplier", $this->nama_supplier);
        $stmt->bindParam(":alamat_supplier", $this->alamat_supplier);
        $stmt->bindParam(":no_telp_supplier", $this->no_telp_supplier);
        $stmt->bindParam(":supplier_nama_log", $this->supplier_nama_log);

        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }

    // delete a participant
    function delete()   {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_supplier = ?";
        $log = "UPDATE log_supplier SET 
                     supplier_nama_log = :supplier_nama_log,
                     supplier_delete_log = NOW()
                WHERE id_log_supplier = 3";

        //prepare query
        $stmt = $this->conn->prepare($query);
        $logtmt = $this->conn->prepare($log);

        //sanitize 
        $this->id_supplier = htmlspecialchars(strip_tags($this->id_supplier));
        $this->supplier_nama_log = htmlspecialchars(strip_tags($this->supplier_nama_log));

        //bind ID of record to delete
        $stmt->bindParam(1, $this->id_supplier);
        $logtmt->bindParam(":supplier_nama_log", $this->supplier_nama_log);

        //execute query
        if ( $stmt->execute() ) {
            if($logtmt->execute())
            {
                return true;
            }
                return false;
        }

        return false;
    }

    function readOne(){
 
        // query to read single record
        $query = "SELECT *
                FROM
                    " . $this->table_name . "
                
                WHERE
                id_supplier = ?
                LIMIT
                    0,1
                    ";
        $stmt = $this->conn->prepare( $query );
     
        $this->id_supplier = htmlspecialchars(strip_tags($this->id_supplier));
        // bind id of product to be updated
        $stmt->bindParam(1, $this->id_supplier);
        //execute query
        if ( $stmt->execute() ) {
            return $stmt;
        }

        return false;
    }

}
?>