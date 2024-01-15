<?php
$database_file = "database.db";

$conn = new SQLite3($database_file);

if (!$conn) {
    die("Connection failed: " . $conn->lastErrorMsg());
}


echo "";
?>
