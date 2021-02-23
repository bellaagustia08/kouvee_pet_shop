<?php
class UkuranHewanController {
    private $conn; 
    private $table_name = "ukuran_hewan";

    public $id_ukuran, $nama_ukuran, $ukuranHewan_nama_log;

    //constructor 
    public function __construct($db)    {
        $this->conn = $db; 
    }

    //INSERT RESEP KE DALAM TABEL
    function create()   {
        $query = "INSERT INTO " . $this->table_name . 
                 " SET 
                       nama_ukuran = :nama_ukuran, 
                       ukuranHewan_nama_log = :ukuranHewan_nama_log
                       "; 
        
        //prepare query 
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->nama_ukuran = htmlspecialchars(strip_tags($this->nama_ukuran));
        $this->ukuranHewan_nama_log = htmlspecialchars(strip_tags($this->ukuranHewan_nama_log));
    
        //bind values 
        $stmt->bindParam(":nama_ukuran", $this->nama_ukuran);
        $stmt->bindParam(":ukuranHewan_nama_log", $this->ukuranHewan_nama_log);
        
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
                    nama_ukuran = :nama_ukuran, 
                    ukuranHewan_nama_log = :ukuranHewan_nama_log
                WHERE
                    id_ukuran = :id_ukuran";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        //sanitize
        $this->id_ukuran = htmlspecialchars(strip_tags($this->id_ukuran));
        $this->nama_ukuran = htmlspecialchars(strip_tags($this->nama_ukuran));
        $this->ukuranHewan_nama_log = htmlspecialchars(strip_tags($this->ukuranHewan_nama_log));

        //bind values 
        $stmt->bindParam(":id_ukuran", $this->id_ukuran);
        $stmt->bindParam(":nama_ukuran", $this->nama_ukuran);
        $stmt->bindParam(":ukuranHewan_nama_log", $this->ukuranHewan_nama_log);

        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }

    // delete a participant
    function delete()   {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_ukuran = ?";
        $log = "UPDATE log_ukuranHewan SET 
                     ukuranHewan_nama_log = :ukuranHewan_nama_log,
                     ukuranHewan_delete_log = NOW()
                WHERE id_log_ukuranHewan = 3";

        //prepare query
        $stmt = $this->conn->prepare($query);
        $logtmt = $this->conn->prepare($log);

        //sanitize 
        $this->id_ukuran = htmlspecialchars(strip_tags($this->id_ukuran));
        $this->ukuranHewan_nama_log = htmlspecialchars(strip_tags($this->ukuranHewan_nama_log));

        //bind ID of record to delete
        $stmt->bindParam(1, $this->id_ukuran);
        $logtmt->bindParam(":ukuranHewan_nama_log", $this->ukuranHewan_nama_log);

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
                id_ukuran = ?
                LIMIT
                    0,1
                    ";
        $stmt = $this->conn->prepare( $query );
     
        $this->id_ukuran = htmlspecialchars(strip_tags($this->id_ukuran));
        // bind id of product to be updated
        $stmt->bindParam(1, $this->id_ukuran);
        //execute query
        if ( $stmt->execute() ) {
            return $stmt;
        }

        return false;
    }

}
?>