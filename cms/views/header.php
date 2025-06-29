<?php
if(!isset($_SESSION)){
    session_start();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../styles/header.css">
    <title>Оценка сайта</title>
</head>
<body>
<header class="site-header">
    <div class="container">
        <div class="header-container">
            <div class="logo-section">
                <a href="../index.php" class="logo">
                    <span class="logo-icon">🚀</span>
                    <span>MySite</span>
                </a>
            </div>

            <menu>
                <a href="../pages.php">Страницы для оценивания</a>
            </menu>
            <?php if(isset($_SESSION['role'])): ?>
                <?php if($_SESSION['role'] === 'admin'): ?>
                    <a href="../admin/index.php">Административная панель</a>
                <?php endif; ?>
            <?php endif; ?>

            <nav class="user-nav">
                <ul class="user-menu">
                    <?php if (!empty($_SESSION['username'])): ?>
                        <li><?= $_SESSION['username'] ?></li>
                        <li><a href="../logout.php">Выйти</a></li>
                    <?php else:; ?>
                        <li><a href="login.php" class="login-btn">Войти</a></li>
                        <li><a href="register.php" class="register-btn">Зарегистрироваться</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
</header>
</body>
</html>
