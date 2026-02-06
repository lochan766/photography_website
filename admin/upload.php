<?php
include "../config/auth.php";
include "../config/db.php";

$msg = "";

if (isset($_POST['upload'])) {
  $title = mysqli_real_escape_string($conn, $_POST['title']);
  $category = mysqli_real_escape_string($conn, $_POST['category']);
  $description = mysqli_real_escape_string($conn, $_POST['description']);
  $location = mysqli_real_escape_string($conn, $_POST['location']);
  $shot_date = !empty($_POST['shot_date']) ? mysqli_real_escape_string($conn, $_POST['shot_date']) : NULL;

  if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
    $msg = "Please select an image.";
  } else {
    $allowed = ["jpg","jpeg","png","webp"];
    $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed)) {
      $msg = "Only JPG, PNG, WEBP allowed.";
    } else {
      $newName = "photo_" . time() . "_" . rand(1000,9999) . "." . $ext;
      $target = "../assets/images/" . $newName;

      if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $dateValue = $shot_date ? "'$shot_date'" : "NULL";
        mysqli_query($conn, "INSERT INTO photos (title, category, description, image, location, shot_date)
          VALUES ('$title','$category','$description','$newName','$location',$dateValue)");
        header("Location: dashboard.php");
        exit();
      } else {
        $msg = "Upload failed.";
      }
    }
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Upload Photo</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="bg-grain"></div>

<header class="navbar">
  <div class="container nav-inner">
    <div class="brand">Upload <span>Photo</span><small>Add to gallery</small></div>
    <nav class="nav-links">
      <a href="dashboard.php">Photos</a>
      <a class="active" href="upload.php">Upload</a>
      <a class="admin" href="logout.php">Logout</a>
    </nav>
  </div>
</header>

<div class="admin-shell" style="min-height:auto;">
  <div class="admin-card">
    <h1>Upload</h1>
    <p>Add a new image to your portfolio</p>

    <form class="form" method="post" enctype="multipart/form-data">
      <div>
        <label>Title</label>
        <input name="title" placeholder="e.g. Old Street of Kathmandu" required>
      </div>

      <div>
        <label>Category</label>
        <select name="category" required>
          <option value="Vintage">Vintage</option>
          <option value="Culture">Culture</option>
          <option value="Travel">Travel</option>
          <option value="Street">Street</option>
          <option value="Mountains">Mountains</option>
          <option value="Nature">Nature</option>
        </select>
      </div>

      <div>
        <label>Description (Story)</label>
        <textarea name="description" placeholder="Write the story behind this photo..."></textarea>
      </div>

      <div>
        <label>Location</label>
        <input name="location" placeholder="e.g. Pokhara, Nepal">
      </div>

      <div>
        <label>Shot Date</label>
        <input type="date" name="shot_date">
      </div>

      <div>
        <label>Image</label>
        <input type="file" name="image" required>
      </div>

      <button class="btn" name="upload">Upload Photo</button>
      <a class="btn-outline" href="dashboard.php" style="text-align:center;">Back</a>

      <?php if ($msg) echo "<div class='alert'>$msg</div>"; ?>
    </form>
  </div>
</div>

</body>
</html>
