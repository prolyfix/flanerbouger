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



$iteration = 0;
$sql= 'SET FOREIGN_KEY_CHECKS=0;';
$newConnexion->exec($sql);
$iteration = 0; 
$organisms = $oldConnexion->query('SELECT * FROM organisms')->fetchAll(\PDO::FETCH_ASSOC);
foreach ($organisms as $organism) {
    if(isset($citiesMap[$organism['city_id']])){
        $placeholders[] = '(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $params[] = $citiesMap[$organism['city_id']];
        $params[] = $organism['name'];
        $params[] = $organism['type'];
        $params[] = $organism['id'];
        $params[] = $organism['address'];
        $params[] = $organism['phone'];
        $params[] = $organism['email'];
        $params[] = $organism['website'];
        $params[] = $organism['created_at'];
        $params[] = $organism['updated_at'];
        $iteration++;
    }
    if($iteration > 100){
        $sql = 'INSERT INTO organism (city_id, name, type, legacy_id, legacy_adress, phone, email, website,creation_date,update_date ) VALUES ' . implode(', ', $placeholders);

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

