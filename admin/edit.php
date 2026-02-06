<?php
include "../config/auth.php";
include "../config/db.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$q = mysqli_query($conn, "SELECT * FROM photos WHERE id=$id LIMIT 1");
if (mysqli_num_rows($q) == 0) { header("Location: dashboard.php"); exit(); }
$row = mysqli_fetch_assoc($q);

$msg = "";

if (isset($_POST['save'])) {
  $title = mysqli_real_escape_string($conn, $_POST['title']);
  $category = mysqli_real_escape_string($conn, $_POST['category']);
  $description = mysqli_real_escape_string($conn, $_POST['description']);
  $location = mysqli_real_escape_string($conn, $_POST['location']);
  $shot_date = !empty($_POST['shot_date']) ? mysqli_real_escape_string($conn, $_POST['shot_date']) : NULL;

  $dateValue = $shot_date ? "'$shot_date'" : "NULL";

  // If new image uploaded
  if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $allowed = ["jpg","jpeg","png","webp"];
    $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed)) {
      $msg = "Only JPG, PNG, WEBP allowed.";
    } else {
      $newName = "photo_" . time() . "_" . rand(1000,9999) . "." . $ext;
      $target = "../assets/images/" . $newName;

      if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        // delete old image file
        $old = "../assets/images/" . $row['image'];
        if (file_exists($old)) unlink($old);

        mysqli_query($conn, "UPDATE photos SET
          title='$title',
          category='$category',
          description='$description',
          location='$location',
          shot_date=$dateValue,
          image='$newName'
          WHERE id=$id");
        header("Location: dashboard.php");
        exit();
      } else {
        $msg = "Image upload failed.";
      }
    }
  } else {
    mysqli_query($conn, "UPDATE photos SET
      title='$title',
      category='$category',
      description='$description',
      location='$location',
      shot_date=$dateValue
      WHERE id=$id");
    header("Location: dashboard.php");
    exit();
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Edit Photo</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="bg-grain"></div>

<header class="navbar">
  <div class="container nav-inner">
    <div class="brand">Edit <span>Photo</span><small>Update details</small></div>
    <nav class="nav-links">
      <a href="dashboard.php">Photos</a>
      <a class="active" href="#">Edit</a>
      <a class="admin" href="logout.php">Logout</a>
    </nav>
  </div>
</header>

<div class="admin-shell" style="min-height:auto;">
  <div class="admin-card">
    <h1>Edit</h1>
    <p>Update title, category, story, or replace image</p>

    <form class="form" method="post" enctype="multipart/form-data">
      <div>
        <label>Title</label>
        <input name="title" value="<?php echo htmlspecialchars($row['title']); ?>" required>
      </div>

      <div>
        <label>Category</label>
        <select name="category" required>
          <?php
          $cats = ["Vintage","Culture","Travel","Street","Mountains","Nature"];
          foreach($cats as $c){
            $sel = ($row['category']===$c) ? "selected" : "";
            echo "<option $sel value='$c'>$c</option>";
          }
          ?>
        </select>
      </div>

      <div>
        <label>Description (Story)</label>
        <textarea name="description"><?php echo htmlspecialchars($row['description']); ?></textarea>
      </div>

      <div>
        <label>Location</label>
        <input name="location" value="<?php echo htmlspecialchars($row['location']); ?>">
      </div>

      <div>
        <label>Shot Date</label>
        <input type="date" name="shot_date" value="<?php echo htmlspecialchars($row['shot_date']); ?>">
      </div>

      <div>
        <label>Replace Image (optional)</label>
        <input type="file" name="image">
        <div class="alert" style="margin-top:10px;">
          Current image: <b><?php echo htmlspecialchars($row['image']); ?></b>
        </div>
      </div>

      <button class="btn" name="save">Save Changes</button>
      <a class="btn-outline" href="dashboard.php" style="text-align:center;">Back</a>

      <?php if ($msg) echo "<div class='alert'>$msg</div>"; ?>
    </form>
  </div>
</div>

</body>
</html>
