<?php
function findUserByUsername($username)
{
    global $db;

    try {
        $sql = 'SELECT * FROM users WHERE username = :username';
        $results = $db->prepare($sql);
        $results->bindParam('username', $username);
        $results->execute();
        return $results->fetch();
    } catch (\Exception $e) {
        throw $e;
    }
}

function findUserById($userId)
{
    global $db;

    try {
        $sql = 'SELECT * FROM users WHERE id = :id';
        $results = $db->prepare($sql);
        $results->bindParam('id', $userId);
        $results->execute();
        return $results->fetch();
    } catch (\Exception $e) {
        throw $e;
    }
}

function createUser($username, $password)
{
    global $db;

    try {
        $sql = 'INSERT INTO users (username, password) VALUES (:username, :password)';
        $results = $db->prepare($sql);
        $results->bindParam('username', $username);
        $results->bindParam('password', $password);
        $results->execute();
        return findUserByUsername($username);
    } catch (\exception $e) {
        throw $e;
    }
}

function updatePassword($password, $userId)
{
    global $db;

    try {
        $sql = 'UPDATE users SET password = :password WHERE id = :id';
        $results = $db->prepare($sql);
        $results->bindParam('password', $password);
        $results->bindParam('id', $userId);
        $results->execute();
        if ($results->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    } catch (\Exception $e) {
        throw $e;
    }
    return true;
}
