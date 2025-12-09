<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Login Pengguna - AgroFarm</title>
  <link rel="stylesheet" href="../style/style.css">
</head>
<body class="form-page">

  <div class="form-box">
    <h2>Login Pengguna</h2>
    <form action="dashboard.php" method="POST"> <input type="email" placeholder="Email Pengguna" required aria-label="Email Pengguna">
      <input type="password" placeholder="Password" required aria-label="Password">
      <button class="btn" type="submit">Login</button>
    </form>
    <p style="margin:12px 0;">atau lanjutkan dengan</p>
    <button class="btn" style="background:#fff; color:#111;">Google</button>
    <p style="margin-top: 15px;"><small>Belum punya akun? <a href="register.php" style="color: #86c69c; text-decoration: none; font-weight: bold;">Daftar di sini</a></small></p>
  </div>

</body>
</html>