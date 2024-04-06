<?php

require "database.php";
session_start();

if (!isset($_SESSION["user"])) {
  header("Location: login.php");
  return;
} else {
  $user_id = $_SESSION["user"]["id"];
  $contacts = $pdo->query("SELECT 
                              c.id as id,
                              c.name as name,
                              c.phone_number as phone_number,
                              ai.address as address,
                              (c.user_id = $user_id) as is_owner
                            FROM contacts c 
                            LEFT JOIN aditional_info ai ON c.id = ai.contact_id
                            WHERE c.user_id = $user_id OR ai.shared_with = $user_id");
  //$owner = $pdo->query("SELECT id FROM contacts WHERE user_id = $user_id");
}


//$firstContact = $contacts->fetch(PDO::FETCH_ASSOC);


// Lee el contenido del archivo JSON
//$jsonData = file_get_contents("contacts.json");

// Decodifica la cadena JSON en un array de PHP
//$contacts = json_decode($jsonData, true);

// Ahora, $contacts contiene la información del archivo JSON en formato de array de PHP
?>
<?php
require "partials/header.php";
?>

<div class="container pt-4 p-3">
  <div class="row">

    <?php if ($contacts->rowCount() == 0) : ?>
      <div class="col-md-4 mx-auto">
        <div class="card card-body text-center">
          <p>No contacts saved yet</p>
          <a href="./add.php">Add One!</a>
        </div>
      </div>
    <?php endif ?>

    <?php foreach ($contacts as $index => $contact) : ?>
      <div class="col-md-4 mb-3">
        <div class="card text-center">
          <div class="card-body">
            <h3 class="card-title text-capitalize"><?= $contact["name"] ?></h3>
            <p class="m-2"> <?= $contact["phone_number"] ?></p>
            <p class="m-2">
              <?php if ($contact["address"] != "") : ?>
                <?= $contact["address"] ?>
                  <?php if ($contact["is_owner"]) : ?>
                    <a href="editAdress.php?id=<?= $contact["id"] ?>" class="btn btn-secondary mb-2">
                      <i class="fas fa-edit"></i> 
                    </a>
                  <?php endif; ?>

              <?php else : ?>
                <a href="newAdress.php?id=<?= $contact["id"] ?>" class="btn btn-secondary mb-2">
                  <i class="fas fa-plus-square"></i> Add address and Share
                </a>
              <?php endif; ?>
            </p>
            <div class="d-flex justify-content-center gap-2">
              <?php if ($contact["is_owner"]) : ?>
                <!--<a href="newAdress.php?id=<?= $contact["id"] ?>" class="btn btn-secondary mb-2">
                  <i class="fas fa-plus-square"></i> Add address/Share
                </a> -->

                <a href="edit.php?id=<?= $contact["id"] ?>" class="btn btn-secondary mb-2">
                  <i class="fas fa-edit"></i> Edit
                </a>

                <a href="delete.php?id=<?= $contact["id"] ?>" class="btn btn-danger mb-2">
                  <i class="fas fa-trash-alt"></i> Delete
                </a>

              <?php else : ?>
                <div class="alert alert-warning" role="alert" id="shortInfo<?= $index ?>">
                  <i class="fas fa-exclamation-triangle"></i> This contact is shared with you.
                  <a href="#" class="alert-link" onclick="toggleInfo(<?= $index ?>)">More Info</a>
                </div>

                <!-- Mensaje completo oculto, con un id único -->
                <div class="alert alert-warning d-none" id="moreInfo<?= $index ?>" role="alert">
                  <i class="fas fa-exclamation-triangle"></i> This contact is shared with you; you do not have permission to edit/add an address or delete it.
                  <a href="#" class="alert-link" onclick="toggleInfo(<?= $index ?>)">Less Info</a>
                </div>


              <?php endif; ?>

            </div>
          </div>
        </div>
      </div>
    <?php endforeach ?>

  </div>
</div>
<script>
  // Función para alternar la visibilidad de los mensajes
  function toggleInfo(index) {
    var shortInfo = document.getElementById('shortInfo' + index);
    var moreInfo = document.getElementById('moreInfo' + index);
    if (shortInfo.classList.contains('d-none')) {
      shortInfo.classList.remove('d-none');
      moreInfo.classList.add('d-none');
    } else {
      shortInfo.classList.add('d-none');
      moreInfo.classList.remove('d-none');
    }
  }
</script>

<?php
require "partials/footer.php";
?>