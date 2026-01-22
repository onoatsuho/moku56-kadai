<?php
require_once 'config/database.php';

// ページ判定
$page = isset($_GET['page']) ? $_GET['page'] : 'matchups';
$champ_id = isset($_GET['id']) ? intval($_GET['id']) : null;

include 'includes/header.php';

// ルーティング
if ($page === 'forum') {
    include 'pages/forum.php';
} elseif ($champ_id) {
    include 'pages/detail.php';
} else {
    include 'pages/matchups.php';
}

include 'includes/footer.php';
?>