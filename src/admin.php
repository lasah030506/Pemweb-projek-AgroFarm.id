<?php
session_start();
require_once 'config.php';

// Cek apakah user sudah login DAN role-nya admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    // Jika mencoba akses langsung, tendang ke login atau dashboard
    header("Location: dashboard.php");
    exit();
}

// Ambil data users untuk ditampilkan
$sql = "SELECT id, full_name, email, role, created_at FROM users";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - AgroFarm</title>
    <link rel="stylesheet" href="../style/style.css">
    <style>
        .admin-container { padding: 20px; max-width: 1000px; margin: 0 auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #27ae60; color: white; }
        tr:hover { background-color: #f1f1f1; }
        .badge { padding: 5px 10px; border-radius: 15px; font-size: 0.8rem; }
        .badge-admin { background-color: #e74c3c; color: white; }
        .badge-user { background-color: #3498db; color: white; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .btn-back { background: #555; text-decoration: none; color: white; padding: 10px 20px; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="header">
            <h1><i class="fa-solid fa-users-gear"></i> Admin Panel</h1>
            <div>
                <a href="admin_commodities.php" class="btn" style="background:#f39c12; margin-right:5px;"><i class="fa-solid fa-carrot"></i> Kelola Komoditas</a>
                <a href="admin_articles.php" class="btn" style="background:#8e44ad; color:white; padding:10px 20px; text-decoration:none; border-radius:5px; margin-right:10px;"><i class="fa-solid fa-newspaper"></i> Kelola Artikel</a>
                <a href="dashboard.php" class="btn-back">Kembali ke Dashboard</a>
                <a href="auth_process.php?action=logout" class="btn" style="background:#c0392b; margin-left:10px;">Logout</a>
            </div>
        </div>

        <p>Halo, <strong><?= htmlspecialchars($_SESSION['full_name']) ?></strong>. Berikut adalah daftar pengguna sistem:</p>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Terdaftar Sejak</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['full_name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td>
                        <span class="badge <?= $row['role'] == 'admin' ? 'badge-admin' : 'badge-user' ?>">
                            <?= ucfirst($row['role']) ?>
                        </span>
                    </td>
                    <td><?= $row['created_at'] ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
