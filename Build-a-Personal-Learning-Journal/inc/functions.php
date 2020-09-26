<?php
function get_entry_list($limit, $offset) {
    include 'connection.php';

    $sql = "SELECT id, title, date, time FROM entries ";
    $sql .= "ORDER BY date DESC, time DESC, id DESC LIMIT :limit OFFSET :offset";
    try {
        $results = $db->prepare($sql);
        $results->bindValue('limit', $limit, PDO::PARAM_INT);
        $results->bindValue('offset', $offset, PDO::PARAM_INT);
        $results->execute();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "<br>";
        return array();
    }
    return $results->fetchAll();
}

function get_all_tags() {
    include 'connection.php';

    $sql = 'SELECT tag FROM tags';
    try {
        $results = $db->query($sql);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "<br>";
        return array();
    }
    return $results->fetchAll(PDO::FETCH_COLUMN);
}

function get_tags($entry_id) {
    include 'connection.php';

    $sql = 'SELECT tag FROM tags ';
    $sql .= 'JOIN entry_tag ON tags.id = entry_tag.tag_id ';
    $sql .= 'JOIN entries ON entry_tag.entry_id = entries.id ';
    $sql .= 'WHERE entries.id = :entry_id';
    try {
        $results = $db->prepare($sql);
        $results->bindValue('entry_id', $entry_id, PDO::PARAM_INT);
        $results->execute();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "<br>";
        return array();
    }
    return $results->fetchAll(PDO::FETCH_COLUMN, 0);
}

function get_entry_list_by_tag($limit, $offset, $tag) {
    include 'connection.php';

    $sql = "SELECT entries.id, title, date, time FROM entries ";
    $sql .= "JOIN entry_tag ON entries.id = entry_tag.entry_id ";
    $sql .= "JOIN tags ON entry_tag.tag_id = tags.id ";
    $sql .= "WHERE tag LIKE '%$tag%' ";
    $sql .= "ORDER BY date DESC, time DESC, entries.id DESC LIMIT :limit OFFSET :offset";
    try {
        $results = $db->prepare($sql);
        $results->bindValue('limit', $limit, PDO::PARAM_INT);
        $results->bindValue('offset', $offset, PDO::PARAM_INT);
        $results->execute();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "<br>";
        return array();
    }
    return $results->fetchAll();
}

function get_entry($entry_id) {
    include 'connection.php';

    $sql = "SELECT * FROM entries WHERE id = :id";
    try {
        $results = $db->prepare($sql);
        $results->bindValue('id', $entry_id, PDO::PARAM_INT);
        $results->execute();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "<br>";
        return false;
    }
    return $results->fetch();
}

function search_entries($search, $limit, $offset) {
    include 'connection.php';


    $sql = "SELECT id, title, date, time FROM entries WHERE title LIKE '%$search%' ";
    $sql .= "ORDER BY date DESC, time DESC, id DESC LIMIT :limit OFFSET :offset";
    try {
        $results = $db->prepare($sql);
        $results->bindValue('limit', $limit, PDO::PARAM_INT);
        $results->bindValue('offset', $offset, PDO::PARAM_INT);
        $results->execute();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "<br>";
        return array();
    }
    return $results->fetchAll();
}

function count_entries($search) {
    include 'connection.php';

    $sql = "SELECT COUNT(*) FROM entries WHERE title LIKE '%$search%'";
    try {
        $results = $db->prepare($sql);
        $results->execute();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "<br>";
        return false;
    }
    return $results->fetchColumn();
}

