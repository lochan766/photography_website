<?php
include "config/db.php";
include "includes/header.php";

$category = isset($_GET['category']) ? mysqli_real_escape_string($conn, $_GET['category']) : "";
$where = $category ? "WHERE category='$category'" : "";
?>

<section class="section">
  <div class="container">
    <h2>Gallery</h2>
    <p class="lead">
      A curated collection of moments frozen in time. Browse through photos capturing the essence of places, people, and stories.
    </p>

    <!-- simple category chips -->
    <div class="tag-list" style="margin-top:22px;">
      <a class="tag" href="gallery.php">All</a>
      <a class="tag" href="gallery.php?category=Travel">Trekking</a>
      <a class="tag" href="gallery.php?category=Vintage">Vintage</a>
      <a class="tag" href="gallery.php?category=Culture">Culture</a>
      <a class="tag" href="gallery.php?category=Travel">Travel</a>
      <a class="tag" href="gallery.php?category=Street">Street</a>
      <a class="tag" href="gallery.php?category=Mountains">Mountains</a>
    </div>

    <div class="gallery-wrap">
      <?php
      $q = mysqli_query($conn, "SELECT * FROM photos $where ORDER BY id DESC");
      if (mysqli_num_rows($q) == 0) {
        echo "<div class='center-block' style='padding:80px 0;'><div class='empty'>No photos yet. Upload from Admin.</div></div>";
      }

      while ($row = mysqli_fetch_assoc($q)) {
        $title = htmlspecialchars($row['title']);
        $cat = htmlspecialchars($row['category']);
        $desc = htmlspecialchars($row['description'] ?? '');
        $img = htmlspecialchars($row['image']);
        $loc = htmlspecialchars($row['location'] ?? '');
        ?>
          <div class="card">
            <img src="assets/images/<?php echo $img; ?>" alt="<?php echo $title; ?>">
            <div class="meta">
              <div class="title"><?php echo $title; ?></div>
              <div class="sub"><?php echo $desc ? $desc : "—"; ?></div>
              <div class="badge"><?php echo $cat; ?><?php echo $loc ? " • $loc" : ""; ?></div>
            </div>
          </div>
        <?php
      }
      ?>
    </div>
  </div>
</section>

<?php include "includes/footer.php"; ?>
