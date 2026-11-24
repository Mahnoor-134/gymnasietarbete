<?php
require_once 'assets/functions.php';


// Ange uppgifter för din nya admin
$username = 'admin';
$name     = 'Admin';
$email    = 'admin@example.com';
$password = 'aaa';
$role     = 'Admin';


$hashed_password = password_hash($password, PASSWORD_DEFAULT);


$userData = [
   'username' => $username,
   'name'     => $name,
   'email'    => $email,
   'password' => $hashed_password,
   'role'     => $role
];


if (addUser($userData)) {
   echo "Admin skapad! Användarnamn: <b>$username</b>, Lösenord: <b>$password</b><br>";
   echo "VIKTIGT: Ta bort denna fil (create_admin.php) nu!";
} else {
   global $taxi;
   echo "Något gick fel:<br>";
   print_r($taxi->errorInfo());
}
?> 

