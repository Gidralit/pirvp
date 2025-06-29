<?php
require_once 'app/Database.php';
require_once 'app/User.php';
require_once 'app/auth.php';
redirectIfLoggedIn();

session_start();

$db = new Database();
$db = $db->connect();

$error = null;

$user = new User($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($user->login($username, $password)) {
        header('Location: index.php');
        exit;
    } else {
        $error = 'Неверное имя пользователя или пароль';
    }
}

include 'views/header.php';
?>
<link rel="stylesheet" href="styles/login.css">
<body>
<div class="auth-container">
    <h1 class="auth-title">Авторизация</h1>

    <?php if ($error): ?>
        <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="post" action="">
        <label class="form-label">Имя пользователя:
            <input class="form-input" type="text" name="username" required>
        </label>
        <label class="form-label">Пароль:
            <input class="form-input" type="password" name="password" required>
        </label>
        <button class="btn-submit" type="submit">Авторизироваться</button>
    </form>
</div>
</body>
