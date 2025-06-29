<?php
require_once '../app/Database.php';
require_once '../app/Page.php';
require_once '../app/auth.php';
require_once '../app/User.php';

session_start();

redirectIfNotLoggedIn();

$db = new Database();
$db = $db->connect();

$user = new User($db);

$page = new Page($db);
$page = $page->getPage($_GET['page']);

$users = $user->getAllUsers();

$statistic = new Page($db);
$ratings = $statistic->getRatings($_GET['page']);

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['blocked_user'])) {
    $blockedUser = new Page($db);
    $blockedUser->blockedUser($_POST['blocked_user'], $_GET['page']);
    header("Location: /admin/");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $blocked = $_POST['blocked'];
    $updatePage = new Page($db);
    $updatePage->blockedPage($blocked, $_GET['page']);
}

include '../views/header.php';
?>
<h2>Модерирование страницы: </h2>
<h3>Информация о странице:</h3>
<div class="">
    <?= $page['id'] ?>
    <p>Заголовок: <?= $page['title'] ?></p>
    <p>Краткое описание: <?= $page['description'] ?></p>
    <p>Адрес страницы: <?= $page['link'] ?></p>
</div>
<div class="menu">
    <h3>Меню взаимодействия:</h3>
    <form method="post">
        <p>Можно ли оценить данную страницу?</p>
        <label><input type="radio" name="blocked" value="0">Да</label>
        <label><input type="radio" name="blocked" value="1">Нет</label>
        <button type="submit"> Применить изменения</button>
    </form>
    <form method="post">
        <label>Выберите пользователя, которому хотите запретить оценку:
            <select name="blocked_user">
            <?php foreach ($users as $user): ?>
                <option value="<?=$user['id']?>"><?= $user['username'] ?></option>
            <?php endforeach; ?>
            </select>
        </label>
        <button type="submit">ЗАБАНИТЬ</button>
    </form>
</div>
<h3>Оценки страницы:</h3>
<?php foreach ($ratings as $rating): ?>
<p>Пользователь, оценивший: <?= $rating['username'] ?></p>
<p>Его оценка: <?= $rating['rating'] ?></p>
<?php endforeach; ?>
