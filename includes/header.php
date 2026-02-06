<?php
$current = basename($_SERVER['PHP_SELF']);
function active($file, $current){
  return $file === $current ? "active" : "";
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Lochan Samser Rana | Photography</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="bg-grain"></div>

<header class="navbar">
  <div class="container nav-inner">
    <a class="brand" href="index.php">Lochan <span>Samser Rana</span><small>Photography</small></a>

    <nav class="nav-links">
      <a class="<?php echo active('index.php',$current); ?>" href="index.php">Home</a>
      <a class="<?php echo active('gallery.php',$current); ?>" href="gallery.php">Gallery</a>
      <a class="<?php echo active('about.php',$current); ?>" href="about.php">About</a>
      <a class="admin" href="admin/login.php">Admin</a>
    </nav>
  </div>
</header>
