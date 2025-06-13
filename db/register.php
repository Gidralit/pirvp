<?php
require_once __DIR__ . '/../dbconnect.php';

$errors = [];
$messages = [];

if  ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password_repeat = $_POST['password_repeat'];

    if($password != $password_repeat){
        $errors[] = 'Ваши пароли не совпадают';
    }
    if(empty($errors)){
        try{
            $stmt = Database::pdo()->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->execute(['username' => $username]);
            if($stmt->fetch()){
                $errors[] = "Пользователь с таким юзернеймом уже существует";
            }else{
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                Database::insert('users', ['name' => $name, 'username' => $username, 'password_hash' => $hashed_password]);
                $messages[] = 'Вы успешно зарегистрировались';
            }
        }catch(PDOException $e){
            $errors[] = 'Ошибка при регистрации: ' . $e->getMessage();
        }
    }
}
