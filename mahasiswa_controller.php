<?php
include_once '../config/database.php';
include_once '../models/Mahasiswa.php';

$database = new Database();
$db = $database->getConnection();
$mahasiswa = new Mahasiswa($db);

$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch($action) {
    case 'create':
        if($_POST) {
            $mahasiswa->nim = $_POST['nim'];
            $mahasiswa->nama = $_POST['nama'];
            $mahasiswa->jurusan = $_POST['jurusan'];
            $mahasiswa->semester = $_POST['semester'];
            $mahasiswa->no_telp = $_POST['no_telp'];
            $mahasiswa ->created_at = $_POST['created_at'];

            
            if($mahasiswa->create()) {
                echo json_encode(array("message" => "Mahasiswa berhasil ditambahkan."));
            } else {
                echo json_encode(array("message" => "Gagal menambahkan mahasiswa."));
            }
        }
        break;
        
    case 'read':
        $stmt = $mahasiswa->readAll();
        $num = $stmt->rowCount();
        $mahasiswa_arr = array();
        
        if($num > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($mahasiswa_arr, $row);
            }
        }
        echo json_encode($mahasiswa_arr);
        break;
        
    case 'read_one':
        $mahasiswa->id = $_GET['id'];
        $mahasiswa->readOne();
        
        $mahasiswa_arr = array(
            "id" => $mahasiswa->id,
            "nim" => $mahasiswa->nim,
            "nama" => $mahasiswa->nama,
            "jurusan" => $mahasiswa->jurusan,
            "semester" => $mahasiswa->semester,
            "no_telp" => $mahasiswa->no_telp
        );
        echo json_encode($mahasiswa_arr);
        break;
        
    case 'update':
        if($_POST) {
            $mahasiswa->id = $_POST['id'];
            $mahasiswa->nim = $_POST['nim'];
            $mahasiswa->nama = $_POST['nama'];
            $mahasiswa->jurusan = $_POST['jurusan'];
            $mahasiswa->semester = $_POST['semester'];
            $mahasiswa->no_telp = $_POST['no_telp'];
            
            if($mahasiswa->update()) {
                echo json_encode(array("message" => "Mahasiswa berhasil diupdate."));
            } else {
                echo json_encode(array("message" => "Gagal mengupdate mahasiswa."));
            }
        }
        break;
        
    case 'delete':
        if($_POST) {
            $mahasiswa->id = $_POST['id'];
            
            if($mahasiswa->delete()) {
                echo json_encode(array("message" => "Mahasiswa berhasil dihapus."));
            } else {
                echo json_encode(array("message" => "Gagal menghapus mahasiswa."));
            }
        }
        break;
}
?>