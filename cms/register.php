<?php
require_once 'app/Database.php';
require_once 'app/User.php';
require_once 'app/auth.php';
redirectIfLoggedIn();

session_start();

$db = new Database();
$db = $db->connect();

$user = new User($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    if (strlen($password) < 6) {
        $errors[] = "Пароль должен быть не менее 6 символов";
    }

    if(empty($errors)){
        if ($user->register($username, $password, $email)) {
            header('Location: login.php');
            exit;
        } else{
            $errors[] = 'Ошибка регистрации. Имя пользователя уже занятo.';
        }
    }
}


include 'views/header.php';
?>
<link rel="stylesheet" href="styles/register.css">
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h2 class="auth-title">Регистрация</h2>
                <p class="auth-subtitle">Создайте аккаунт для доступа ко всем возможностям</p>
            </div>

            <?php if(!empty($errors)): ?>
                <div class="error-container">
                    <ul class="error-list">
                        <?php foreach ($errors as $error): ?>
                            <li class="error-item"><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="post" class="auth-form">
                <div class="form-group">
                    <label class="form-label">Имя пользователя</label>
                    <input type="text" name="username" class="form-input" required placeholder="Придумайте уникальное имя">
                </div>

                <div class="form-group">
                    <label class="form-label">Адрес электронной почты</label>
                    <input type="email" name="email" class="form-input" required placeholder="example@mail.com">
                </div>

                <div class="form-group">
                    <label class="form-label">Пароль</label>
                    <input type="password" name="password" class="form-input" required placeholder="Не менее 6 символов">
                    <span class="password-hint">Используйте буквы, цифры и специальные символы</span>
                </div>

                <button type="submit" class="btn">Зарегистрироваться</button>
            </form>

            <div class="auth-links">
                <p>Уже есть аккаунт? <a href="login.php" class="auth-link">Войти</a></p>
            </div>
        </div>
    </div>
</body>
