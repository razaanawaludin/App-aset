-- Tabel utama penghapusan aset (header dokumen)
CREATE TABLE IF NOT EXISTS penghapusan_aset (
    IdPenghapusan INT AUTO_INCREMENT PRIMARY KEY,
    NoPenghapusan VARCHAR(50) NOT NULL,
    IdPenanggungJawab INT DEFAULT NULL COMMENT 'ID pegawai penanggung jawab',
    AlasanPenghapusan VARCHAR(100) NOT NULL COMMENT 'Rusak Berat, Hilang, Dijual, Hibah, Kadaluarsa',
    Keterangan TEXT DEFAULT NULL,
    BeritaAcara TEXT DEFAULT NULL,
    Status VARCHAR(30) NOT NULL DEFAULT 'draft' COMMENT 'draft, selesai',
    Create_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel detail aset yang dihapus
CREATE TABLE IF NOT EXISTS penghapusan_detail (
    IdDetail INT AUTO_INCREMENT PRIMARY KEY,
    IdPenghapusan INT NOT NULL,
    IdAset INT NOT NULL,
    FOREIGN KEY (IdPenghapusan) REFERENCES penghapusan_aset(IdPenghapusan) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
