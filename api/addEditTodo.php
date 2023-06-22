<?php

declare(strict_types = 1);

/**
 * @var PDO $conn
 */

$response = [];
try {
    require_once __DIR__ . '/../includes/conexao_mysql.php';

    $data = file_get_contents('php://input');
    $data = json_decode($data, true);

    $todoId      = isset($data['todoId']) ? (int)$data['todoId'] : null;
    $title       = isset($data['title']) ? strip_tags($data['title']) : null;
    $description = isset($data['description']) ? strip_tags($data['description']) : null;

    if (!in_array($_SERVER['REQUEST_METHOD'], ['POST', 'PUT'])) {
        throw new Exception('Invalid request method');
    }
    if (!is_numeric($todoId) && $_SERVER['REQUEST_METHOD'] === 'PUT') {
        throw new Exception('The todoid is invalid');
    }
    if (!$title || !$description) {
        throw new Exception('Inform the title or description');
    }

    $sql    = '';
    $action = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = 'inserting';
        $sql    = "
            insert into mysql.todos (title, description)
            values ('" . strip_tags($title) . "', '" . strip_tags($description) . "')
        ";
    } elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        $action = 'updating';
        $sql    = "
            update mysql.todos t
               set t.title       = '" . strip_tags($title) . "',
                   t.description = '" . strip_tags($description) . "'
             where t.id = " . (int)$todoId . "
        ";
    }

    $result = $conn->prepare($sql);
    if (!$result->execute()) {
        throw new Exception("Error $action the todo");
    }
    $response['query'] = true;
} catch (Exception $e) {
    $response['query'] = false;
    $response['error'] = $e->getMessage();
}

header('Content-Type: application/json;charset=utf-8');
echo json_encode($response);