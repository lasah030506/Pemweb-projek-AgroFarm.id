<?php
session_start();
require_once 'config.php';

// Cek Admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: dashboard.php");
    exit();
}

// Ambil Data
$sql = "SELECT * FROM commodities ORDER BY id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Komoditas - Admin AgroFarm</title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .admin-container { padding: 30px; max-width: 1100px; margin: 0 auto; font-family: 'Segoe UI', sans-serif; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .header h1 { color: #2c3e50; font-size: 1.8rem; }
        
        .btn { padding: 8px 15px; border-radius: 6px; text-decoration: none; color: #fff; display: inline-block; cursor: pointer; border: none; font-size: 0.95rem; }
        .btn-add { background-color: #27ae60; }
        .btn-add:hover { background-color: #219150; }
        .btn-edit { background-color: #f39c12; margin-right: 5px; }
        .btn-delete { background-color: #c0392b; }
        .btn-back { background-color: #7f8c8d; }

        table { width: 100%; border-collapse: collapse; margin-top: 15px; background: #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #f8f9fa; color: #555; font-weight: 600; text-transform: uppercase; font-size: 0.85rem; }
        tr:hover { background-color: #fafafa; }
        
        .img-thumb { width: 50px; hieght: 50px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd; }
        
        /* Modal Styles */
        .modal { display: none; position: fixed; z-index: 999; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.5); }
        .modal-content { background-color: #fefefe; margin: 5% auto; padding: 25px; border: 1px solid #888; width: 90%; max-width: 500px; border-radius: 10px; position: relative; animation: slideDown 0.3s; }
        @keyframes slideDown { from { top: -50px; opacity: 0; } to { top: 0; opacity: 1; } }
        .close { color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer; }
        .close:hover { color: #000; }
        
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 600; }
        .form-group input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
        
        .empty-state { text-align: center; padding: 50px; color: #aaa; }
    </style>
</head>
<body>

<div class="admin-container">
    <div class="header">
        <h1><i class="fa-solid fa-carrot"></i> Kelola Komoditas</h1>
        <div>
            <a href="admin.php" class="btn btn-back"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
            <button id="btnAdd" class="btn btn-add"><i class="fa-solid fa-plus"></i> Tambah Komoditas</button>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Gambar</th>
                <th>Nama Komoditas</th>
                <th>Harga (Rp)</th>
                <th>Satuan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php $no = 1; while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td>
                        <?php if($row['image_path']): ?>
                            <img src="../<?= $row['image_path'] ?>" class="img-thumb" alt="Img">
                        <?php else: ?>
                            <span style="color:#ccc; font-size:0.8rem;">No Image</span>
                        <?php endif; ?>
                    </td>
                    <td><strong><?= htmlspecialchars($row['name']) ?></strong></td>
                    <td>Rp <?= number_format($row['price'], 0, ',', '.') ?></td>
                    <td>/ <?= htmlspecialchars($row['unit']) ?></td>
                    <td>
                        <button class="btn btn-edit" 
                            data-id="<?= $row['id'] ?>" 
                            data-name="<?= htmlspecialchars($row['name']) ?>" 
                            data-price="<?= htmlspecialchars($row['price']) ?>"
                            data-unit="<?= htmlspecialchars($row['unit']) ?>"
                            onclick="openEditModal(this)">
                            <i class="fa-solid fa-pen"></i>
                        </button>
                        <a href="commodities_process.php?action=delete&id=<?= $row['id'] ?>" 
                           class="btn btn-delete" 
                           onclick="return confirm('Yakin ingin menghapus komoditas ini?');">
                           <i class="fa-solid fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="empty-state">Belum ada data komoditas. Silakan tambah baru.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- MODAL FORM -->
<div id="modalForm" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2 id="modalTitle">Tambah Komoditas</h2>
        
        <form id="formCommodity" action="commodities_process.php?action=create" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" id="editId">
            
            <div class="form-group">
                <label>Nama Komoditas</label>
                <input type="text" name="name" id="inputName" required placeholder="Contoh: Beras Premium">
            </div>
            
            <div class="form-group">
                <label>Harga (Rp)</label>
                <input type="number" name="price" id="inputPrice" required placeholder="Contoh: 15000">
            </div>

            <div class="form-group">
                <label>Satuan</label>
                <input type="text" name="unit" id="inputUnit" required placeholder="Contoh: kg, liter, ikat">
            </div>
            
            <div class="form-group">
                <label>Gambar (Opsional)</label>
                <input type="file" name="image" accept="image/*">
                <small style="color:#777;">Format: JPG, PNG, WEBP (Max 2MB)</small>
            </div>
            
            <div style="text-align: right; margin-top: 20px;">
                <button type="submit" class="btn btn-add" id="btnSubmit">Simpan Data</button>
            </div>
        </form>
    </div>
</div>

<script>
    const modal = document.getElementById("modalForm");
    const form = document.getElementById("formCommodity");
    const modalTitle = document.getElementById("modalTitle");
    const btnSubmit = document.getElementById("btnSubmit");

    // Buka Modal Tambah
    document.getElementById("btnAdd").onclick = function() {
        modal.style.display = "block";
        modalTitle.innerText = "Tambah Komoditas Baru";
        form.action = "commodities_process.php?action=create";
        form.reset();
        btnSubmit.classList.remove("btn-edit");
        btnSubmit.classList.add("btn-add");
        btnSubmit.innerText = "Simpan Data";
    }

    // Buka Modal Edit
    function openEditModal(elem) {
        modal.style.display = "block";
        modalTitle.innerText = "Edit Komoditas";
        form.action = "commodities_process.php?action=update";
        
        document.getElementById("editId").value = elem.getAttribute("data-id");
        document.getElementById("inputName").value = elem.getAttribute("data-name");
        document.getElementById("inputPrice").value = elem.getAttribute("data-price");
        document.getElementById("inputUnit").value = elem.getAttribute("data-unit");
        
        btnSubmit.classList.remove("btn-add");
        btnSubmit.classList.add("btn-edit");
        btnSubmit.innerText = "Update Data";
    }

    // Tutup Modal
    function closeModal() {
        modal.style.display = "none";
    }

    // Klik di luar modal menutup modal
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

</body>
</html>
