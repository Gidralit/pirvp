<?php
require_once __DIR__ . '/../dbconnect.php';

session_start();

$errors = [];
$messages = [];

try{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $stmt = Database::pdo()->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        if ($user){
            if (password_verify($password, $user['password_hash'])){
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['name'] = $user['name'];
                header('Location: /');
            } else{
                $errors[] = "Неправильный пароль";
            }
        }else{
            $errors[] = 'Пользователь с таким логином не найден';
        }
    }

}catch(PDOException $e){
    $errors[] = $e->getMessage();
}