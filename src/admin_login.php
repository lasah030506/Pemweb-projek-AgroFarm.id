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
    
    <form action="admin.php" method="POST"> 
      <input type="text" placeholder="Username/ID Admin" required aria-label="Username/ID Admin">
      <input type="password" placeholder="Password Admin" required aria-label="Password Admin">
      <button class="btn" type="submit" style="background: #e74c3c;">Login Admin</button>
    </form>
    
    <p style="margin-top: 15px;"><small>Hanya untuk pengguna terdaftar (Administrator).</small></p>
  </div>

</body>
</html>