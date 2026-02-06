<?php
include "config/db.php";
include "includes/header.php";
?>

<section class="hero">
  <div class="hero-content">
    <div class="hero-kicker">NEPAL • EXPLORER • ENGINEER</div>

    <h1 class="hero-title">
      Living with <em>intensity</em>,<br>not just existing
    </h1>

    <p class="hero-sub">
      A lifelong journey of exploring new places, capturing old moments,
      and finding timeless stories in the streets, mountains, and cultures of Nepal and beyond.
    </p>

    <a class="explore" href="#collections">
      EXPLORE <span class="arrow"></span>
    </a>
  </div>
</section>

<!-- Collections / Preview Photos -->
<section id="collections" class="section">
  <div class="container">
    <div class="center-block" style="padding:30px 0 20px;">
      <h2>Collections</h2>
      <p>
        Stories captured across mountains, streets, and cultures.
        Here are the latest moments from my journey.
      </p>
    </div>

    <div class="gallery-wrap">
      <?php
      // Show latest 6 photos on homepage
      $q = mysqli_query($conn, "SELECT * FROM photos ORDER BY id DESC LIMIT 6");

      if (mysqli_num_rows($q) == 0) {
        echo "<div class='center-block' style='padding:40px 0;'>
                <div class='empty'>No photos yet. Upload from Admin.</div>
              </div>";
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

              <div class="row-actions">
                <a class="btn-outline" href="gallery.php">View Full Gallery</a>
              </div>
            </div>
          </div>
        <?php
      }
      ?>
    </div>

    <div style="text-align:center; margin-top:28px;">
      <a class="btn-outline" href="gallery.php">View All Photos</a>
    </div>
  </div>
</section>

<section class="quote-band">
  <div class="container">
    <blockquote>“Photography is the story I fail to put into words.”</blockquote>
    <div class="by">— Destin Sparks</div>
  </div>
</section>

<?php include "includes/footer.php"; ?>
