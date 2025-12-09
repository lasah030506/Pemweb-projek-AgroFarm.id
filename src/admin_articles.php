<?php
session_start();
require_once 'config.php';

// Security Check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: dashboard.php");
    exit();
}

$sql = "SELECT * FROM articles ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Artikel - AgroFarm Admin</title>
    <!-- Import Same Font as Dashboard -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #2ecc71;
            --dark: #2c3e50;
            --glass-bg: rgba(255, 255, 255, 0.85);
            --glass-border: rgba(255, 255, 255, 0.5);
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: url('https://images.unsplash.com/photo-1625246333195-78d9c38ad449?q=80&w=2940&auto=format&fit=crop') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            padding: 40px 20px;
            color: #333;
        }

        /* Overlay */
        body::before {
            content: '';
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(236, 240, 241, 0.7);
            backdrop-filter: blur(5px);
            z-index: -1;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: var(--glass-bg);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            border: 1px solid var(--glass-border);
            backdrop-filter: blur(10px);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            border-bottom: 2px solid rgba(0,0,0,0.05);
            padding-bottom: 20px;
        }

        .header h1 {
            font-size: 2rem;
            color: var(--dark);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-back { background: #95a5a6; color: white; }
        .btn-add { background: var(--primary); color: white; box-shadow: 0 4px 15px rgba(46, 204, 113, 0.4); }
        .btn-add:hover { transform: translateY(-3px); }

        /* Article Grid */
        .article-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
        }

        .article-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: 0.3s;
            border: 1px solid #eee;
            position: relative;
        }

        .article-card:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.1); }

        .article-img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .article-content { padding: 20px; }
        .article-title { font-size: 1.2rem; font-weight: 700; margin-bottom: 10px; color: var(--dark); }
        .article-snippet { font-size: 0.9rem; color: #7f8c8d; line-height: 1.5; margin-bottom: 20px; }
        
        .article-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #f0f0f0;
            padding-top: 15px;
        }

        .btn-sm { padding: 8px 15px; font-size: 0.85rem; border-radius: 8px; }
        .btn-edit { background: #f39c12; color: white; }
        .btn-del { background: #e74c3c; color: white; }

        /* Modal Styles */
        .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); backdrop-filter: blur(5px); }
        .modal-content { 
            background: white; 
            margin: 5% auto; 
            padding: 30px; 
            width: 90%; 
            max-width: 600px; 
            border-radius: 15px; 
            animation: slideDown 0.4s;
            position: relative;
        }
        @keyframes slideDown { from { transform: translateY(-50px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: var(--dark); }
        .form-group input, .form-group textarea { 
            width: 100%; padding: 12px; 
            border: 1px solid #ddd; border-radius: 8px; 
            font-family: inherit; font-size: 1rem;
        }
        .form-group textarea { height: 150px; resize: vertical; }

    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1><i class="fa-solid fa-newspaper" style="color:#2ecc71;"></i> Kelola Artikel Edukasi</h1>
        <div style="display:flex; gap:10px;">
            <a href="admin.php" class="btn btn-back"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
            <button onclick="openModal()" class="btn btn-add"><i class="fa-solid fa-plus"></i> Tulis Artikel</button>
        </div>
    </div>

    <!-- Grid Layout for Articles -->
    <div class="article-grid">
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="article-card">
                    <?php if($row['image_path']): ?>
                        <img src="../<?= $row['image_path'] ?>" class="article-img" alt="Blog Image">
                    <?php else: ?>
                        <div style="height:180px; background:#eee; display:flex; align-items:center; justify-content:center; color:#aaa;">No Image</div>
                    <?php endif; ?>
                    
                    <div class="article-content">
                        <div class="article-title"><?= htmlspecialchars($row['title']) ?></div>
                        <div class="article-snippet">
                            <?= substr(strip_tags($row['content']), 0, 100) ?>...
                        </div>
                        <div class="article-actions">
                            <span style="font-size:0.8rem; color:#aaa;"><i class="fa-regular fa-clock"></i> <?= date('d M Y', strtotime($row['created_at'])) ?></span>
                            <div>
                                <button class="btn btn-sm btn-edit" onclick='editArticle(<?= json_encode($row) ?>)'>Edit</button>
                                <a href="articles_process.php?action=delete&id=<?= $row['id'] ?>" class="btn btn-sm btn-del" onclick="return confirm('Hapus artikel ini?')">Hapus</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align:center; grid-column: 1/-1; padding: 40px; color:#777;">Belum ada artikel. Yuk tulis sesuatu untuk petani!</p>
        <?php endif; ?>
    </div>
</div>

<!-- FORM MODAL -->
<div id="articleModal" class="modal">
    <div class="modal-content">
        <h2 id="modalTitle" style="margin-bottom:20px; color:var(--dark);">Tulis Artikel Baru</h2>
        <span onclick="closeModal()" style="position:absolute; right:25px; top:25px; cursor:pointer; font-size:1.5rem;">&times;</span>
        
        <form id="articleForm" action="articles_process.php?action=create" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" id="editId">
            
            <div class="form-group">
                <label>Judul Artikel</label>
                <input type="text" name="title" id="inputTitle" required placeholder="Contoh: Cara Mengatasi Hama Wereng">
            </div>

            <div class="form-group">
                <label>Isi Konten</label>
                <textarea name="content" id="inputContent" required placeholder="Tulis pengetahuanmu di sini..."></textarea>
            </div>

            <div class="form-group">
                <label>Gambar Sampul</label>
                <input type="file" name="image" accept="image/*">
            </div>

            <div style="text-align:right;">
                <button type="button" onclick="closeModal()" class="btn btn-back" style="margin-right:10px;">Batal</button>
                <button type="submit" class="btn btn-add" id="btnSubmit">Terbitkan</button>
            </div>
        </form>
    </div>
</div>

<script>
    const modal = document.getElementById("articleModal");
    const form = document.getElementById("articleForm");
    
    function openModal() {
        modal.style.display = "block";
        document.getElementById("modalTitle").innerText = "Tulis Artikel Baru";
        form.action = "articles_process.php?action=create";
        form.reset();
    }

    function editArticle(data) {
        modal.style.display = "block";
        document.getElementById("modalTitle").innerText = "Edit Artikel";
        form.action = "articles_process.php?action=update";
        
        document.getElementById("editId").value = data.id;
        document.getElementById("inputTitle").value = data.title;
        document.getElementById("inputContent").value = data.content;
    }

    function closeModal() {
        modal.style.display = "none";
    }

    window.onclick = function(e) {
        if(e.target == modal) closeModal();
    }
</script>

</body>
</html>
