<?php

use Conf\DB\DBSettings;

require dirname(__DIR__) . '/vendor/autoload.php';

function executeSqlFile($conn, $file)
{
    $sql = file_get_contents($file);
    $lines = 0;

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    do {
        // Required due to "MySQL has gone away!" issue
        $stmt->fetch();
        $stmt->closeCursor();

        $lines++;
    } while ($stmt->nextRowset());

    return $lines;
}

$conn = $db = new PDO(
    'mysql:host=' . DBSettings::DB_HOST . ';dbname=test',
    DBSettings::DB_USER,
    DBSettings::DB_PASSWORD
);

executeSqlFile($conn, __DIR__ . '/tmp_structure.sql');
executeSqlFile($conn, __DIR__ . '/tmp_data.sql');
