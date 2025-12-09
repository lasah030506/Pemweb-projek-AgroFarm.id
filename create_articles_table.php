<?php
require_once 'src/config.php';

$sql = "CREATE TABLE IF NOT EXISTS articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    image_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "<h1>Berhasil!</h1>";
    echo "<p>Tabel 'articles' berhasil dibuat.</p>";
} else {
    echo "Error creating table: " . $conn->error;
}
?>
