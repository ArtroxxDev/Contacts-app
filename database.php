<?php
$bd = new SQLite3('database.sqlite');

try {
    $result = $bd->query("SELECT * FROM contacts_app;");
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        print_r($row);
    }
} catch (Exception $e) {
    die("SQLite3 Query Error: " . $e->getMessage());
}
?>
