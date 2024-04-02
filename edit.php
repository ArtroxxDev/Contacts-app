<?php

require "database.php";

session_start();

if(!isset($_SESSION["user"])){
  header("Location: login.php");
  return;
}

$id = $_GET["id"];

$statement = $pdo->prepare("SELECT * FROM contacts WHERE id = :id LIMIT 1");
$statement->execute([":id" => $id]);

if ($statement->rowCount() == 0) {
    http_response_code(404);
    echo ("HTTP 404 NOT FOUNT PERRA");
    return;
}

$contact = $statement->fetch(PDO::FETCH_ASSOC);

$error = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["name"]) || empty($_POST["phone_number"])) {
        $error = "Please fill all the fields";
    } else if (strlen($_POST["phone_number"]) > 9) {
        $error = "The phone number must be greater than 9 characters";
    } else {
        $name = $_POST["name"];
        $phoneNumber = $_POST["phone_number"];

        $statement = $pdo->prepare("UPDATE contacts SET name = :name, phone_number = :phone_number WHERE id = :id");
        $statement->execute([
            ":id" => $id,
            ":name" => $_POST["name"],
            ":phone_number" => $_POST["phone_number"]
        ]);

        header("location: index.php");
    }
}

?>
<?php
require "partials/header.php";
?>
<div class="container pt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add New Contact</div>
                <div class="card-body">
                    <?php if ($error) : ?>
                        <p class="text-danger">
                            <?= $error ?>
                        </p>
                    <?php endif ?>
                    <form action="edit.php?id=<?= $contact["id"] ?>" method="POST">
                        <div class="mb-3 row">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>

                            <div class="col-md-6">
                                <input value="<?= $contact["name"] ?>" id="name" type="text" class="form-control" name="name" required autocomplete="name" autofocus>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="phone_number" class="col-md-4 col-form-label text-md-end">Phone
                                Number</label>

                            <div class="col-md-6">
                                <input value="<?= $contact["phone_number"] ?>" id="phone_number" type="tel" class="form-control" name="phone_number" required autocomplete="phone_number" autofocus>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require "partials/footer.php";
?>