<?php
session_start();

require_once 'assets/functions.php';


if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}

//uppdatera 
if (isset($_POST['submit'])) {
   
    $name = filter_input(INPUT_POST, 'name',  FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];


    if (!$name || !$email) {
        echo "Vänligen fyll i ett giltigt namn och en giltig e-postadress.";
    } else {

        $hashed_password = null;
        if (!empty($password)) {

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        }
    //  else {

    $felt = [
        'username' => $_SESSION['username'],
        'name' => $name,
        'email' => $email,
        'password' => $hashed_password

    ];

    if (editUser($felt)) {
        echo "profile uppdaterad";
    } else {

        echo "något gick fel";
    }
      }
}
 

//hämta info om användaren
$row = getUser($_SESSION['username']);


// Om användaren inte finns
if (!$row) {
    header('Location: index.php');
    exit;
}

?>