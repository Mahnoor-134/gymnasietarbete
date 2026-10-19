<?php
require_once 'assets/config/db.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>homepage</title>
    <link rel="stylesheet" href="css/style.css">

</head>

<body>
    <h1>Välkommen till hemsida</h1>


    <?php if (isset($_SESSION['username'])) : ?>
        <p>Hej, <?php echo $_SESSION['username']; ?>!</p>
        <a href="profile.php">Profil</a>
        <a href="logout.php">Logga ut</a>
    <?php else : ?>
        <a href="login.php">Logga in</a>
       
    


    <?php endif; ?>

</body>

</html>