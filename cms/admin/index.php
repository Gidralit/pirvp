<?php
require_once '../app/Database.php';
require_once '../app/Page.php';
require_once '../app/auth.php';

session_start();

redirectIfNotLoggedIn();

$db = new Database();
$db = $db->connect();

$page = new Page($db);
$pages = $page->getRatePages();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $deletePage = new Page($db);
    $deletePage->deletePageRate($_POST['page_id']);
    header('Location: /admin/');
    exit;
}

include '../views/header.php';
?>
<h2>Административная панель</h2>
<a href="pages.php">Все страницы сайта</a>
<p>Все оценки страниц</p>
<?php foreach ($pages as $page): ?>
<a href="page.php?page=<?= $page['page_id'] ?>">
    <p><?=$page['page_id'] ?></p>
    <p>Заголовок страницы: <?=$page['page_title'] ?></p>
    <p>Оценивший страницу: <?=$page['username'] ?></p>
    <p>Оценка пользователя: <?=$page['rating'] ?></p>
</a>
    <form method="post">
        <input type="hidden" name="page_id" value="<?= $page['page_id'] ?>">
        <button type="submit">Удалить оценку</button>
    </form>
<?php endforeach; ?>
