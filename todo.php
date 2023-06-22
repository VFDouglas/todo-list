<?php

/**
 * @var PDO $conn
 */

require_once __DIR__ . '/header.php';

$todoId = isset($_GET['todoid']) ? (int)$_GET['todoid'] : null;

if ($todoId) {
    $sql    = "
        select *
          from mysql.todos as t
         where t.id = $todoId
    ";
    $result = $conn->prepare($sql);
    $result->execute();

    $data = $result->fetchAll();
}
?>
<script src="js/todo.js" defer></script>
<div class="container">
    <form id="form_add_edit_todo">
        <div class="row justify-content-center my-2">
            <div class="col-3">
                <h4>Title</h4>
                <input type="hidden" id="todoid" value="<?= $data[0]['id'] ?? ''; ?>">
                <input class="input_form" required maxlength="50" id="title" value="<?= $data[0]['title'] ?? ''; ?>">
            </div>
        </div>
        <div class="row justify-content-center my-2">
            <div class="col-3">
                <h4>Description</h4>
                <textarea class="input_form" id="description" required
                          maxlength="100"><?= $data[0]['description'] ?? ''; ?></textarea>
            </div>
        </div>
        <div class="row justify-content-center my-2">
            <div class="col-3 text-right">
                <a class="btn btn-red" href="index.php">Cancel</a>
                <button class="btn btn-green">Save</button>
            </div>
        </div>
    </form>
</div>
