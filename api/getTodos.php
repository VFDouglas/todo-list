<?php

/**
 * @var PDO $conn
 */
require_once __DIR__ . '/../includes/conexao_mysql.php';

$sql = "
    select *
      from mysql.todos as t
";

$result = $conn->prepare($sql);
$result->execute();

$data = $result->fetchAll();

echo json_encode($data);