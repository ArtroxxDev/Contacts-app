<?php

require "database.php";
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    return;
}

$error = null;
$user_id = $_SESSION["user"]["id"];
$contact_id = $_GET["id"] ?? null; 

$address_info = null;
$shared_with_email = null;
if ($contact_id) {
    $stmt = $pdo->prepare("SELECT ai.address, u.email as shared_with_email 
                            FROM aditional_info ai 
                            LEFT JOIN usuarios u ON ai.shared_with = u.id 
                            WHERE ai.contact_id = :contact_id AND ai.user_id = :user_id");
    $stmt->execute([':contact_id' => $contact_id, ':user_id' => $user_id]);
    $address_info = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($address_info) {
        $shared_with_email = $address_info['shared_with_email']; 
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $contact_id = $_POST["contact_id"];
    $address = $_POST["address"];
    $shared_with = $_POST["shared_with"];

    $shared_with_id = null;
    if ($shared_with) {
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = :email");
        $stmt->execute([':email' => $shared_with]);
        if ($stmt->rowCount() > 0) {
            $shared_with_user = $stmt->fetch(PDO::FETCH_ASSOC);
            $shared_with_id = $shared_with_user['id'];
        } else {
            $error = "No user exists with the email address provided.";
        }
    }

    if (!$error) {
        if (empty($address)) {
            $error = "Please fill in the address.";
        } else {
            $stmt = $pdo->prepare("UPDATE aditional_info SET address = :address, shared_with = :shared_with WHERE contact_id = :contact_id AND user_id = :user_id");
            $stmt->execute([
                ':address' => $address,
                ':contact_id' => $contact_id,
                ':user_id' => $user_id,
                ':shared_with' => $shared_with_id
            ]);
            
            $_SESSION["flash"] = ["The address has been updated."];
            header("location: home.php");
            return;
        }
    }
}

?>

<?php require "partials/header.php"; ?>

<div class="container pt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <?php if ($error) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= $error ?>
                </div>
            <?php endif; ?>
            <div class="card">
                <div class="card-header">Edit Address and Sharing</div>
                <div class="card-body">
                    <form action="editAdress.php?id=<?= htmlspecialchars($contact_id) ?>" method="POST">
                        <div class="mb-3 row">
                            <label for="address" class="col-md-4 col-form-label text-md-end">Address</label>
                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control" name="address"
                                       value="<?= htmlspecialchars($address_info['address'] ?? '') ?>"
                                       required autocomplete="address" autofocus>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="shared_with" class="col-md-4 col-form-label text-md-end">Shared With</label>
                            <div class="col-md-6">
                                <input id="shared_with" type="email" class="form-control" name="shared_with"
                                       value="<?= htmlspecialchars($address_info['shared_with_email'] ?? '') ?>" autocomplete="email">
                            </div>
                        </div>

                        <input type="hidden" name="contact_id" value="<?= htmlspecialchars($contact_id) ?>">

                        <div class="mb-3 row">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">Update Address and Sharing</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<?php require "partials/footer.php"; ?>
