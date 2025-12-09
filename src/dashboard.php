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