<?php
class ProdukController {
    private $conn; 
    private $table_name = "produk";

    public $id_produk, $nama_produk, $jumlah_stok_produk, $stok_minimum_produk, $harga_produk, $gambar, $produk_nama_log;

    //constructor 
    public function __construct($db)    {
        $this->conn = $db; 
    }

    //INSERT RESEP KE DALAM TABEL
    function create()   {
        $query = "INSERT INTO " . $this->table_name . 
                 " SET 
                    nama_produk = :nama_produk,
                    jumlah_stok_produk = :jumlah_stok_produk, 
                    stok_minimum_produk = :stok_minimum_produk,
                    harga_produk = :harga_produk, 
                    gambar = :gambar,
                    produk_nama_log = :produk_nama_log
                    "; 
        
        //prepare query 
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->nama_produk = htmlspecialchars(strip_tags($this->nama_produk));
        $this->jumlah_stok_produk = htmlspecialchars(strip_tags($this->jumlah_stok_produk));
        $this->stok_minimum_produk = htmlspecialchars(strip_tags($this->stok_minimum_produk));
        $this->harga_produk = htmlspecialchars(strip_tags($this->harga_produk));
        $this->gambar = $nama_file;
        $this->produk_nama_log = htmlspecialchars(strip_tags($this->produk_nama_log));

        //bind values 
        $stmt->bindParam(":nama_produk", $this->nama_produk);
        $stmt->bindParam(":jumlah_stok_produk", $this->jumlah_stok_produk);
        $stmt->bindParam(":stok_minimum_produk", $this->stok_minimum_produk);
        $stmt->bindParam(":harga_produk", $this->harga_produk);
        $stmt->bindParam(":gambar", $this->gambar);
        $stmt->bindParam(":produk_nama_log", $this->produk_nama_log);

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
                    nama_produk = :nama_produk,
                    jumlah_stok_produk = :jumlah_stok_produk, 
                    stok_minimum_produk = :stok_minimum_produk,
                    harga_produk = :harga_produk,
                    gambar = :gambar, 
                    produk_nama_log = :produk_nama_log
                WHERE
                    id_produk = :id_produk";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        //sanitize
        $this->id_produk = htmlspecialchars(strip_tags($this->id_produk));
        $this->nama_produk = htmlspecialchars(strip_tags($this->nama_produk));
        $this->jumlah_stok_produk = htmlspecialchars(strip_tags($this->jumlah_stok_produk));
        $this->stok_minimum_produk = htmlspecialchars(strip_tags($this->stok_minimum_produk));
        $this->harga_produk = htmlspecialchars(strip_tags($this->harga_produk));
        $this->gambar = htmlspecialchars(strip_tags($this->gambar));
        $this->produk_nama_log = htmlspecialchars(strip_tags($this->produk_nama_log));

        //bind values 
        $stmt->bindParam(":id_produk", $this->id_produk);
        $stmt->bindParam(":nama_produk", $this->nama_produk);
        $stmt->bindParam(":jumlah_stok_produk", $this->jumlah_stok_produk);
        $stmt->bindParam(":stok_minimum_produk", $this->stok_minimum_produk);
        $stmt->bindParam(":harga_produk", $this->harga_produk);
        $stmt->bindParam(":gambar", $this->gambar);
        $stmt->bindParam(":produk_nama_log", $this->produk_nama_log);

        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }

    // delete a participant
    function delete()   {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_produk = ?";
        $log = "UPDATE log_produk SET 
                     produk_nama_log = :produk_nama_log,
                     produk_delete_log = NOW()
                WHERE id_log_produk = 3";

        //prepare query
        $stmt = $this->conn->prepare($query);
        $logtmt = $this->conn->prepare($log);

        //sanitize 
        $this->id_produk = htmlspecialchars(strip_tags($this->id_produk));
        $this->produk_nama_log = htmlspecialchars(strip_tags($this->produk_nama_log));

        //bind ID of record to delete
        $stmt->bindParam(1, $this->id_produk);
        $logtmt->bindParam(":produk_nama_log", $this->produk_nama_log);

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
                id_produk = ?
                LIMIT
                    0,1
                    ";
        $stmt = $this->conn->prepare( $query );
     
        $this->id_produk = htmlspecialchars(strip_tags($this->id_produk));
        // bind id of product to be updated
        $stmt->bindParam(1, $this->id_produk);
        //execute query
        if ( $stmt->execute() ) {
            return $stmt;
        }

        return false;
    }

}
?>