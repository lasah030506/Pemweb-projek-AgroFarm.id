<?php
require_once 'src/config.php';

echo "Table: commodities\n";
$result = $conn->query("DESCRIBE commodities");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        echo $row['Field'] . " | " . $row['Type'] . "\n";
    }
} else {
    echo "Table users not found or error: " . $conn->error;
}
?>
