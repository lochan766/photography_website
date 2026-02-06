<?php
include "../config/auth.php";
include "../config/db.php";
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="bg-grain"></div>

<header class="navbar">
  <div class="container nav-inner">
    <div class="brand">Admin <span>Dashboard</span><small>Manage Gallery</small></div>
    <nav class="nav-links">
      <a class="active" href="dashboard.php">Photos</a>
      <a href="upload.php">Upload</a>
      <a href="../gallery.php">View Site</a>
      <a class="admin" href="logout.php">Logout</a>
    </nav>
  </div>
</header>

<section class="section">
  <div class="container">
    <h2>Uploaded Photos</h2>
    <p class="lead">Edit, delete, and manage your gallery.</p>

    <div class="gallery-wrap">
      <?php
      $q = mysqli_query($conn, "SELECT * FROM photos ORDER BY id DESC");
      if (mysqli_num_rows($q) == 0) {
        echo "<div class='center-block' style='padding:80px 0;'><div class='empty'>No photos uploaded yet.</div></div>";
      }

      while ($row = mysqli_fetch_assoc($q)) {
        $id = (int)$row['id'];
        $title = htmlspecialchars($row['title']);
        $cat = htmlspecialchars($row['category']);
        $img = htmlspecialchars($row['image']);
        ?>
        <div class="card">
          <img src="../assets/images/<?php echo $img; ?>" alt="<?php echo $title; ?>">
          <div class="meta">
            <div class="title"><?php echo $title; ?></div>
            <div class="badge"><?php echo $cat; ?></div>

            <div class="row-actions">
              <a class="btn-outline" href="edit.php?id=<?php echo $id; ?>">Edit</a>
              <a class="btn-outline" href="delete.php?id=<?php echo $id; ?>" onclick="return confirm('Delete this photo?')">Delete</a>
            </div>
          </div>
        </div>
        <?php
      }
      ?>
    </div>
  </div>
</section>

</body>
</html>
