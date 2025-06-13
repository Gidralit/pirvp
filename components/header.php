<?php session_start(); ?>
<link rel="stylesheet" href="/styles/header.css">
<header class="header">
    <a href="/index.php"><h1 class="header__title">Органайзер</h1></a>
    <div class="user">
    <?php if (!empty($_SESSION['username'])): ?>
        <p><?= $_SESSION['username'] ?> <a href="/db/logout.php">Выйти</a></p>
    <?php else: ?>
    </div>
    <div class="header__auth">
        <a href="/components/login.php" class="header__link">Авторизация</a>
        <span class="header__separator">/</span>
        <a href="/components/register.php" class="header__link">Регистрация</a>
    </div>
    <?php endif; ?>
</header>
