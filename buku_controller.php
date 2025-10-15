<?php
include_once '../config/database.php';
include_once '../models/Buku.php';

$database = new Database();
$db = $database->getConnection();
$buku = new Buku($db);

$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch($action) {
    case 'create':
        if($_POST) {
            $buku->kode_buku = $_POST['kode_buku'];
            $buku->judul = $_POST['judul'];
            $buku->pengarang = $_POST['pengarang'];
            $buku->penerbit = $_POST['penerbit'];
            $buku->tahun_terbit = $_POST['tahun_terbit'];
            $buku->stok = $_POST['stok'];
            
            if($buku->create()) {
                echo json_encode(array("message" => "Buku berhasil ditambahkan."));
            } else {
                echo json_encode(array("message" => "Gagal menambahkan buku."));
            }
        }
        break;
        
    case 'read':
        $stmt = $buku->readAll();
        $num = $stmt->rowCount();
        $buku_arr = array();
        
        if($num > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($buku_arr, $row);
            }
        }
        echo json_encode($buku_arr);
        break;
        
    case 'read_one':
        $buku->id = $_GET['id'];
        $buku->readOne();
        
        $buku_arr = array(
            "id" => $buku->id,
            "kode_buku" => $buku->kode_buku,
            "judul" => $buku->judul,
            "pengarang" => $buku->pengarang,
            "penerbit" => $buku->penerbit,
            "tahun_terbit" => $buku->tahun_terbit,
            "stok" => $buku->stok
        );
        echo json_encode($buku_arr);
        break;
        
    case 'update':
        if($_POST) {
            $buku->id = $_POST['id'];
            $buku->kode_buku = $_POST['kode_buku'];
            $buku->judul = $_POST['judul'];
            $buku->pengarang = $_POST['pengarang'];
            $buku->penerbit = $_POST['penerbit'];
            $buku->tahun_terbit = $_POST['tahun_terbit'];
            $buku->stok = $_POST['stok'];
            
            if($buku->update()) {
                echo json_encode(array("message" => "Buku berhasil diupdate."));
            } else {
                echo json_encode(array("message" => "Gagal mengupdate buku."));
            }
        }
        break;
        
    case 'delete':
        if($_POST) {
            $buku->id = $_POST['id'];
            
            if($buku->delete()) {
                echo json_encode(array("message" => "Buku berhasil dihapus."));
            } else {
                echo json_encode(array("message" => "Gagal menghapus buku."));
            }
        }
        break;
}
?>