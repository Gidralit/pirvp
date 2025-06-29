<?php
require_once 'app/Database.php';
require_once "app/Page.php";
require_once 'app/auth.php';
redirectIfLoggedIn();

session_start();

$db = new Database();
$db = $db->connect();

$page = new Page($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $link = $_POST['link'];

    if ($page->create($title, $description, $link)) {
        header('Location: pages.php');
        exit;
    }else{
        $message = 'Ошибка при создании страницы';
    }
}

include "views/header.php";
?>
<h2>Добавить страницу</h2>
<?php if (!empty($message)): ?>
    <p><?= $message ?></p>
<?php endif; ?>
<form method="post">
    <label>Название страницы: <input type="text" name="title" required></label>
    <label>Краткое описание страницы: <textarea name="description" cols="30" rows="10" required></textarea></label>
    <label>Ссылка на страницу: <input type="url" name="link" required></label>
    <button type="submit">Добавить страницу</button>
</form>
