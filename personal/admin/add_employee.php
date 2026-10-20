<?php
require_once 'assets/functions.php';


$records=getUser($_SESSION['username'] );

if($records->rowCount() > 0){
    $row_Recordset1=$records->fetch(PDO::FETCH_ASSOC);
}
?>

<?php
require_once 'assets/functions.php';
session_start();

// Kontrollera att endast inloggad admin har tillgång hit
/*if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}*/

$error = false;



if (isset($_POST['submit'])) {
    if (
        isset($_POST['username'])
        && isset($_POST['name'])
        && isset($_POST['email'])
        && isset($_POST['password'])
        && ($_POST["username"] != "")
        && ($_POST["name"] != "")
        && ($_POST["email"] != "")
        && ($_POST["password"] != "")
    ) {



        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = $_POST['password'];

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $_POST = [
            'username' => $username,
            'name' => $name,
            'email' => $email,
          //  'password' => $hashed_password
            'password' => $password // Skickas i klartext om addUser() sköter hashningen

        ];

        if (addUser($_POST)) {
            $_SESSION['username'] = $username;
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            // $_SESSION['password'] = $password;

            header("Location: hemsidan.php");
            exit();
        } else {
            $error = true;
        }
    } else {
        $error = true;
    }
}

?>


<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add employee</title>
</head>

<body>

    <?php
    if ($error)
        echo "<p>Kontrollera din uppgifter</p>";
    ?>

    <form method="post" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <input type="submit" name="submit" value="login">
    </form>

    <p>
        <a href="login.php">Har du redan ett konto</a>
    </p>

</body>

</html>