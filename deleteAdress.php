<?php
require "database.php";

session_start();

if(!isset($_SESSION["user"])){
  header("Location: login.php");
  return;
}

$id = $_GET["id"];

$statement = $pdo->prepare("SELECT * FROM aditional_info WHERE contact_id = :id LIMIT 1");
$statement->execute([":id" => $id]);

if ($statement->rowCount() == 0) {
    http_response_code(404);
    echo("HTTP 404 NOT FOUNT PERRA");
    return;
}

$contact = $statement->fetch(PDO::FETCH_ASSOC);
if($contact["user_id"] != $_SESSION["user"]["id"]){
    http_response_code(403);
    echo ("HTTP 403 UNAUTORIZED PERRA");
    return;
} else {
    $pdo->prepare("DELETE FROM aditional_info WHERE contact_id = :id")->execute([":id" => $id]);
}
$_SESSION["flash"] = ["message" => "Address of {$contact['name']} deleted."];

header("Location: home.php");

?>