<link rel="stylesheet" href="/styles/register.css">
<?php require_once __DIR__ . '/header.php'?>
<?php require_once __DIR__ . '/../db/register.php'; ?>

<div class="container">
    <h2>Регистрация</h2>

    <?php if(count($errors) != 0): ?>
        <div class="error-message">
            <?php foreach ($errors as $error): ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if(count($messages) != 0): ?>
        <div class="success-message">
            <?php foreach ($messages as $message): ?>
                <p><?= $message ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="" method="post">
        <label>Имя:
            <input type="text" name="name" required placeholder="Введите ваше имя">
        </label>

        <label>Юзернейм:
            <input type="text" name="username" required placeholder="Придумайте имя пользователя">
        </label>

        <label>Пароль:
            <input type="password" name="password" required placeholder="Не менее 8 символов">
        </label>

        <label>Повторите пароль:
            <input type="password" name="password_repeat" required placeholder="Повторите ваш пароль">
        </label>

        <button type="submit">Зарегистрироваться</button>
    </form>
</div>