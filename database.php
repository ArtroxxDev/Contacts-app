<?php
# Do not expose your Neon credentials to the browser

$host = 'ep-long-dew-a5wxr6n2.us-east-2.aws.neon.tech';
$database = 'artroxx';
$user = 'alsalinas15';
$password = 'ZSsBn50NPrWV';
$endpoint_id = 'ep-long-dew-a5wxr6n2';

try {
    $options = http_build_query(['endpoint' => $endpoint_id]);
    $pdo = new PDO("pgsql:host=$host;dbname=$database;options=$options;sslmode=require", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //echo "Conexion a la base de datos exitosa";
} catch (PDOException $e) {
    die("Error de conexion: " . $e->getMessage());
}
