<?php

/**
 * @var PDO $conn
 */

$response = [];
try {
    require_once __DIR__ . '/../includes/conexao_mysql.php';

    $data = file_get_contents('php://input');
    $data = json_decode($data, true);

    if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
        throw new Exception('Invalid request method');
    }
    if (!is_numeric($data['id'])) {
        throw new Exception('The todoid '. $data['id'] .' is invalid');
    }
    $sql    = "
        delete from mysql.todos
         where id = " . $data['id'] . "
    ";
    $result = $conn->prepare($sql);

    if (!$result->execute()) {
        throw new Exception('Error deleting the todo');
    }
    $response['query'] = true;
} catch (Exception $e) {
    $response['query'] = false;
    $response['error'] = $e->getMessage();
}

header('Content-Type: application/json;charset=utf-8');
echo json_encode($response);