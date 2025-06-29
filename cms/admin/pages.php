<?php
require_once '../app/Database.php';
require_once '../app/Page.php';

$db = new Database();
$db = $db->connect();
$page = new Page($db);
$pages = $page->getPagesAdmin();
include "../views/header.php";
?>

<h2>Все страницы: </h2>
<?php foreach ($pages as $page): ?>
    <a href="page.php?page=<?= $page['id'] ?>">
        <div class="page">
            <h3><?= $page['title'] ?></h3>
            <p><?= $page['description'] ?></p>
        </div>
    </a>
<?php endforeach; ?>