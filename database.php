<?php
# Adaptalo a tu conexion de base de datos, yo utilizo postgresql por lo que la conexion la estableci en base a mi proveedor de db

$host ='example';
$database ='example';
$user ='example';
$password ='example';
$endpoint_id ='example';

try {
    $options = http_build_query(['endpoint' => $endpoint_id]);
    $pdo = new PDO("pgsql:host=$host;dbname=$database;options=$options;sslmode=require", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Conexion a la base de datos exitosa";
} catch(PDOException $e) {
    die("Error de conexion: ". $e->getMessage());
}

?>
