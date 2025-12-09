<?php
session_start();
require_once 'config.php';

// Cek akses admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Akses ditolak! Anda bukan admin.");
}

$action = $_GET['action'] ?? '';
$uploadDir = '../assets/articles/';

if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// --- CREATE ARTICLE ---
if ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $imagePath = '';

    // Handle Image Upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $fileName = time() . '_art_' . basename($_FILES['image']['name']);
        $targetFile = $uploadDir . $fileName;
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        if (in_array($fileType, ['jpg', 'jpeg', 'png', 'webp'])) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $imagePath = 'assets/articles/' . $fileName;
            }
        }
    }

    $stmt = $conn->prepare("INSERT INTO articles (title, content, image_path) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $content, $imagePath);

    if ($stmt->execute()) {
        header("Location: admin_articles.php?msg=created");
    } else {
        echo "Error: " . $conn->error;
    }
}

// --- UPDATE ARTICLE ---
elseif ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    
    // Cek gambar baru
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $fileName = time() . '_art_' . basename($_FILES['image']['name']);
        $targetFile = $uploadDir . $fileName;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $newImagePath = 'assets/articles/' . $fileName;
            $stmt = $conn->prepare("UPDATE articles SET title=?, content=?, image_path=? WHERE id=?");
            $stmt->bind_param("sssi", $title, $content, $newImagePath, $id);
        }
    } else {
        $stmt = $conn->prepare("UPDATE articles SET title=?, content=? WHERE id=?");
        $stmt->bind_param("ssi", $title, $content, $id);
    }

    if ($stmt->execute()) {
        header("Location: admin_articles.php?msg=updated");
    } else {
        echo "Error: " . $conn->error;
    }
}

// --- DELETE ARTICLE ---
elseif ($action === 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM articles WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        header("Location: admin_articles.php?msg=deleted");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
