<?php
session_start();
require_once 'config.php';

$action = $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // --- LOGIN ---
    if ($action === 'login') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                // Login Berhasil
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['role'] = $user['role'];

                // Redirect sesuai role
                if ($user['role'] === 'admin') {
                    header("Location: dashboard.php"); 
                } else {
                    header("Location: dashboard.php");
                }
                exit();
            } else {
                echo "<script>alert('Password salah!'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Email tidak ditemukan!'); window.history.back();</script>";
        }
    }

    // --- REGISTER ---
    elseif ($action === 'register') {
        $full_name = $_POST['name']; // Input name form attribute is still 'name'
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Cek email duplikat
        $cek = $conn->query("SELECT id FROM users WHERE email = '$email'");
        if ($cek->num_rows > 0) {
            echo "<script>alert('Email sudah terdaftar!'); window.history.back();</script>";
            exit();
        }

        $passHash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, 'user')");
        $stmt->bind_param("sss", $full_name, $email, $passHash);

        if ($stmt->execute()) {
            echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location.href='user_login.php';</script>";
        } else {
            echo "Error: " . $conn->error;
        }
    }

} 

// --- LOGOUT ---
elseif ($action === 'logout') {
    session_destroy();
    header("Location: index.php"); // Kembali ke landing page
    exit();
}
?>
