<?php
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/../db/login.php';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <link rel="stylesheet" href="/styles/login.css">
</head>
<body>
<div class="container">
    <h2>Авторизация</h2>

    <?php if (count($errors) != 0): ?>
        <ul class="message-list">
            <?php foreach ($errors as $error): ?>
                <li class="error-message"><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if (count($messages) != 0): ?>
        <ul class="message-list">
            <?php foreach ($messages as $message): ?>
                <li class="success-message"><?= htmlspecialchars($message) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="post">
        <label>
            Логин:
            <input type="text" name="username" required>
        </label>

        <label>
            Пароль:
            <input type="password" name="password" required>
        </label>

        <button type="submit">Войти</button>
    </form>

    <div class="auth-links">
        <p>Еще нет аккаунта? <a href="/components/register.php">Зарегистрируйтесь</a></p>
    </div>
</div>
</body>
</html>