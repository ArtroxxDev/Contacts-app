<?php
$contacts = [
  ["name" => "Arthur Lopez", "phone_number" => "0982181248"],
  ["name" => "Enzo Lopez", "phone_number" => "546786578"],
  ["name" => "Abmin Lopez", "phone_number" => "567856789"],
  ["name" => "Matias Lopez", "phone_number" => "789078987"],
  ["name" => "Thiago Lopez", "phone_number" => "2342345654"]

];

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/5.3.2/darkly/bootstrap.min.css" integrity="sha512-JjQ+gz9+fc47OLooLs9SDfSSVrHu7ypfFM7Bd+r4dCePQnD/veA7P590ovnFPzldWsPwYRpOK1FnePimGNpdrA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
  </script>
  <link rel="stylesheet" href="./static/css/index.css">

  <title>Contacts App</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand font-weight-bold" href="#">
        <img class="mr-2" src="./static/img/logo.png" />
        ContactsApp
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="/contacts-app/">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./add.html">Add Contact</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <main>
    <div class="container pt-4 p-3">
      <div class="row">

      <?php foreach($contacts as $contact): ?>
        <div class="col-md-4 mb-3">
          <div class="card text-center">
            <div class="card-body">
              <h3 class="card-title text-capitalize"><?= $contact["name"] ?></h3>
              <p class="m-2"> <?= $contact["phone_number"] ?></p>
              <a href="#" class="btn btn-secondary mb-2">Edit Contact</a>
              <a href="#" class="btn btn-danger mb-2">Delete Contact</a>
            </div>
          </div>
        </div>
      <?php endforeach ?>

      </div>
    </div>
  </main>

</body>

</html>