<?php
require 'inc/functions.php';

$pageTitle = ' | Delete All Entries';

if (delete_all_entries()) {
    echo 'Successfully deleted all entries.';
    header('refresh: 1; url = index.php');
} else {
    echo 'Unable to delete all entries. Try again.';
    header('refresh: 1; url = index.php');
}
include 'inc/header.php';

include 'inc/footer.php';
