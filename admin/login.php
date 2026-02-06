<?php
session_start();
include "../config/db.php";

$msg = "";

if (isset($_POST['login'])) {
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $pass  = md5($_POST['password']);

  $q = mysqli_query($conn, "SELECT * FROM admins WHERE email='$email' AND password='$pass' LIMIT 1");
  if (mysqli_num_rows($q) > 0) {
    $_SESSION['admin'] = $email;
    header("Location: dashboard.php");
    exit();
  } else {
    $msg = "Invalid email or password.";
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Login</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="bg-grain"></div>

<div class="admin-shell">
  <div class="admin-card">
    <h1>Admin Login</h1>
    <p>Sign in to manage your portfolio</p>

    <form class="form" method="post">
      <div>
        <label>Email</label>
        <input type="email" name="email" placeholder="admin@example.com" required>
      </div>
      <div>
        <label>Password</label>
        <input type="password" name="password" placeholder="••••••••" required>
      </div>

      <button class="btn" name="login">Sign In</button>
      <a class="btn-outline" href="../index.php" style="text-align:center;">Back to Portfolio</a>

      <?php if ($msg) echo "<div class='alert'>$msg</div>"; ?>
    </form>
  </div>
</div>

</body>
</html>
