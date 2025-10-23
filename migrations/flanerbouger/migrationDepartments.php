<?php
$host = '127.0.0.1';
$db   = 'flanerbouger';
$user = 'root';
$pass = 'sir0sE!24';
$charset = 'utf8mb4'; // Recommended charset for modern MySQL connections

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Throw exceptions on errors
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Default fetch mode to associative array
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Use real prepared statements
];

try {
     $oldConnexion  = new PDO($dsn, $user, $pass, $options);
     echo "Connected successfully to the database! 🎉";
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

$host = '127.0.0.1';
$db   = 'flbg';
$user = 'root';
$pass = 'sir0sE!24';
$charset = 'utf8mb4'; // Recommended charset for modern MySQL connections

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Throw exceptions on errors
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Default fetch mode to associative array
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Use real prepared statements
];

try {
     $newConnexion  = new PDO($dsn, $user, $pass, $options);
     echo "Connected successfully to the database! 🎉";
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}


$values = $oldConnexion->query('SELECT * FROM departments')->fetchAll(\PDO::FETCH_ASSOC);
if (empty($values)) {
    return;
}

$placeholders = [];
$params = [];
foreach ($values as $value) {
    $placeholders[] = '(?,  ?,?)';
    $params[] = $value['code'];
    $params[] = $value['name'];
    $params[] = $value['soundex'];
}

$sql= 'SET FOREIGN_KEY_CHECKS=0;';
$newConnexion->exec($sql);
$sql = 'INSERT INTO department ( code,  name, soundex) VALUES ' . implode(', ', $placeholders);

try {
    $newConnexion->beginTransaction();
    $stmt = $newConnexion->prepare($sql);
    $stmt->execute($params);
    $newConnexion->commit();
} catch (\Exception $e) {
    $newConnexion->rollBack();
    throw $e;
}