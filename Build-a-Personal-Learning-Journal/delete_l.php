<?php
require 'inc/functions.php';

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$pageTitle = ' | Delete Entry';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
}
if (delete_entry($id)) {
    echo 'Successfully deleted entry.';
    header('refresh: 1; url = index_l.php');
} else {
    echo 'Unable to delete entry. Try again.';
    header('refresh: 1; url = detail_l.php?id="' . $id . '"');
}
include 'inc/header_l.php';

include 'inc/footer.php';
