<?php
require 'inc/functions.php';

$tag = filter_input(INPUT_GET, 'tag', FILTER_SANITIZE_STRING);

$pageTitle = ' | ' . trim($tag);

$page = filter_input(INPUT_GET, 'p', FILTER_SANITIZE_NUMBER_INT);
if (empty($page)) {
    $page = 1;
}

$limit = 25;
$offset = $limit * ($page - 1);

include 'inc/header.php';
?>
    <section>
      <div class="container">
        <?php
        if ($page > 1) {
            echo "<a href='tags.php?tag=" . trim($tag) . "&p=" . ($page-1) . "' class='button'>Previous Page</a>";
        }
        if (count(get_entry_list_by_tag($limit, $offset, $tag)) >= $limit) {
            echo "<a href='tags.php?tag=" . trim($tag) . "&p=" . ($page+1) . "' class='button'>Next Page</a>";
        }
        ?>
        <?php
        if ($page > 1) {
            echo "<a href='tags_l.php?tag=" . trim($tag) . "&p=" . $page . "' class='button'>Light</a>";
        } else {
            echo "<a href='tags_l.php?tag=" . trim($tag) . "' class='button'>Light</a>";
        }
        ?>
        <div class="entry-list">
          <h1><?php echo "#" . trim($tag); ?></h1>
          <?php
          foreach (get_entry_list_by_tag($limit, $offset, $tag) as $item) {
              echo "<article>";
              echo "<h2><a href='detail.php?id=" . $item['id'] . "'>" . $item['title'] . "</a></h2>";
              echo "<time datetime='" . $item['date'] . " " . $item['time'] . "'>" . date("F d, Y H:i", strtotime($item['date'] . " " . $item['time'])) . "</time><br>";
              $tags = get_tags($item['id']);
              foreach ($tags as $tag) {
                  echo "<a href='tags.php?tag=" . trim($tag) . "'>#" . trim($tag) . "</a> ";
              }
          }
          echo "<article>";
          ?>
        </div>
      </div>
    </section>
<?php include 'inc/footer.php'; ?>
