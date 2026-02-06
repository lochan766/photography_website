<?php
$conn = mysqli_connect("localhost", "root", "", "photography_portfolio");
if (!$conn) {
  die("Database connection failed: " . mysqli_connect_error());
}
?>
