<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Login Administrator - AgroFarm</title>
  <link rel="stylesheet" href="../style/style.css">
</head>
<body class="form-page">

  <div class="form-box">
    <h2 style="color: #86c69c;"><i class="fa-solid fa-user-shield"></i> Admin Login</h2>
    
    <form action="auth_process.php?action=login" method="POST"> 
      <input type="email" name="email" placeholder="Email Admin" required aria-label="Email Admin">
      <input type="password" name="password" placeholder="Password Admin" required aria-label="Password Admin">
      <button class="btn" type="submit" style="background: #e74c3c;">Login Admin</button>
    </form>
    
    <p style="margin-top: 15px;"><small>Hanya untuk pengguna terdaftar (Administrator).</small></p>
  </div>

</body>
</html>