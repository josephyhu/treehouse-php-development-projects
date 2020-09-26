<?php
require_once __DIR__ . '/bootstrap.php';
requireAuth();

$currentPassword = request()->get('current_password');
$newPassword = request()->get('password');
$confirmPassword = request()->get('confirm_password');

if ($newPassword != $confirmPassword) {
    $session->getFlashBag()->add('error', 'Passwords do not match');
    redirect('/account.php');
}

$user = getAuthenticatedUser();

if (empty($user)) {
    $session->getFlashBag()->add('error', 'Error');
    redirect('/account.php');
}

if (!password_verify($currentPassword, $user['password'])) {
    $session->getFlashBag()->add('error', 'Current password was incorrect');
    redirect('/account.php');
}

$hashed = password_hash($newPassword, PASSWORD_DEFAULT);

if (!updatePassword($hashed, $user['id'])) {
    $session->getFlashBag()->add('error', 'Could not update password');
    redirect('/account.php');
}

$session->getFlashBag()->add('success', 'Password updated');
redirect('/account.php');
