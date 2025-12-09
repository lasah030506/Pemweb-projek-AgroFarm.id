<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard | AgroFarm.id</title>

    <link rel="stylesheet" href="../style/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <aside class="sidebar">
        <h2>🌿 AgroFarm</h2>
        <ul class="sidebar-menu">
            <li><a href="#" id="btnTentang"><i class="fa-solid fa-circle-info"></i> Tentang AgroFarm</a></li>
            <li><a href="#" id="btnHarga"><i class="fa-solid fa-sack-dollar"></i> Harga Pasar</a></li>
            <li><a href="#" id="btnAdminPanel"><i class="fa-solid fa-user-gear"></i> Admin Panel</a></li>
            <li><a href="#"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
        </ul>
    </aside>

    <nav class="navbar--dashboard">
        <h1>Dashboard Pengguna</h1>
        <p>Selamat datang 👋</p>
    </nav>

    <main>
        <h2>Layanan AgroFarm</h2>
        <p>Silakan pilih layanan untuk melanjutkan:</p>

        <div class="services">
            <div class="service-box" id="boxKonsultasi">
                <i class="fa-solid fa-headset"></i>
                <h3>Konsultasi Online</h3>
                <p>Berkonsultasilah dengan pakar pertanian kami secara langsung.</p>
            </div>

            <div class="service-box" id="boxHarga">
                <i class="fa-solid fa-sack-dollar"></i>
                <h3>Harga Pasar Harian</h3>
                <p>Lihat harga terbaru hasil pertanian di wilayahmu.</p>
            </div>

            <div class="service-box" id="boxPelatihan">
                <i class="fa-solid fa-chalkboard-user"></i>
                <h3>Pelatihan Petani</h3>
                <p>Ikuti program pelatihan untuk meningkatkan hasil pertanian.</p>
            </div>

            <div class="service-box">
                <i class="fa-solid fa-newspaper"></i>
                <h3>Artikel Edukasi</h3>
                <p>Pelajari tips dan inovasi terbaru di dunia pertanian.</p>
            </div>
        </div>

        <section class="harga-section">
            <h2>📈 Data Harga Pasar (Fetch API)</h2>
            <div class="harga-actions">
                <button id="btnTambahHarga" class="btn-action btn-add">Tambah Harga</button>
                <button id="btnBatalMuat" class="btn-action btn-cancel" style="display:none;">Batal Muat Data</button>
            </div>
            <div id="hargaList" class="harga-list">
                <p>Tekan tombol “Harga Pasar” untuk melihat data.</p>
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

    <script src="../scripts/dashboard.js"></script>
</body>
</html>