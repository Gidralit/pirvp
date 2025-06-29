<?php

function redirectIfLoggedIn(){
    if (isset($_SESSION['user_id'])) {
        header('Location: index.php');
        exit;
    }
}

function redirectIfNotLoggedIn(){
    if (empty($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }
}