<?php
class MemberController {
    private $conn; 
    private $table_name = "member";

    public $id_member, 
    $nama_member, 
    $alamat_member, 
    $tgl_lahir_member, 
    $no_telp_member,
    $member_nama_log;

    //constructor 
    public function __construct($db)    {
        $this->conn = $db; 
    }

    //INSERT RESEP KE DALAM TABEL
    function create()   {
        $query = "INSERT INTO " . $this->table_name . 
                 " SET 
                 nama_member = :nama_member,
                 alamat_member = :alamat_member, 
                 tgl_lahir_member = :tgl_lahir_member,
                 no_telp_member = :no_telp_member, 
                 member_nama_log = :member_nama_log
                    "; 
        
        //prepare query 
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->nama_member = htmlspecialchars(strip_tags($this->nama_member));
        $this->alamat_member = htmlspecialchars(strip_tags($this->alamat_member));
        $this->tgl_lahir_member = htmlspecialchars(strip_tags($this->tgl_lahir_member));
        $this->no_telp_member = htmlspecialchars(strip_tags($this->no_telp_member));
        $this->member_nama_log = htmlspecialchars(strip_tags($this->member_nama_log));

        //bind values 
        $stmt->bindParam(":nama_member", $this->nama_member);
        $stmt->bindParam(":alamat_member", $this->alamat_member);
        $stmt->bindParam(":tgl_lahir_member", $this->tgl_lahir_member);
        $stmt->bindParam(":no_telp_member", $this->no_telp_member);
        $stmt->bindParam(":member_nama_log", $this->member_nama_log);

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
                    nama_member = :nama_member,
                    alamat_member = :alamat_member, 
                    tgl_lahir_member = :tgl_lahir_member,
                    no_telp_member = :no_telp_member, 
                    member_nama_log = :member_nama_log
                WHERE
                    id_member = :id_member";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        //sanitize
        $this->id_member = htmlspecialchars(strip_tags($this->id_member));
        $this->nama_member = htmlspecialchars(strip_tags($this->nama_member));
        $this->alamat_member = htmlspecialchars(strip_tags($this->alamat_member));
        $this->tgl_lahir_member = htmlspecialchars(strip_tags($this->tgl_lahir_member));
        $this->no_telp_member = htmlspecialchars(strip_tags($this->no_telp_member));
        $this->member_nama_log = htmlspecialchars(strip_tags($this->member_nama_log));

        //bind values 
        $stmt->bindParam(":id_member", $this->id_member);
        $stmt->bindParam(":nama_member", $this->nama_member);
        $stmt->bindParam(":alamat_member", $this->alamat_member);
        $stmt->bindParam(":tgl_lahir_member", $this->tgl_lahir_member);
        $stmt->bindParam(":no_telp_member", $this->no_telp_member);
        $stmt->bindParam(":member_nama_log", $this->member_nama_log);

        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }

    // delete a participant
    function delete()   {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_member = ?";
        $log = "UPDATE log_member SET 
                     member_nama_log = :member_nama_log,
                     member_delete_log = NOW()
                WHERE id_log_member = 3";

        //prepare query
        $stmt = $this->conn->prepare($query);
        $logtmt = $this->conn->prepare($log);

        //sanitize 
        $this->id_member = htmlspecialchars(strip_tags($this->id_member));
        $this->member_nama_log = htmlspecialchars(strip_tags($this->member_nama_log));

        //bind ID of record to delete
        $stmt->bindParam(1, $this->id_member);
        $logtmt->bindParam(":member_nama_log", $this->member_nama_log);

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
                id_member = ?
                LIMIT
                    0,1
                    ";
        $stmt = $this->conn->prepare( $query );
     
        $this->id_member = htmlspecialchars(strip_tags($this->id_member));
        // bind id of product to be updated
        $stmt->bindParam(1, $this->id_member);
        //execute query
        if ( $stmt->execute() ) {
            return $stmt;
        }

        return false;
    }

}
?>