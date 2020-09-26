<?php
require 'inc/functions.php';

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$item = get_entry($id);

$pageTitle = ' | ' . $item['title'];

include 'inc/header.php';
?>
    <section>
      <div class="container">
        <a href="detail_l.php?id=<?php echo $id; ?>" class="button">Light</a>
        <div class="entry-list single">
          <article>
            <h1><?php echo $item['title']; ?></h1>
            <time datetime="<?php $item['date'] . " " . $item['time']; ?>"><?php echo date('F d, Y H:i', strtotime($item['date'] . " " . $item['time'])); ?></time>
            <div class='entry'>
              <h3>Time Spent: </h3>
              <p><?php echo $item['time_spent_h'] . " hour(s) " . $item['time_spent_m'] . " minute(s)"; ?></p>
            </div>
            <div class='entry'>
              <h3>What I Learned:</h3>
              <?php foreach (explode("\n", $item['learned']) as $learned) {
                  echo "<p>" . $learned . "</p>";
              }
              ?>
            </div>
            <div class='entry'>
              <h3>Resources to Remember:</h3>
              <?php
              if (isset($item['resources'])) {
                  echo "<ul>";
                  foreach (explode(',', $item['resources']) as $resource) {
                      if (stripos(trim($resource), 'http://') === 0 or stripos(trim($resource), 'https://') === 0) {
                          echo "<li><a href='" . strtolower(trim($resource)) . "' target='_blank'>" . strtolower(trim($resource)) . "</a></li>";
                      } else {
                          echo "<li>" . trim($resource) . "</li>";
                      }
                  }
                  echo "</ul>";
              }
              ?>
            </div>
            <div class='entry'>
              <h3>Tags:</h3>
              <?php
              $tags = get_tags($id);
              echo "<ul>";
              foreach ($tags as $tag) {
                  echo "<li><a href='tags.php?tag=" . $tag . "'>#" . $tag . "</a></li>";
              }
              echo "</ul>";
              ?>
            </div>
          </article>
        </div>
      </div>
      <div class="edit">
        <p><a href="edit.php?id=<?php echo $id; ?>">Edit Entry</a></p>
        <p><input type="submit" class="button" value="Delete Entry" onclick="confirmDelete()"></p>
      </div>
      <script>
      function confirmDelete() {
        var r = confirm("Confirm delete.")
        if (r == true) {
          window.location.replace("delete.php?id=<?php echo $id; ?>");
        }
      }
      </script>
    </section>
<?php include 'inc/footer.php'; ?>
