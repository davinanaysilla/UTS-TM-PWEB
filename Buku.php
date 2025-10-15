<?php
class Buku {
    private $conn;
    private $table_name = "buku";

    public $id;
    public $kode_buku;
    public $judul;
    public $pengarang;
    public $penerbit;
    public $tahun_terbit;
    public $stok;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                 SET kode_buku=:kode_buku, judul=:judul, pengarang=:pengarang, 
                     penerbit=:penerbit, tahun_terbit=:tahun_terbit, stok=:stok";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":kode_buku", $this->kode_buku);
        $stmt->bindParam(":judul", $this->judul);
        $stmt->bindParam(":pengarang", $this->pengarang);
        $stmt->bindParam(":penerbit", $this->penerbit);
        $stmt->bindParam(":tahun_terbit", $this->tahun_terbit);
        $stmt->bindParam(":stok", $this->stok);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row) {
            $this->kode_buku = $row['kode_buku'];
            $this->judul = $row['judul'];
            $this->pengarang = $row['pengarang'];
            $this->penerbit = $row['penerbit'];
            $this->tahun_terbit = $row['tahun_terbit'];
            $this->stok = $row['stok'];
            return true;
        }
        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                 SET kode_buku=:kode_buku, judul=:judul, pengarang=:pengarang, 
                     penerbit=:penerbit, tahun_terbit=:tahun_terbit, stok=:stok
                 WHERE id=:id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":kode_buku", $this->kode_buku);
        $stmt->bindParam(":judul", $this->judul);
        $stmt->bindParam(":pengarang", $this->pengarang);
        $stmt->bindParam(":penerbit", $this->penerbit);
        $stmt->bindParam(":tahun_terbit", $this->tahun_terbit);
        $stmt->bindParam(":stok", $this->stok);
        $stmt->bindParam(":id", $this->id);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>