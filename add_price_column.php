<?php
require_once 'src/config.php';

// Add price column if not exists
$sql = "ALTER TABLE commodities ADD COLUMN price DECIMAL(10,2) DEFAULT 0 AFTER unit";

if ($conn->query($sql) === TRUE) {
    echo "<h1>Berhasil!</h1>";
    echo "<p>Kolom 'price' berhasil ditambahkan ke tabel 'commodities'.</p>";
} else {
    echo "<h1>Info / Error</h1>";
    echo "<p>" . $conn->error . "</p>";
    echo "<p>Kemungkinan kolom sudah ada.</p>";
}
?>
