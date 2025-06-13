<?php
session_start();
require_once __DIR__ . '/../dbconnect.php';

if (empty($_SESSION['username'])) header('Location: /components/login.php');

$errors = [];
$messages = [];

try{
    $stmt = Database::pdo()->prepare("
    SELECT * FROM shedule WHERE user_id = :user_id
    ");
    $stmt->execute(['user_id' => $_SESSION['user_id']]);
    $meetings = $stmt->fetchAll();

    if($_SERVER["REQUEST_METHOD"] == 'POST' && !empty($_POST['shedule_id'])){
        $stmt = Database::pdo()->prepare("DELETE FROM shedule WHERE id = :shedule_id AND user_id = :user_id");
        $stmt->execute([
            'shedule_id' => $_POST['shedule_id'],
            'user_id' => $_SESSION['user_id']
        ]);
        header('Location: '.$_SERVER['PHP_SELF']);
        exit();
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $user_id = $_SESSION['user_id'];
        $event_date = $_POST['event_date'];
        $event_time = $_POST['event_time'];
        $title = $_POST['title'];
        $description = $_POST['description'];

        Database::insert('shedule', ['user_id' => $user_id, 'event_date' => $event_date, 'event_time' => $event_time, 'title' => $title, 'description' => $description]);
        header('Location: '.$_SERVER['PHP_SELF']);
        exit();
    }
}catch(PDOException $e){
    $errors[] = $e->getMessage();
}