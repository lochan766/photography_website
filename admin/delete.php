<?php
include "../config/auth.php";
include "../config/db.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$q = mysqli_query($conn, "SELECT image FROM photos WHERE id=$id LIMIT 1");
if (mysqli_num_rows($q) > 0) {
  $row = mysqli_fetch_assoc($q);
  $file = "../assets/images/" . $row['image'];
  if (file_exists($file)) unlink($file);
  mysqli_query($conn, "DELETE FROM photos WHERE id=$id");
}

header("Location: dashboard.php");
exit();
