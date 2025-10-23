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

$legacyId_postcodes = $oldConnexion->query('SELECT c.city_id, p.postcode FROM city_postcode c JOIN postcodes p on c.postcode_id = p.id')->fetchAll(\PDO::FETCH_ASSOC);
if (empty($legacyId_postcodes)) {
    return;
}
$legacyId_postcodesMap = [];
foreach ($legacyId_postcodes as $legacyId_postcode) {
    $legacyId_postcodesMap[$legacyId_postcode['city_id']] = $legacyId_postcode['postcode'];
}

$cities = $newConnexion->query('SELECT * FROM city')->fetchAll(\PDO::FETCH_ASSOC);
if (empty($cities)) {
    return;
}


$iteration = 0;
$sql= 'SET FOREIGN_KEY_CHECKS=0;';
$newConnexion->exec($sql);
$iteration = 0; 
foreach ($cities as $city) {
    if(isset($legacyId_postcodesMap[$city['legacy_id']])){
        $placeholders[] = '(?, ?)';
        $params[] = $city['id'];
        $params[] = $legacyId_postcodesMap[$city['legacy_id']];
    }
    if($iteration > 100){
        $sql = 'INSERT INTO postcode (city_id, code) VALUES ' . implode(', ', $placeholders);

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

