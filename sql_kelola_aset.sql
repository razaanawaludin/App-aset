-- Tabel untuk lokasi aset
CREATE TABLE IF NOT EXISTS lokasi_aset (
    IdLokasi INT AUTO_INCREMENT PRIMARY KEY,
    KodeLokasi VARCHAR(20) NOT NULL,
    NamaLokasi VARCHAR(100) NOT NULL,
    Deskripsi TEXT
);

-- Tabel untuk kelola aset
CREATE TABLE IF NOT EXISTS kelola_aset (
    IdAset INT AUTO_INCREMENT PRIMARY KEY,
    KodeAset VARCHAR(30) NOT NULL,
    NamaAset VARCHAR(150) NOT NULL,
    Kategori VARCHAR(100) NOT NULL,
    Lokasi VARCHAR(100) NOT NULL,
    FotoAset VARCHAR(255) DEFAULT NULL
);

-- Tabel untuk kategori aset
CREATE TABLE IF NOT EXISTS kategori_aset (
    IdKategori INT AUTO_INCREMENT PRIMARY KEY,
    KodeKategori VARCHAR(20) NOT NULL,
    NamaKategori VARCHAR(100) NOT NULL,
    Deskripsi TEXT
);
