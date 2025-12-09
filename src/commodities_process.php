<?php
session_start();
require_once 'config.php';

// Cek akses admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Akses ditolak!");
}

$action = $_GET['action'] ?? '';

// --- FOLDER UPLOAD ---
$uploadDir = '../assets/uploads/';
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// --- CREATE ---
if ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price']; 
    $unit = $_POST['unit'];
    $imagePath = '';

    // Handle Upload Gambar
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $fileName = time() . '_' . basename($_FILES['image']['name']);
        $targetFile = $uploadDir . $fileName;
        
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        if (in_array($fileType, ['jpg', 'jpeg', 'png', 'webp'])) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $imagePath = 'assets/uploads/' . $fileName; 
            }
        }
    }

    $stmt = $conn->prepare("INSERT INTO commodities (name, price, unit, image_path) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sdss", $name, $price, $unit, $imagePath); // d for double/decimal
    
    if ($stmt->execute()) {
        header("Location: admin_commodities.php?msg=success_create");
    } else {
        echo "Error: " . $conn->error;
    }
}

// --- UPDATE ---
elseif ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $unit = $_POST['unit'];
    
    // Cek apakah ada gambar baru
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $fileName = time() . '_' . basename($_FILES['image']['name']);
        $targetFile = $uploadDir . $fileName;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $newImagePath = 'assets/uploads/' . $fileName;
            
            $stmt = $conn->prepare("UPDATE commodities SET name=?, price=?, unit=?, image_path=? WHERE id=?");
            $stmt->bind_param("sdssi", $name, $price, $unit, $newImagePath, $id);
        }
    } else {
        // Update tanpa ganti gambar
        $stmt = $conn->prepare("UPDATE commodities SET name=?, price=?, unit=? WHERE id=?");
        $stmt->bind_param("sdsi", $name, $price, $unit, $id);
    }

    if ($stmt->execute()) {
        header("Location: admin_commodities.php?msg=success_update");
    } else {
        echo "Error: " . $conn->error;
    }
}

// --- DELETE ---
elseif ($action === 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Hapus file gambar fisik dulu (opsional)
    // $q = $conn->query("SELECT image_path FROM commodities WHERE id=$id");
    // $row = $q->fetch_assoc();
    // if ($row['image_path']) unlink('../' . $row['image_path']);

    $stmt = $conn->prepare("DELETE FROM commodities WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        header("Location: admin_commodities.php?msg=success_delete");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
