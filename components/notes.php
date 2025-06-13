<?php session_start();
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/../db/notes.php';
?>
<link rel="stylesheet" href="/styles/notes.css">
<div class="notes-top">
    <h2>Заметки</h2>
    <button onclick="document.querySelector('.modal').style.display = 'flex'">Добавить заметку</button>

    <form method="post">
        <input type="text" name="query" placeholder="Поиск">
        <input type="hidden" name="type" value="search">
        <button type="submit">Найти запись</button>
    </form>

    <?php if(!empty($errors)): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>

<div class="modal">
    <div class="modal-body">
        <button onclick="document.querySelector('.modal').style.display = 'none'">Х</button>
        <form method="post" class="modal-form">
            <label class="form-field">Заголовок заметки: <input type="text" name="note_label" required></label>
            <label class="form-field">Заметка: <textarea name="note_text" cols="30" rows="10" required></textarea></label>
            <input type="hidden" name="type" value="post">
            <button type="submit">Добавить заметку</button>
        </form>
    </div>
</div>

<?php if(!empty($notes)): ?>
    <div class="notes-container">
        <?php foreach ($notes as $note): ?>
            <div class="note-card">
                <h3 class="note-title"><?= htmlspecialchars($note['title']) ?></h3>
                <p class="note-content"><?= nl2br(htmlspecialchars($note['content'])) ?></p>
                <form method="post" class="note-actions">
                    <input type="hidden" name="note_id" value="<?= $note['id'] ?>">
                    <input type="hidden" name="type" value="delete">
                    <button type="submit" class="delete-btn">Удалить</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="notes-container">
        <h2>У вас отсутствуют заметки</h2>
    </div>
<?php endif; ?>
