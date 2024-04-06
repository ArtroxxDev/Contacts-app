<?php

require "database.php";
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    return;
}

$error = null;
$contact_id = $_GET["id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $contact_id = $_POST["contact_id"];
    if (empty($_POST["address"])) {
        $error = "Please fill the address";
    } else if (!empty($_POST["shared_with"])) {
        if (!str_contains($_POST["shared_with"], "@") && !str_contains($_POST["shared_with"], ".")) {
            $error = "The email format is incorrect";
        } else {
            $address = $_POST["address"];
            $shared_with = $_POST["shared_with"];
            $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = :email");
            $stmt->execute([':email' => $shared_with]);
            $user_id = $_SESSION["user"]["id"];

            if ($stmt->rowCount() == 0) {
                $error = "User registered with this email address not exists";
            } else {
                $shared_with_user = $stmt->fetch(PDO::FETCH_ASSOC);
                $shared_with_id = $shared_with_user['id'];
                $statement = $pdo->prepare("INSERT INTO aditional_info (address, contact_id, user_id, shared_with) VALUES (:address, :contact_id, :user_id, :shared_with)");
                $statement->execute([
                    ':address' => $address,
                    ':contact_id' => $contact_id,
                    ':user_id' => $user_id,
                    ':shared_with' => $shared_with_id 
                ]);
                $_SESSION["flash"] = ["Contact {$_POST['name']} has been assigned an address"];
                header("location: home.php");
                return;
            }
        }
    } else {
        $address = $_POST["address"];
        $phoneNumber = $_POST["phone_number"];
        $user_id = $_SESSION["user"]["id"];

        $statement = $pdo->prepare("INSERT INTO aditional_info (address, contact_id, user_id) VALUES (?, ?, ?)");
        $statement->execute([$address, $contact_id, $user_id]);

        $_SESSION["flash"] = ["Contact {$_POST['name']} has been assigned an address"];
        header("location: home.php");
        return;
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
                <div class="card-header">Add address and Share your contact with friends</div>
                <div class="card-body">
                    <?php if ($error) : ?>
                        <p class="text-danger">
                            <?= $error ?>
                        </p>
                    <?php endif ?>
                    <form action="newAdress.php" method="POST">
                        <div class="mb-3 row">
                            <label for="address" class="col-md-4 col-form-label text-md-end">Address</label>

                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control" name="address" required autocomplete="address" autofocus>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="shared_with" class="col-md-4 col-form-label text-md-end">Shared with</label>

                            <div class="col-md-6">
                                <input id="shared_with" type="email" class="form-control" name="shared_with" autocomplete="shared_with" autofocus>
                            </div>
                        </div>

                        <input type="hidden" name="contact_id" value="<?= htmlspecialchars($contact_id) ?>">

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