<?php
class HewanController {
    private $conn; 
    private $table_name = "hewan";

    public $id_hewan, $nama_hewan, $tgl_lahir_hewan, $id_jenis, $id_ukuran, $id_member, $hewan_nama_log;

    //constructor 
    public function __construct($db)    {
        $this->conn = $db; 
    }

    //INSERT RESEP KE DALAM TABEL
    function create()   {
        $query = "INSERT INTO " . $this->table_name . 
                 " SET 
                    nama_hewan = :nama_hewan, 
                    tgl_lahir_hewan = :tgl_lahir_hewan,
                    id_jenis = :id_jenis,
                    id_ukuran = :id_ukuran,
                    id_member = :id_member,
                    hewan_nama_log = :hewan_nama_log
                    "; 
        
        //prepare query 
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->nama_hewan = htmlspecialchars(strip_tags($this->nama_hewan));
        $this->tgl_lahir_hewan = htmlspecialchars(strip_tags($this->tgl_lahir_hewan));
        $this->id_jenis = htmlspecialchars(strip_tags($this->id_jenis));
        $this->id_ukuran = htmlspecialchars(strip_tags($this->id_ukuran));
        $this->id_member = htmlspecialchars(strip_tags($this->id_member));
        $this->hewan_nama_log = htmlspecialchars(strip_tags($this->hewan_nama_log));

        //bind values 
        $stmt->bindParam(":nama_hewan", $this->nama_hewan);
        $stmt->bindParam(":tgl_lahir_hewan", $this->tgl_lahir_hewan);
        $stmt->bindParam(":id_jenis", $this->id_jenis);
        $stmt->bindParam(":id_ukuran", $this->id_ukuran);
        $stmt->bindParam(":id_member", $this->id_member);
        $stmt->bindParam(":hewan_nama_log", $this->hewan_nama_log);

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
                    nama_hewan = :nama_hewan, 
                    tgl_lahir_hewan = :tgl_lahir_hewan,
                    id_jenis = :id_jenis,
                    id_ukuran = :id_ukuran,
                    id_member = :id_member,
                    hewan_nama_log = :hewan_nama_log
                WHERE
                    id_hewan = :id_hewan";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        //sanitize
        $this->id_hewan = htmlspecialchars(strip_tags($this->id_hewan));
        $this->nama_hewan = htmlspecialchars(strip_tags($this->nama_hewan));
        $this->tgl_lahir_hewan = htmlspecialchars(strip_tags($this->tgl_lahir_hewan));
        $this->id_jenis = htmlspecialchars(strip_tags($this->id_jenis));
        $this->id_ukuran = htmlspecialchars(strip_tags($this->id_ukuran));
        $this->id_member = htmlspecialchars(strip_tags($this->id_member));
        $this->hewan_nama_log = htmlspecialchars(strip_tags($this->hewan_nama_log));

        //bind values 
        $stmt->bindParam(":id_hewan", $this->id_hewan);
        $stmt->bindParam(":nama_hewan", $this->nama_hewan);
        $stmt->bindParam(":tgl_lahir_hewan", $this->tgl_lahir_hewan);
        $stmt->bindParam(":id_jenis", $this->id_jenis);
        $stmt->bindParam(":id_ukuran", $this->id_ukuran);
        $stmt->bindParam(":id_member", $this->id_member);
        $stmt->bindParam(":hewan_nama_log", $this->hewan_nama_log);

        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }

    // delete a participant
    function delete()   {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_hewan = ?";
        $log = "UPDATE log_hewan SET 
                     hewan_nama_log = :hewan_nama_log,
                     hewan_delete_log = NOW()
                WHERE id_log_hewan = 3";

        //prepare query
        $stmt = $this->conn->prepare($query);
        $logtmt = $this->conn->prepare($log);

        //sanitize 
        $this->id_hewan = htmlspecialchars(strip_tags($this->id_hewan));
        $this->hewan_nama_log = htmlspecialchars(strip_tags($this->hewan_nama_log));

        //bind ID of record to delete
        $stmt->bindParam(1, $this->id_hewan);
        $logtmt->bindParam(":hewan_nama_log", $this->hewan_nama_log);

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
                id_hewan = ?
                LIMIT
                    0,1
                    ";
        $stmt = $this->conn->prepare( $query );
     
        $this->id_hewan = htmlspecialchars(strip_tags($this->id_hewan));
        // bind id of product to be updated
        $stmt->bindParam(1, $this->id_hewan);
        //execute query
        if ( $stmt->execute() ) {
            return $stmt;
        }

        return false;
    }

}
?>