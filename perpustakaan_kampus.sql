CREATE TABLE mahasiswa (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nim VARCHAR(20) UNIQUE NOT NULL,
    nama VARCHAR(100) NOT NULL,
    jurusan VARCHAR(50) NOT NULL,
    semester INT NOT NULL,
    no_telp VARCHAR(15),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE buku (
    id INT PRIMARY KEY AUTO_INCREMENT,
    kode_buku VARCHAR(20) UNIQUE NOT NULL,
    judul VARCHAR(200) NOT NULL,
    pengarang VARCHAR(100) NOT NULL,
    penerbit VARCHAR(100) NOT NULL,
    tahun_terbit INT NOT NULL,
    stok INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE petugas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    kode_petugas VARCHAR(20) UNIQUE NOT NULL,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    no_telp VARCHAR(15),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


INSERT INTO mahasiswa (nim, nama, jurusan, semester, no_telp) VALUES
('20210001', 'Ahmad Rizki', 'Teknik Informatika', 3, '081234567890'),
('20210002', 'Siti Aminah', 'Sistem Informasi', 5, '081234567891'),
('20210003', 'Budi Santoso', 'Manajemen', 1, '081234567892');

INSERT INTO buku (kode_buku, judul, pengarang, penerbit, tahun_terbit, stok) VALUES
('B001', 'Pemrograman Web dengan PHP', 'John Doe', 'Informatika', 2023, 5),
('B002', 'Struktur Data dan Algoritma', 'Jane Smith', 'Andi Offset', 2022, 3),
('B003', 'Basis Data MySQL', 'Robert Brown', 'Erlangga', 2021, 7);

INSERT INTO petugas (kode_petugas, nama, email, no_telp) VALUES
('P001', 'Anwar Saiful', 'anwar@kampus.ac.id', '081234567893'),
('P002', 'Maya Sari, S.Kom', 'maya@kampus.ac.id', '081234567894');usersuser_defined_functionsperpustakaanperpustakaanperpustakaanperpustakaan_kampusbukubuku