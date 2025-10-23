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

$departements = $newConnexion->query('SELECT * FROM department')->fetchAll(\PDO::FETCH_ASSOC);
if (empty($departements)) {
    return;
}
$departementsMap = [];
foreach ($departements as $departement) {
    $departementsMap[$departement['code']] = $departement['id'];
}   

$cities = $oldConnexion->query('SELECT * FROM cities')->fetchAll(\PDO::FETCH_ASSOC);
if (empty($cities)) {
    return;
}

$placeholders = [];
$params = [];
$iteration = 0;
$sql= 'SET FOREIGN_KEY_CHECKS=0;';
$newConnexion->exec($sql);
foreach ($cities as $city) {

    $placeholders[] = '(?, ?, ?,?, ?,?,?,?,?,?,?, ?,?)';
    $params[] = $departementsMap[$city['department_id']] ?? null;
    $params[] = $city['name'];
    $params[] = $city['slug'];
    $params[] = $city['density'];
    $params[] = $city['surface'];
    $params[] = $city['soundex'];
    $params[] = $city['metaphone'];
    $params[] = $city['latitude'];
    $params[] = $city['longitude'];
    $params[] = $city['website'];
    $params[] = $city['population_2012'];
    $params[] = "\"".$city['description']."\"";
    $params[] = $city['id'];
    if($iteration > 100){
        $sql = 'INSERT INTO city (department_id, name, slug, density, surface, soundex, metaphone, latitude, longitude, website, population, description, legacy_id) VALUES ' . implode(', ', $placeholders);

        try {
            $newConnexion->beginTransaction();
            $stmt = $newConnexion->prepare($sql);
            $stmt->execute($params);
            $newConnexion->commit();
        } catch (\Exception $e) {
            $newConnexion->rollBack();
            throw $e;
        }
        // Reset placeholders and params for next batch
        $placeholders = [];
        $params = [];
        $iteration = 0;
    }
    $iteration++;
}

