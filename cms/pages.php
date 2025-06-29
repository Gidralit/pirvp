<?php
require_once 'app/Database.php';
require_once 'app/auth.php';
require_once 'app/Page.php';

session_start();

redirectIfNotLoggedIn();

$db = new Database();
$db = $db->connect();

$page = new Page($db);

$pages = $page->getPages($_SESSION['user_id']);

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rating = $_POST['rating'];
    $userId = $_SESSION['user_id'];
    $pageId = $_POST['id'];

    if(!$page->ratePage($userId, $pageId, $rating)){
        $message = 'Что то пошло не так при оценки сайта:';
    }else{
        header('Location: '. $_SERVER['PHP_SELF']);
        exit;
    }
}

$blockedPage = new Page($db);

include 'views/header.php';
?>

<h2>Страницы для оценивания: </h2>
<?php if (!empty($message)): ?>
<p><?= $message ?></p>
<?php endif; ?>
<a href="addPage.php">Добавить страницу</a>
<?php if(!empty($pages)): ?>
<div class="container">
    <?php foreach ($pages as $page): ?>
    <?php $userBlocked = $blockedPage->userBlockedForPage($_SESSION['user_id'], $page['id']) ?>
        <a href="<?= $page['link'] ?>">
            <div class="page">
                <h3><?= $page['title'] ?></h3>
                <p><?= $page['description'] ?></p>
                 <?php if($page['rated_by_user'] == 1 || $page['blocked']): ?>
                    <p>Средняя оценка страницы: <?= $page['average_rating'] ?></p>
                <?php elseif($userBlocked): ?>
                 <p>Вы заблокированы для оценки данной страницы.</p>
                 <p>Средняя оценка страницы: <?= $page['average_rating'] ?></p>
                 <?php else: ?>
                <form method="post">
                    <input type="hidden" value="<?= $page['id'] ?>" name="id">
                    <label>Поставьте оценку сайту:
                        <select name="rating">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </label>
                    <button type="submit">Поставить оценку</button>
                </form>
                <?php endif; ?>
            </div>
        </a>
    <?php endforeach; ?>
</div>
<?php else: ?>
<p>В данный момент нет страниц для оценивания</p>
<?php endif; ?>