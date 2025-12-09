<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Home - AgroFarm</title>
  <link rel="stylesheet" href="../style/style.css?v=<?= time(); ?>">
</head>
<body>

  <header class="navbar" role="banner">
    <div class="container">
      <a class="brand" href="index.php">
        <img src="../assets/logo.png" alt="AgroFarm Logo">
        <span class="title">AgroFarm.id</span>
      </a>
      <nav class="nav-menu">
        <a href="index.php">Home</a>
        <a href="register.php">Register</a>
        <a href="user_login.php">Login User</a>
        <a href="dashboard.php" class="btn-nav-cta">Dashboard</a>
      </nav>
    </div>
  </header>

  <main role="main">
    <section class="hero">
      <div class="hero-content">
        <h1>Revolusi Pertanian Digital Masa Depan</h1>
        <p>Platform terintegrasi untuk petani modern. Pantau harga pasar, konsultasi ahli, dan tingkatkan hasil panen Anda.</p>
        <div class="hero-buttons">
          <a href="register.php" class="btn btn-primary">Mulai Sekarang</a>
          <a href="admin_login.php" class="btn btn-outline">Login Admin</a>
        </div>
      </div>
    </section>
  </main>

  <footer class="site-footer">
    <div class="container">
      <p>&copy; 2025 AgroFarm Indonesia. All Rights Reserved.</p>
      <div class="footer-info">
        <p>Privacy Policy</p>
        <p>Terms of Service</p>
        <p>Contact Us</p>
      </div>
    </div>
  </footer>

  <script src="../scripts/script.js"></script>
  <script src="../scripts/toast.js"></script>

</body> 
</html>