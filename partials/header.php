<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/5.3.2/darkly/bootstrap.min.css" integrity="sha512-JjQ+gz9+fc47OLooLs9SDfSSVrHu7ypfFM7Bd+r4dCePQnD/veA7P590ovnFPzldWsPwYRpOK1FnePimGNpdrA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="./static/css/index.css">

<?php $uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH); ?>
<?php if($uri == "/contact_app/"  || $uri == "/contact_app/index.php"): ?>
    <script defer src="./static/js/welcome.js"></script>
<?php endif ?>

    <title>Contacts App</title>
</head>

<body>
    <?php require "./partials/navbar.php"; ?>
    <main>

        <!--Content here-->