<?php
$pageTitle = ' | Profile';
include 'inc/header_l.php';
?>
<section>
<div class="container">
<a href="profile.php" class="button">Dark</a>
<br><br><br>
<h1>Profile</h1>
<?php
$contents = file_get_contents("https://teamtreehouse.com/josephyhu.json");
$contents = utf8_encode($contents);
$data = json_decode($contents, true);
$badges = count($data["badges"]);
$points = $data["points"];
arsort($points);
echo "<h2>Badges</h2>";
echo "<p>Total: " . $badges . "</p>";
echo "<h2>Points</h2>";
foreach ($points as $key => $value) {
    if ($value > 0) {
        echo "<p>" . $key . ": " . $value . "</p>";
    }
}
?>
</div>
</section>
<?php include 'inc/footer.php';
