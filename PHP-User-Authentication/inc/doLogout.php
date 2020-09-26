<?php
require_once __DIR__ . '/bootstrap.php';

$session->getFlashBag()->add('success', 'Sucessfully logged out');
$cookie = setAuthCookie('expired', 1);
redirect('/login.php', ['cookies' => [$cookie]]);
