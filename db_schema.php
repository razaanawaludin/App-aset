<?php
include("cores/database.php");
$koneksiku = connectDB();

$stmt = $koneksiku->query("SHOW TABLES");
$tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

foreach($tables as $t) {
    echo "TABLE: $t\n";
    $stmt2 = $koneksiku->query("DESCRIBE $t");
    $cols = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    foreach($cols as $c) {
        echo "  - {$c['Field']} ({$c['Type']})\n";
    }
    echo "\n";
}
?>
