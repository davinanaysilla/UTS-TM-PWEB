<?php
include_once '../config/database.php';
include_once '../models/Petugas.php';

$database = new Database();
$db = $database->getConnection();
$petugas = new Petugas($db);

$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch($action) {
    case 'create':
        if($_POST) {
            $petugas->kode_petugas = $_POST['kode_petugas'];
            $petugas->nama = $_POST['nama'];
            $petugas->email = $_POST['email'];
            $petugas->no_telp = $_POST['no_telp'];
            
            if($petugas->create()) {
                echo json_encode(array("message" => "Petugas berhasil ditambahkan."));
            } else {
                echo json_encode(array("message" => "Gagal menambahkan petugas."));
            }
        }
        break;
        
    case 'read':
        $stmt = $petugas->readAll();
        $num = $stmt->rowCount();
        $petugas_arr = array();
        
        if($num > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($petugas_arr, $row);
            }
        }
        echo json_encode($petugas_arr);
        break;
        
    case 'read_one':
        $petugas->id = $_GET['id'];
        $petugas->readOne();
        
        $petugas_arr = array(
            "id" => $petugas->id,
            "kode_petugas" => $petugas->kode_petugas,
            "nama" => $petugas->nama,
            "email" => $petugas->email,
            "no_telp" => $petugas->no_telp
        );
        echo json_encode($petugas_arr);
        break;
        
    case 'update':
        if($_POST) {
            $petugas->id = $_POST['id'];
            $petugas->kode_petugas = $_POST['kode_petugas'];
            $petugas->nama = $_POST['nama'];
            $petugas->email = $_POST['email'];
            $petugas->no_telp = $_POST['no_telp'];
            
            if($petugas->update()) {
                echo json_encode(array("message" => "Petugas berhasil diupdate."));
            } else {
                echo json_encode(array("message" => "Gagal mengupdate petugas."));
            }
        }
        break;
        
    case 'delete':
        if($_POST) {
            $petugas->id = $_POST['id'];
            
            if($petugas->delete()) {
                echo json_encode(array("message" => "Petugas berhasil dihapus."));
            } else {
                echo json_encode(array("message" => "Gagal menghapus petugas."));
            }
        }
        break;
}
?>