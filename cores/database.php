<?php
function connectDB() {
    $host = 'localhost';
    $db   = 'db_asset';
    $user = 'root'; // Sesuaikan username database
    $pass = '';     // Sesuaikan password database
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Menampilkan error
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Hasil berupa array asosiatif
        PDO::ATTR_EMULATE_PREPARES   => false,                  // Memastikan prepared statement aman
    ];

    try {
        return new PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e) {
        die("Maaf koneksi gagal: " . $e->getMessage());
    }
}

// --- FUNGSI INSERT ---
function insertData($koneksiku, $table, $data) {
    // Mengambil nama kolom dari key array
    $columns = implode(", ", array_keys($data));
    
    // Membuat placeholder (contoh: :nama, :email)
    $placeholders = ":" . implode(", :", array_keys($data));
    
    $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
    
    $stmt = $koneksiku->prepare($sql);
    return $stmt->execute($data); // Mengembalikan true jika berhasil
}

// --- FUNGSI SELECT ---
function selectData($koneksiku, $table, $conditions = []) {
    $sql = "SELECT * FROM $table";
    
    // Jika ada kondisi WHERE
    if (!empty($conditions)) {
        $whereClauses = [];
        foreach ($conditions as $key => $value) {
            $whereClauses[] = "$key = :$key";
        }
        $sql .= " WHERE " . implode(" AND ", $whereClauses);
    }
    
    $stmt = $koneksiku->prepare($sql);
    $stmt->execute($conditions);
    
    return $stmt->fetchAll(); // Mengembalikan data dalam bentuk array
}

// --- FUNGSI UPDATE ---
function updateData($koneksiku, $table, $data, $conditions) {
    $setClauses = [];
    $executeData = [];
    
    // Setup bagian SET
    foreach ($data as $key => $value) {
        $setClauses[] = "$key = :set_$key";
        $executeData["set_$key"] = $value;
    }
    
    // Setup bagian WHERE
    $whereClauses = [];
    foreach ($conditions as $key => $value) {
        $whereClauses[] = "$key = :cond_$key";
        $executeData["cond_$key"] = $value;
    }
    
    $sql = "UPDATE $table SET " . implode(", ", $setClauses) . " WHERE " . implode(" AND ", $whereClauses);
    
    $stmt = $koneksiku->prepare($sql);
    return $stmt->execute($executeData); // Mengembalikan true jika berhasil
}

// --- FUNGSI DELETE ---
function deleteData($koneksiku, $table, $conditions) {
    $whereClauses = [];
    
    foreach ($conditions as $key => $value) {
        $whereClauses[] = "$key = :$key";
    }
    
    $sql = "DELETE FROM $table WHERE " . implode(" AND ", $whereClauses);
    
    $stmt = $koneksiku->prepare($sql);
    return $stmt->execute($conditions); // Mengembalikan true jika berhasil
}
?>