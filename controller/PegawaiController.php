<?php
class PegawaiController {
    private $conn; 
    private $table_name = "pegawai";

    public $id_pegawai, 
    $nama_pegawai, 
    $alamat_pegawai, 
    $tgl_lahir_pegawai, 
    $no_telp_pegawai, 
    $jabatan_pegawai, 
    $password, 
    $pegawai_nama_log;

    //constructor 
    public function __construct($db)    {
        $this->conn = $db; 
    }

    //INSERT RESEP KE DALAM TABEL
    function create()   {
        $query = "INSERT INTO " . $this->table_name . 
                 " SET 
                 nama_pegawai = :nama_pegawai,
                 alamat_pegawai = :alamat_pegawai, 
                 tgl_lahir_pegawai = :tgl_lahir_pegawai,
                 no_telp_pegawai = :no_telp_pegawai, 
                 jabatan_pegawai = :jabatan_pegawai,
                 password = :password,
                 pegawai_nama_log = :pegawai_nama_log
                    "; 
        
        //prepare query 
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->nama_pegawai = htmlspecialchars(strip_tags($this->nama_pegawai));
        $this->alamat_pegawai = htmlspecialchars(strip_tags($this->alamat_pegawai));
        $this->tgl_lahir_pegawai = htmlspecialchars(strip_tags($this->tgl_lahir_pegawai));
        $this->no_telp_pegawai = htmlspecialchars(strip_tags($this->no_telp_pegawai));
        $this->jabatan_pegawai = htmlspecialchars(strip_tags($this->jabatan_pegawai));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->pegawai_nama_log = htmlspecialchars(strip_tags($this->pegawai_nama_log));

        //bind values 
        $stmt->bindParam(":nama_pegawai", $this->nama_pegawai);
        $stmt->bindParam(":alamat_pegawai", $this->alamat_pegawai);
        $stmt->bindParam(":tgl_lahir_pegawai", $this->tgl_lahir_pegawai);
        $stmt->bindParam(":no_telp_pegawai", $this->no_telp_pegawai);
        $stmt->bindParam(":jabatan_pegawai", $this->jabatan_pegawai);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":pegawai_nama_log", $this->pegawai_nama_log);

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
                    nama_pegawai = :nama_pegawai,
                    alamat_pegawai = :alamat_pegawai, 
                    tgl_lahir_pegawai = :tgl_lahir_pegawai,
                    no_telp_pegawai = :no_telp_pegawai, 
                    jabatan_pegawai = :jabatan_pegawai,
                    password = :password,
                    pegawai_nama_log = :pegawai_nama_log
                WHERE
                    id_pegawai = :id_pegawai";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        //sanitize
        $this->id_pegawai = htmlspecialchars(strip_tags($this->id_pegawai));
        $this->nama_pegawai = htmlspecialchars(strip_tags($this->nama_pegawai));
        $this->alamat_pegawai = htmlspecialchars(strip_tags($this->alamat_pegawai));
        $this->tgl_lahir_pegawai = htmlspecialchars(strip_tags($this->tgl_lahir_pegawai));
        $this->no_telp_pegawai = htmlspecialchars(strip_tags($this->no_telp_pegawai));
        $this->jabatan_pegawai = htmlspecialchars(strip_tags($this->jabatan_pegawai));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->pegawai_nama_log = htmlspecialchars(strip_tags($this->pegawai_nama_log));

        //bind values 
        $stmt->bindParam(":id_pegawai", $this->id_pegawai);
        $stmt->bindParam(":nama_pegawai", $this->nama_pegawai);
        $stmt->bindParam(":alamat_pegawai", $this->alamat_pegawai);
        $stmt->bindParam(":tgl_lahir_pegawai", $this->tgl_lahir_pegawai);
        $stmt->bindParam(":no_telp_pegawai", $this->no_telp_pegawai);
        $stmt->bindParam(":jabatan_pegawai", $this->jabatan_pegawai);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":pegawai_nama_log", $this->pegawai_nama_log);

        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }

    // delete a participant
    function delete()   {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_pegawai = ?";
        $log = "UPDATE log_pegawai SET 
                     pegawai_nama_log = :pegawai_nama_log,
                     pegawai_delete_log = NOW()
                WHERE id_log_pegawai = 3";

        //prepare query
        $stmt = $this->conn->prepare($query);
        $logtmt = $this->conn->prepare($log);

        //sanitize 
        $this->id_pegawai = htmlspecialchars(strip_tags($this->id_pegawai));
        $this->pegawai_nama_log = htmlspecialchars(strip_tags($this->pegawai_nama_log));

        //bind ID of record to delete
        $stmt->bindParam(1, $this->id_pegawai);
        $logtmt->bindParam(":pegawai_nama_log", $this->pegawai_nama_log);

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
                id_pegawai = ?
                LIMIT
                    0,1
                    ";
        $stmt = $this->conn->prepare( $query );
     
        $this->id_pegawai = htmlspecialchars(strip_tags($this->id_pegawai));
        // bind id of product to be updated
        $stmt->bindParam(1, $this->id_pegawai);
        //execute query
        if ( $stmt->execute() ) {
            return $stmt;
        }

        return false;
    }

}
?>