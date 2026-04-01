CREATE TABLE IF NOT EXISTS perbaruan_aset (
    IdPerbaruan INT AUTO_INCREMENT PRIMARY KEY,
    IdAset INT NOT NULL,
    TanggalMulai DATE NOT NULL,
    TanggalSelesai DATE DEFAULT NULL,
    JenisPerbaruan VARCHAR(100) NOT NULL COMMENT 'Perbaikan, Perawatan, Upgrade, Kalibrasi',
    Deskripsi TEXT DEFAULT NULL,
    Teknisi VARCHAR(150) DEFAULT NULL,
    Biaya DECIMAL(15,2) DEFAULT 0,
    Status VARCHAR(30) NOT NULL DEFAULT 'proses' COMMENT 'proses, selesai, dibatalkan',
    Catatan TEXT DEFAULT NULL,
    TanggalDibuat TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
