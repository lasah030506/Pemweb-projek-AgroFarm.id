<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard | AgroFarm.id</title>

    <link rel="stylesheet" href="../style/dashboard.css?v=<?= time() + 1; ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <aside class="sidebar">
        <h2>🌿 AgroFarm</h2>
        <ul class="sidebar-menu">
            <li><a href="#" id="btnTentang"><i class="fa-solid fa-circle-info"></i> Tentang AgroFarm</a></li>
            <li><a href="#" id="btnHarga"><i class="fa-solid fa-sack-dollar"></i> Harga Pasar</a></li>
            <?php if ($_SESSION['role'] === 'admin'): ?>
            <li><a href="admin.php" id="btnAdminPanelLink"><i class="fa-solid fa-user-gear"></i> Admin Panel</a></li>
            <?php endif; ?>
            <li><a href="auth_process.php?action=logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
        </ul>
    </aside>

    <nav class="navbar--dashboard">
        <h1>Dashboard Pengguna</h1>
        <p>Selamat datang, <?= htmlspecialchars($_SESSION['full_name']); ?> 👋</p>
    </nav>

    <main>
        <h2>Layanan AgroFarm</h2>
        <p>Silakan pilih layanan untuk melanjutkan:</p>

        <div class="services">
            <div class="service-box" id="boxKonsultasi">
                <i class="fa-solid fa-headset"></i>
                <div>
                    <h3>Konsultasi Online</h3>
                    <p>Tanya pakar pertanian.</p>
                </div>
            </div>

            <div class="service-box" id="boxHarga">
                <i class="fa-solid fa-sack-dollar"></i>
                <div>
                    <h3>Harga Pasar</h3>
                    <p>Update harga terbaru.</p>
                </div>
            </div>

            <div class="service-box" id="boxPelatihan">
                <i class="fa-solid fa-chalkboard-user"></i>
                <div>
                    <h3>Pelatihan Petani</h3>
                    <p>Ikuti kelas intensif.</p>
                </div>
            </div>

            <div class="service-box">
                <i class="fa-solid fa-newspaper"></i>
                <div>
                    <h3>Artikel Edukasi</h3>
                    <p>Tips & inovasi tani.</p>
                </div>
            </div>
        </div>

        <section class="harga-section">
            <h2>📈 Data Harga Pasar</h2>
            <div class="harga-actions">
                <?php if ($_SESSION['role'] === 'admin'): ?>
                <a href="admin_commodities.php" class="btn-action btn-add" style="text-decoration:none; display:inline-block;"><i class="fa-solid fa-pen-to-square"></i> Kelola Harga</a>
                <?php endif; ?>
                <button id="btnPrintPDF" class="btn-action btn-print"><i class="fa-solid fa-print"></i> Cetak PDF</button>
            </div>
            <div id="hargaList" class="harga-list">
                <p>Klik menu <strong>"Harga Pasar"</strong> di samping untuk memuat data terbaru.</p>
            </div>
        </section>

        <!-- SECTION ARTIKEL TERBARU -->
        <section class="harga-section" style="margin-top: 40px;">
            <h2><i class="fa-solid fa-newspaper" style="color:#8e44ad;"></i> Berita & Artikel Tani</h2>
            <div class="articles-container" style="display:grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap:25px; margin-top:20px;">
                <?php
                // Fetch 3 latest articles directly here usually better via API but direct PHP is fine for dashboard load
                require_once 'config.php';
                $sqlArt = "SELECT * FROM articles ORDER BY created_at DESC LIMIT 3";
                $resArt = $conn->query($sqlArt);
                
                if ($resArt->num_rows > 0):
                    while($art = $resArt->fetch_assoc()):
                ?>
                <div class="article-card" style="background:#fff; border-radius:16px; overflow:hidden; box-shadow:0 10px 20px rgba(0,0,0,0.05); transition:transform 0.3s ease, box-shadow 0.3s ease; display:flex; flex-direction:column; border:1px solid rgba(0,0,0,0.05);">
                    <div style="height:220px; width:100%; background:#2c3e50; display:flex; align-items:center; justify-content:center; overflow:hidden;">
                        <img src="../<?= $art['image_path'] ? $art['image_path'] : 'assets/sapipadi.png' ?>" style="width:100%; height:100%; object-fit:contain; transition:transform 0.5s ease;" alt="Artikel">
                    </div>
                    <div style="padding:20px; flex-grow:1; display:flex; flex-direction:column;">
                        <h3 style="font-size:1.15rem; margin-bottom:8px; color:#2c3e50; font-weight:700; line-height:1.4;"><?= htmlspecialchars($art['title']) ?></h3>
                        <p style="font-size:0.9rem; color:#7f8c8d; line-height:1.6; margin-bottom:20px; flex-grow:1;"><?= substr(strip_tags($art['content']), 0, 90) ?>...</p>
                        
                        <a href="article_detail.php?id=<?= $art['id'] ?>" style="display:inline-block; text-align:center; background:linear-gradient(135deg, #2ecc71, #27ae60); color:white; padding:12px 20px; border-radius:50px; text-decoration:none; font-weight:600; font-size:0.9rem; box-shadow:0 4px 10px rgba(46, 204, 113, 0.3); transition:all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 15px rgba(46, 204, 113, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(46, 204, 113, 0.3)'">
                            Baca Selengkapnya <i class="fa-solid fa-arrow-right" style="margin-left:5px;"></i>
                        </a>
                    </div>
                </div>
                <?php 
                    endwhile;
                else: 
                ?>
                <p style="text-align:center; width:100%; grid-column:1/-1; color:#999;">Belum ada artikel terbaru.</p>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <div id="popup-info" class="popup">
        <div class="popup-content">
            <span class="close">&times;</span>
            <h2>Tentang AgroFarm</h2>
            <p>AgroFarm.id adalah platform digital untuk mendukung petani dan peternak Indonesia dalam menghadapi era pertanian modern.</p>
        </div>
    </div>

    <div id="popup-konsultasi" class="popup">
        <div class="popup-content">
            <span class="close">&times;</span>
            <h2>Konsultasi Online</h2>
            <p>Hubungi tim ahli kami untuk mendapatkan saran terbaik. Fitur sedang dikembangkan.</p>
        </div>
    </div>

    <div id="toast" class="toast">Klik untuk detail layanan!</div>

    <!-- jsPDF & AutoTable for PDF Generation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>

    <script src="../scripts/dashboard.js?v=<?= time(); ?>"></script>
</body>
</html>