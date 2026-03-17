CREATE TABLE IF NOT EXISTS kategori_aset (
    IdKategori INT AUTO_INCREMENT PRIMARY KEY,
    KodeKategori VARCHAR(20) NOT NULL,
    NamaKategori VARCHAR(100) NOT NULL,
    Deskripsi TEXT
);