function add_entry($title, $date, $time, $timeSpentH, $timeSpentM, $learned, $resources = null, $tags = null) {
    include 'connection.php';

    $sql = 'INSERT INTO entries (title, date, time, time_spent_h, time_spent_m, learned, resources) ';
    $sql .= 'VALUES (:title, :date, :time, :time_spent_h, :time_spent_m, :learned, :resources)';
    try {
        $results = $db->prepare($sql);
        $results->bindValue('title', $title, PDO::PARAM_STR);
        $results->bindValue('date', $date, PDO::PARAM_STR);
        $results->bindValue('time', $time, PDO::PARAM_STR);
        $results->bindValue('time_spent_h', $timeSpentH, PDO::PARAM_INT);
        $results->bindValue('time_spent_m', $timeSpentM, PDO::PARAM_INT);
        $results->bindValue('learned', $learned, PDO::PARAM_LOB);
        $results->bindValue('resources', $resources, PDO::PARAM_LOB);
        $results->execute();
        $entry_id = $db->lastInsertId();

        foreach ($tags as $tag) {
            if (isset($tag)) {
                $tag = trim($tag);
                if (!in_array($tag, get_all_tags())) {
                    $sql = 'INSERT INTO tags (tag) VALUES (:tag)';
                    $results = $db->prepare($sql);
                    $results->bindValue('tag', $tag, PDO::PARAM_STR);
                    $results->execute();
                    $tag_id = $db->lastInsertId();
                } else {
                    $sql = 'SELECT id FROM tags WHERE tag = :tag';
                    $results = $db->prepare($sql);
                    $results->bindValue('tag', $tag, PDO::PARAM_STR);
                    $results->execute();
                    $tag_id = $results->fetch();
                    $tag_id = $tag_id[0];
                }
                $db->query("INSERT INTO entry_tag (entry_id, tag_id) VALUES ($entry_id, $tag_id)");
            }
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "<br>";
        return false;
    }
    return true;
}

function edit_entry($title, $date, $time, $timeSpentH, $timeSpentM, $learned, $resources = null, $tags = null, $entry_id) {
    include 'connection.php';

    $results = $db->prepare('DELETE FROM entry_tag WHERE entry_id = :entry_id');
    $results->bindValue('entry_id', $entry_id);
    $results->execute();

    $sql = 'UPDATE entries SET title = :title, date = :date, time = :time, time_spent_h = :time_spent_h, ';
    $sql .= 'time_spent_m = :time_spent_m, learned = :learned, resources = :resources WHERE id = :id';
    try {
        $results = $db->prepare($sql);
        $results->bindValue('title', $title, PDO::PARAM_STR);
        $results->bindValue('date', $date, PDO::PARAM_STR);
        $results->bindValue('time', $time, PDO::PARAM_STR);
        $results->bindvalue('time_spent_h', $timeSpentH, PDO::PARAM_INT);
        $results->bindValue('time_spent_m', $timeSpentM, PDO::PARAM_INT);
        $results->bindValue('learned', $learned, PDO::PARAM_LOB);
        $results->bindValue('resources', $resources, PDO::PARAM_LOB);
        $results->bindValue('id', $entry_id, PDO::PARAM_INT);
        $results->execute();

        foreach ($tags as $tag) {
            if (isset($tag)) {
                $tag = trim($tag);
                if (!in_array($tag, get_all_tags())) {
                    $sql = 'INSERT INTO tags (tag) VALUES (:tag)';
                    $results = $db->prepare($sql);
                    $results->bindValue('tag', $tag, PDO::PARAM_STR);
                    $results->execute();
                    $tag_id = $db->lastInsertId();
                } else {
                    $sql = 'SELECT id FROM tags WHERE tag = :tag';
                    $results = $db->prepare($sql);
                    $results->bindValue('tag', $tag, PDO::PARAM_STR);
                    $results->execute();
                    $tag_id = $results->fetch();
                    $tag_id = $tag_id[0];
                }
                $db->query("INSERT INTO entry_tag (entry_id, tag_id) VALUES ($entry_id, $tag_id)");
            }
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "<br>";
        return false;
    }
    return true;
}

function delete_entry($entry_id) {
    include 'connection.php';

    $sql = 'DELETE FROM entries WHERE id = :id';
    try {
        $results = $db->prepare($sql);
        $results->bindValue('id', $entry_id, PDO::PARAM_INT);
        $results->execute();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "<br>";
        return false;
    }
    return true;
}

function delete_all_entries() {
    include 'connection.php';

    $sql = 'DELETE FROM entries';
    $sql2 = 'DELETE FROM tags';
    try {
        $results = $db->prepare($sql);
        $results2 = $db->prepare($sql2);
        $results->execute();
        $results2->execute();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "<br>";
        return false;
    }
    return true;
}
