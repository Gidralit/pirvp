<?php
session_start();
require_once __DIR__ . '/../dbconnect.php';

if (empty($_SESSION['username'])){
    header('Location: /components/login.php');
}

$errors = [];
$message = [];

try{
    $stmt = Database::pdo()->prepare("SELECT * FROM notes WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $_SESSION['user_id']]);
    $notes = $stmt->fetchAll();

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['type'])){
            switch($_POST['type']){
                case 'search':
                    $stmt = Database::pdo()->prepare("SELECT * FROM notes WHERE user_id = :user_id AND title LIKE :title OR content LIKE :content ");
                    $stmt->execute(['title' => '%'.$_POST['query'].'%', 'content' => '%'.$_POST['query'].'%', 'user_id' => $_SESSION['user_id']]);
                    $notes = $stmt->fetchAll();
                    break;
                case 'delete':
                    $stmt = Database::pdo()->prepare("DELETE FROM notes WHERE id = :note_id AND user_id = :user_id");
                    $stmt->execute([
                        'note_id' => $_POST["note_id"],
                        'user_id' => $_SESSION['user_id'],
                    ]);
                    header('Location: '.$_SERVER['PHP_SELF']);
                    exit();
                case 'post':
                    $title = $_POST["note_label"];
                    $content = $_POST["note_text"];

                    Database::insert('notes', ['user_id' => $_SESSION['user_id'], 'title' => $title, 'content' => $content]);
                    header('Location: '.$_SERVER['PHP_SELF']);
                    exit();
            }
        }
    }

}catch(PDOException $e){
    $errors[] = $e->getMessage();
}