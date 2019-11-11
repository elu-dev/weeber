<?php

require_once 'utils.php';
require_once '../database/db.php';
session_start();

if (isset($_GET["action"])) {
    $action = $_GET["action"];
    if ($action == "refresh") refresh($db);
    if (isset($_POST)) {
        if (isset($_SESSION['user'])) {
            if ($action == "create") create($db);
            if ($action == "like") like($db);
            if ($action == "dislike") dislike($db);
        }
    }
}

function like($db) {
    if (!empty($_POST['id'])) {
        $comment_id = $_POST['id'];
        $user_id = $_SESSION['user']['id'];
        $sql = "INSERT INTO likes VALUES(NULL, $user_id, $comment_id)";
        if ($db->query($sql) !== TRUE) die();
    }
}

function dislike($db) {
    if (!empty($_POST['id'])) {
        $comment_id = $_POST['id'];
        $user_id = $_SESSION['user']['id'];
        $sql = "DELETE FROM likes WHERE user_id = $user_id AND comment_id = $comment_id";
        if ($db->query($sql) !== TRUE) die();
    }
}

function create($db) {
    if (!empty($_POST['content'])) {
        $text = sanity_check($_POST['content'], FALSE);
        $user_id = $_SESSION['user']['id'];

        $sql = "INSERT INTO comments VALUES(NULL, '$user_id', '$text', DEFAULT)";

        if ($db->query($sql) !== TRUE) die();
    }
}

function refresh($db) {
    $sql = "SELECT u.nickname, c.content, c.post_date, c.id, COUNT(l.id) AS likes FROM users u "
            . "INNER JOIN comments c ON c.user_id = u.id "
            . "LEFT JOIN likes l ON l.comment_id = c.id "
            . "GROUP BY c.id "
            . "ORDER BY c.post_date DESC";
    
    $liked_comments = [];
    if (isset($_SESSION['user'])) {
        $result = $db->query("SELECT comment_id FROM likes WHERE user_id = {$_SESSION['user']['id']}");
        if ($result->num_rows > 0) {
            while ($like = $result->fetch_assoc()) array_push($liked_comments, $like['comment_id']);
        }
    }

    $result = $db->query($sql);
    if (!$result) return;
    
    elseif ($result->num_rows > 0) while ($row = $result->fetch_assoc()):
    ?>
    <div class="card mb-2 weeb">
        <div class="card-body">
            <h5 class="card-title mb-2"><span class=" weeb-user">@<?=$row['nickname']?></span><div class="weeb-date"><?= $row["post_date"] ?></div></h5>
            <p class="card-text"><?= $row["content"] ?></p>
            <span class="ml-1 <?= in_array($row["id"], $liked_comments) ? "dislike" : "like" ?>" data-id="<?= $row['id'] ?>"> &lt;3 <?= $row['likes'] ?> </span>
        </div>
    </div>    
    <?php
    endwhile;
}

