<?php
require_once 'assets/functions.php';
session_start();

if (isset($_POST['submit'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];
 
    if (login($username, $password)) {
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        header('Location: hemsidan.php');
        exit();
    } else {
        echo 'invalid username or password';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
</head>
<body>
    
    <h1>Log in</h1>
    <form method="POST" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" name="submit" value="Log in">
    </form>


    


</body>
</html>
