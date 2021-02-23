<?php
class JenisHewanController {
    private $conn; 
    private $table_name = "jenis_hewan";

    public $id_jenis, $nama_jenis, $jenisHewan_nama_log;

    //constructor 
    public function __construct($db)    {
        $this->conn = $db; 
    }

    //INSERT RESEP KE DALAM TABEL
    function create()   {
        $query = "INSERT INTO " . $this->table_name . 
                 " SET 
                    nama_jenis = :nama_jenis, 
                    jenisHewan_nama_log = :jenisHewan_nama_log
                    "; 
        
        //prepare query 
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->nama_jenis = htmlspecialchars(strip_tags($this->nama_jenis));
        $this->jenisHewan_nama_log = htmlspecialchars(strip_tags($this->jenisHewan_nama_log));

        //bind values 
        $stmt->bindParam(":nama_jenis", $this->nama_jenis);
        $stmt->bindParam(":jenisHewan_nama_log", $this->jenisHewan_nama_log);

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
                    nama_jenis = :nama_jenis,
                    jenisHewan_nama_log = :jenisHewan_nama_log
                WHERE
                    id_jenis = :id_jenis";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        //sanitize
        $this->id_jenis = htmlspecialchars(strip_tags($this->id_jenis));
        $this->nama_jenis = htmlspecialchars(strip_tags($this->nama_jenis));
        $this->jenisHewan_nama_log = htmlspecialchars(strip_tags($this->jenisHewan_nama_log));

        //bind values 
        $stmt->bindParam(":id_jenis", $this->id_jenis);
        $stmt->bindParam(":nama_jenis", $this->nama_jenis);
        $stmt->bindParam(":jenisHewan_nama_log", $this->jenisHewan_nama_log);

        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }

    // delete a participant
    function delete()   {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_jenis = ?";
        $log = "UPDATE log_jenisHewan SET 
                     jenisHewan_nama_log = :jenisHewan_nama_log,
                     jenisHewan_delete_log = NOW()
                WHERE id_log_jenisHewan = 3";

        //prepare query
        $stmt = $this->conn->prepare($query);
        $logtmt = $this->conn->prepare($log);

        //sanitize 
        $this->id_jenis = htmlspecialchars(strip_tags($this->id_jenis));
        $this->jenisHewan_nama_log = htmlspecialchars(strip_tags($this->jenisHewan_nama_log));

        //bind ID of record to delete
        $stmt->bindParam(1, $this->id_jenis);
        $logtmt->bindParam(":jenisHewan_nama_log", $this->jenisHewan_nama_log);

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
                id_jenis = ?
                LIMIT
                    0,1
                    ";
        $stmt = $this->conn->prepare( $query );
     
        $this->id_jenis = htmlspecialchars(strip_tags($this->id_jenis));
        // bind id of product to be updated
        $stmt->bindParam(1, $this->id_jenis);
        //execute query
        if ( $stmt->execute() ) {
            return $stmt;
        }

        return false;
    }

}
?>