<?php
session_start();
require_once 'config.php';

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM articles WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    echo "Artikel tidak ditemukan.";
    exit();
}

$article = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($article['title']) ?> - AgroFarm</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7f6;
            color: #333;
        }
        .navbar {
            background: #27ae60;
            padding: 15px 30px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar a { color: white; text-decoration: none; font-weight: 600; }
        
        .container {
            max-width: 800px;
            margin: 40px auto;
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }
        
        .article-header { text-align: center; margin-bottom: 30px; }
        .article-title { font-size: 2.5rem; color: #2c3e50; font-weight: 800; margin-bottom: 10px; line-height: 1.2; }
        .article-meta { color: #7f8c8d; font-size: 0.9rem; }
        
        .article-image {
            width: 100%;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .article-content {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #444;
            text-align: justify;
        }
        
        .btn-back {
            display: inline-block;
            margin-top: 40px;
            padding: 10px 25px;
            background: #27ae60;
            color: white;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
        }
        .btn-back:hover { background: #2ecc71; transform: translateY(-3px); box-shadow: 0 5px 15px rgba(46, 204, 113, 0.4); }
    </style>
</head>
<body>

    <nav class="navbar">
        <div style="font-size:1.5rem; font-weight:700;">AgroFarm<span style="color:#f1c40f;">.id</span></div>
        <a href="dashboard.php"><i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard</a>
    </nav>

    <div class="container">
        <div class="article-header">
            <h1 class="article-title"><?= htmlspecialchars($article['title']) ?></h1>
            <div class="article-meta">
                <i class="fa-regular fa-clock"></i> Diposting pada <?= date('d F Y', strtotime($article['created_at'])) ?>
            </div>
        </div>

        <?php if($article['image_path']): ?>
            <img src="../<?= $article['image_path'] ?>" class="article-image" alt="Article Image">
        <?php endif; ?>

        <div class="article-content">
            <?= nl2br(htmlspecialchars($article['content'])) ?>
        </div>

        <div style="text-align:center;">
            <a href="dashboard.php" class="btn-back">Kembali ke Beranda</a>
        </div>
    </div>

</body>
</html>
