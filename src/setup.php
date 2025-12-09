<?php
// src/setup.php
require_once 'config.php';

// Buat tabel users
$sqlUsers = "CREATE TABLE IF NOT EXISTS users (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sqlUsers) === TRUE) {
    echo "Tabel 'users' berhasil dibuat/diperiksa.<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

// Cek apakah ada admin default?
$checkAdmin = "SELECT * FROM users WHERE email = 'admin@agrofarm.id'";
$result = $conn->query($checkAdmin);

if ($result->num_rows == 0) {
    // Buat akun admin default
    // Email: admin@agrofarm.id
    // Pass: admin123
    $passHash = password_hash('admin123', PASSWORD_DEFAULT);
    $insertAdmin = "INSERT INTO users (name, email, password, role) VALUES ('Administrator', 'admin@agrofarm.id', '$passHash', 'admin')";
    
    if ($conn->query($insertAdmin) === TRUE) {
        echo "Akun Admin default berhasil dibuat (Email: admin@agrofarm.id, Pass: admin123)<br>";
    } else {
        echo "Error creating admin: " . $conn->error . "<br>";
    }
} else {
    echo "Akun Admin sudah ada.<br>";
}

echo "<hr>";
echo "Setup Selesai! Silakan hapus file ini atau kembali ke login.";
?>
