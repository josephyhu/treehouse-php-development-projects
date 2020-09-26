<?php
session_start();
if ($_POST['start']) {
    unset($_SESSION['selected']);
    unset($_SESSION['phrase']);
}

include 'inc/Game.php';
include 'inc/Phrase.php';

if (!isset($_SESSION['selected'])) {
    $_SESSION['selected'] = [];
}
if (isset($_POST['key'])) {
    array_push($_SESSION['selected'], $_POST['key']);
}

$phrase = new Phrase($_SESSION['phrase'], $_SESSION['selected']);
$_SESSION['phrase'] = $phrase->currentPhrase;
$game = new Game($phrase);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Phrase Hunter</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/styles.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  </head>

  <body>
    <?php $game->gameOver(); ?>
      <h2 class="header">Phrase Hunter</h2>
      <?php if ($game->checkForLose() == false && $game->checkForWin() == false) {
                echo $phrase->addPhraseToDisplay();
                echo $game->displayKeyboard();
                echo $game->displayScore();
            }
      ?>
    </div>
    <script src="js/script.js"></script>
  </body>
</html>
