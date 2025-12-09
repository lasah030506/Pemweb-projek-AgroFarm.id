<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Register - AgroFarm</title>
  
  <link rel="stylesheet" href="../style/style.css"> 
</head>
<body class="form-page">

  <div class="form-box">
    <h2>Register</h2>
    <form action="auth_process.php?action=register" method="POST"> 
      <input type="text" name="name" placeholder="Nama Lengkap" required aria-label="Nama Lengkap">
      <input type="email" name="email" placeholder="Email" required aria-label="Email">
      <input type="password" name="password" placeholder="Password" required aria-label="Password">
      <button class="btn" type="submit">Register</button>
    </form>
    <p style="margin:12px 0;">atau lanjutkan dengan</p>
    <button class="btn" style="background:#fff; color:#111;">Google</button>
  </div>

</body>
</html>