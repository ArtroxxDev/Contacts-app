<?php

require "database.php";

if(isset($_SESSION["user"])){
    header("Location: home.php");
    return;
  }

$error = null;
$status = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["name"]) || empty($_POST["email"]) || empty($_POST["password"])) {
        $error = "Please fill all the fields";
    } else if(!str_contains($_POST["email"], "@") && !str_contains($_POST["email"], ".")){
        $error = "The email format is incorrect";
    } else {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $password = password_hash($_POST["password"], PASSWORD_BCRYPT);

        $statement = $pdo->prepare("SELECT * FROM usuarios WHERE email = '$email'");
        $statement->execute();

        if ($statement->rowCount() > 0) {
            $error = "The email already exists";
        } else {
            $statement = $pdo->prepare("INSERT INTO usuarios (name, email, password) VALUES (?,?,?)");
            $statement->execute([$name, $email, $password]);

            $status = "exito";

            if($status == "exito"){
                $statement = $pdo->prepare("SELECT * FROM usuarios WHERE email = '$email' LIMIT 1");
                $statement->execute();

                $user = $statement->fetch(PDO::FETCH_ASSOC);
                unset($user["password"]);
                session_start();
                $_SESSION["user"] = $user;


                header("location: home.php");
            }

            
        }

        
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
                <div class="card-header">Register</div>
                <div class="card-body">
                    <?php if ($error) : ?>
                        <p class="text-danger">
                            <?= $error ?>
                        </p>
                    <?php endif ?>
                    <form action="register.php" method="POST">
                        <div class="mb-3 row">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" required autocomplete="name" placeholder="Name" autofocus>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" required autocomplete="email" placeholder="Email" autofocus>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required autocomplete="password" placeholder="Password" autofocus>
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