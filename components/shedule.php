<?php
    session_start();
    require_once __DIR__ . '/header.php';
    require_once __DIR__ . '/../db/shedule.php';
?>

<link rel="stylesheet" href="/styles/shedule.css">

<h2>Расписание</h2>

<?php if(!empty($errors)): ?>
    <ul>
    <?php foreach ($errors as $error): ?>
        <li><?= $error ?></li>
    <?php endforeach; ?>
    </ul>
<?php endif; ?>

<button onclick="document.querySelector('.modal').style.display = 'flex'">Добавить встречу</button>

<div class="modal">
    <div class="modal-body">
        <button onclick="document.querySelector('.modal').style.display = 'none'">X</button>
        <form method="post" class="modal-form">
            <label>Дата: <input type="date" name="event_date"></label>
            <label>Время: <input type="time" name="event_time"></label>
            <label>Название: <input type="text" name="title"></label>
            <label>Описание: <input type="text" name="description"></label>
            <button type="submit">Добавить встречу</button>
        </form>
    </div>
</div>

<?php if(!empty($meetings)): ?>
    <?php foreach($meetings as $meet): ?>
    <div class="meet">
        <p>Дата: <?= $meet['event_date'] ?></p>
        <p>Время: <?= $meet['event_time'] ?></p>
        <p><?= $meet['title'] ?></p>
        <p><?= $meet['description'] ?></p>
        <form method="post">
            <input type="hidden" name="shedule_id" value="<?= $meet['id'] ?>">
            <button type="submit">Удалить встречу</button>
        </form>
    </div>
    <?php endforeach; ?>
<?php else: ?>
<h2>У вас нет запланированных встреч</h2>
<?php endif; ?>
