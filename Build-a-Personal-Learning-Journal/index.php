<?php
require 'inc/functions.php';

$page = filter_input(INPUT_GET, 'p', FILTER_SANITIZE_NUMBER_INT);
if (empty($page)) {
    $page = 1;
}

$limit = 25;
$offset = $limit * ($page - 1);

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['search'])) {
    $search = trim(filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING));

    $entries = search_entries($search, $limit, $offset);
    $count = count_entries($search);

    if ($count == 1) {
        echo "Found " . $count . " entry for the term: " . $search . ".";
    } else {
        echo "Found " . $count . " entries for the term: " . $search . ".";
    }
}

include 'inc/header.php';
?>
    <section>
      <div class="container">
        <form method="get">
          Search:
          <input type="search" name="search" required>
        </form>
        <br>
        <?php
        if (!empty($entries) && $page > 1) {
            echo "<a href='index.php?search=" . trim($search) . "&p=" . ($page-1) . "' class='button'>Previous Page</a>";
        }
        if (count($entries) >= $limit) {
            echo "<a href='index.php?search=" . trim($search) . "&p=" . ($page+1) . "' class='button'>Next Page</a>";
        }
        if (empty($entries) && $page > 1) {
            echo "<a href='index.php?p=" . ($page-1). "' class='button'>Previous Page</a>";
        }
        if (empty($entries) && count(get_entry_list($limit, $offset)) >= $limit) {
            echo "<a href='index.php?p=" . ($page+1). "' class='button'>Next Page</a>";
        }
        if (!empty(get_entry_list($limit, $offset))) {
            echo "<input type='submit' class='button' value='Delete All' onclick='confirmDeleteAll()'>";
        }
        ?>
        <?php
        if (!empty($entries) && $page > 1) {
            echo "<a href='index_l.php?search=" . trim($search) . "&p=" . $page . "' class='button'>Light</a>";
        } elseif (!empty($entries) && $page == 1) {
            echo "<a href='index_l.php?search=" . trim($search) . "' class='button'>Light</a>";
        } elseif (empty($entries) && $page > 1) {
            echo "<a href='index_l.php?p=" . $page . "' class='button'>Light</a>";
        } else {
            echo "<a href='index_l.php' class='button'>Light</a>";
        }
        ?>
        <div class="entry-list">
          <?php
          if (isset($entries)) {
              foreach ($entries as $entry) {
                  echo "<article>";
                  echo "<h2><a href='detail.php?id=" . $entry['id'] . "'>" . $entry['title'] . "</a></h2>";
                  echo "<time datetime='" . $entry['date'] . " " . $entry['time'] . "'>" . date("F d, Y H:i", strtotime($entry['date'] . " " . $entry['time'])) . "</time><br>";
                  $tags = get_tags($entry['id']);
                  foreach ($tags as $tag) {
                      echo "<a href='tags.php?tag=" . $tag . "'>#" . $tag . "</a> ";
                  }
                  echo "</article>";
              }
          } else {
              foreach (get_entry_list($limit, $offset) as $item) {
                  echo "<article>";
                  echo "<h2><a href='detail.php?id=" . $item['id'] . "'>" . $item['title'] . "</a></h2>";
                  echo "<time datetime='" . $item['date'] . " " . $item['time'] . "'>" . date("F d, Y H:i", strtotime($item['date'] . " " . $item['time'])) . "</time><br>";
                  $tags = get_tags($item['id']);
                  foreach ($tags as $tag) {
                      echo "<a href='tags.php?tag=" . $tag . "'>#" . $tag . "</a> ";
                  }
                  echo "</article>";
              }
          }
          ?>
        </div>
      </div>
      <script>
      function confirmDeleteAll() {
        var r = confirm("Confirm delete all.")
        if (r == true) {
          window.location.replace("delete_all.php");
        }
      }
      </script>
    </section>
<?php include 'inc/footer.php'; ?>
