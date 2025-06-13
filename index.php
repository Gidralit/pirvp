<?php require_once __DIR__ . '/dbconnect.php'?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/styles/index.css">
    <title>Органайзер</title>
</head>
<body>
<?php require_once __DIR__ . '/components/header.php' ?>
<div class="container">
    <ul>
        <li><a href="components/notes.php">📝 Заметки</a></li>
        <li><a href="components/shedule.php">📅 Расписание</a></li>
    </ul>
</div>
</body>
</html>
<?php __DIR__ . '/dbconnect.php' ?>