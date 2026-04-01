-- Tabel BAST (header dokumen)
CREATE TABLE IF NOT EXISTS bast (
    IdBast INT AUTO_INCREMENT PRIMARY KEY,
    NoBast VARCHAR(50) NOT NULL,
    IdPenyerah INT NOT NULL,
    IdPenerima INT NOT NULL,
    Keterangan TEXT,
    Status ENUM('menunggu','selesai (approved)') NOT NULL DEFAULT 'menunggu',
    ApproveSerah TINYINT(1) NOT NULL DEFAULT 0,
    ApproveTerima TINYINT(1) NOT NULL DEFAULT 0,
    Create_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel BAST Detail (daftar barang)
CREATE TABLE IF NOT EXISTS bast_detail (
    IdBastDetail INT AUTO_INCREMENT PRIMARY KEY,
    IdBast INT NOT NULL,
    IdAset INT NOT NULL,
    FOREIGN KEY (IdBast) REFERENCES bast(IdBast) ON DELETE CASCADE
);
