<?php
session_start();
require "partials/header.php"

?>


<div class="welcome d-flex align-items-center justify-content-center">
  <div class="text-center">
    <h1>Store Your Contacts Now</h1>

    <?php if (isset($_SESSION["user"])) : ?>
      <a class="btn btn-lg btn-dark" href="add.php">Add One!</a>
    <?php else : ?>
      <a class="btn btn-lg btn-dark" href="register.php">Get Started!</a>
    <?php endif ?>
  </div>
</div>

<?php require "partials/footer.php" ?>