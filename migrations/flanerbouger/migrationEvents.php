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


$citiesMap = [];
$citiesStmt = $newConnexion->query('SELECT id, legacy_id FROM city');
while ($row = $citiesStmt->fetch()) {
    $citiesMap[$row['legacy_id']] = $row['id'];
}

$categoriesMap = [];
$categoriesStmt = $newConnexion->query('SELECT id, legacy_id FROM category');
while ($row = $categoriesStmt->fetch()) {
    $categoriesMap[$row['legacy_id']] = $row['id'];
}

$userMap = [];
$userStmt = $newConnexion->query('SELECT id, legacy_id FROM user');
while ($row = $userStmt->fetch()) {
    $userMap[$row['legacy_id']] = $row['id'];
}


$actualMigrated = $newConnexion->query('SELECT MAX(id) as max_id FROM event')->fetchColumn() ?? 0;
var_dump($actualMigrated);
$maxId = $oldConnexion->query('SELECT MAX(id) as max_id FROM events')->fetchColumn() ?? 0;
var_dump($maxId);
$sql = 'SET FOREIGN_KEY_CHECKS=0;';
$newConnexion->exec($sql);
while ($actualMigrated < $maxId) {
    $iteration = 0;
    $events = $oldConnexion->query('SELECT * FROM events where id > ' . $actualMigrated . ' LIMIT 10000')->fetchAll(\PDO::FETCH_ASSOC);
    var_dump('Migrating events after ID: ' . $actualMigrated . ' - Fetched: ' . count($events));
    foreach ($events as $event) {
        $actualMigrated = $event['id'];
        $placeholders[] = '(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        if (isset($userMap[$event['user_id']])) {
            $params[] = $userMap[$event['user_id']];
        }else{
            $params[] = null;
        }
        if (isset($citiesMap[$event['city_id']])) {
            $params[] = $citiesMap[$event['city_id']];
        }else{
            $params[] = null;
        }
        if (isset($categoriesMap[$event['category_id']])) {
            $params[] = $categoriesMap[$event['category_id']];
        }else{
            $params[] = null;
        }
        $params[] = $event['id'];
        $params[] = $event['description'];
        $params[] = $event['title'];
        $params[] = $event['short_description'];
        $params[] = $event['status'];
        $params[] = $event['created_at'];
        $params[] = $event['updated_at'];
        $params[] = $event['type'];
        $params[] = $event['start_date'];
        $params[] = $event['end_date'];
        $params[] = $event['start_at'];
        $params[] = $event['end_at'];
        
        $iteration++;

        if ($iteration > 100) {
            $sql = 'INSERT INTO event (user_id, city_id,category_id,legacy_id,description, title, short_description, status, creation_date, update_date, type, start_date, end_date, start_at, end_at, legacy_adress) VALUES ' . implode(', ', $placeholders);

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
    }
}
