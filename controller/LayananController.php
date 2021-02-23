<?php
class LayananController {
    private $conn; 
    private $table_name = "layanan";

    public $id_layanan, $nama_layanan, $layanan_nama_log;

    //constructor 
    public function __construct($db)    {
        $this->conn = $db; 
    }

    //INSERT RESEP KE DALAM TABEL
    function create()   {
        $query = "INSERT INTO " . $this->table_name . 
                 " SET 
                    nama_layanan = :nama_layanan, 
                    layanan_nama_log = :layanan_nama_log
                    "; 
        
        //prepare query 
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->nama_layanan = htmlspecialchars(strip_tags($this->nama_layanan));
        $this->layanan_nama_log = htmlspecialchars(strip_tags($this->layanan_nama_log));

        //bind values 
        $stmt->bindParam(":nama_layanan", $this->nama_layanan);
        $stmt->bindParam(":layanan_nama_log", $this->layanan_nama_log);

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
                    nama_layanan = :nama_layanan,
                    layanan_nama_log = :layanan_nama_log
                WHERE
                    id_layanan = :id_layanan";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        //sanitize
        $this->id_layanan = htmlspecialchars(strip_tags($this->id_layanan));
        $this->nama_layanan = htmlspecialchars(strip_tags($this->nama_layanan));
        $this->layanan_nama_log = htmlspecialchars(strip_tags($this->layanan_nama_log));

        //bind values 
        $stmt->bindParam(":id_layanan", $this->id_layanan);
        $stmt->bindParam(":nama_layanan", $this->nama_layanan);
        $stmt->bindParam(":layanan_nama_log", $this->layanan_nama_log);

        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }

    // delete a participant
    function delete()   {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_layanan = ?";
        $log = "UPDATE log_layanan SET 
                     layanan_nama_log = :layanan_nama_log,
                     layanan_delete_log = NOW()
                WHERE id_log_layanan = 3";

        //prepare query
        $stmt = $this->conn->prepare($query);
        $logtmt = $this->conn->prepare($log);

        //sanitize 
        $this->id_layanan = htmlspecialchars(strip_tags($this->id_layanan));
        $this->layanan_nama_log = htmlspecialchars(strip_tags($this->layanan_nama_log));

        //bind ID of record to delete
        $stmt->bindParam(1, $this->id_layanan);
        $logtmt->bindParam(":layanan_nama_log", $this->layanan_nama_log);

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
                id_layanan = ?
                LIMIT
                    0,1
                    ";
        $stmt = $this->conn->prepare( $query );
     
        $this->id_layanan = htmlspecialchars(strip_tags($this->id_layanan));
        // bind id of product to be updated
        $stmt->bindParam(1, $this->id_layanan);
        //execute query
        if ( $stmt->execute() ) {
            return $stmt;
        }

        return false;
    }

}
?>