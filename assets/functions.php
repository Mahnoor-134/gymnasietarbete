<?php

require_once 'config/db.php';

function addUser($felt)
{
    global $taxi;
    $sql = "INSERT INTO users(username, name, email, password) 
    VALUES (:username, :name, :email, :password)";


    $stmt = $taxi->prepare($sql);

   // $hashedPassword = password_hash($felt['password'], PASSWORD_DEFAULT);

    $stmt->bindValue(':username', $felt['username']);
    $stmt->bindValue(':name', $felt['name']);
    $stmt->bindValue(':email', $felt['email']);
    $stmt->bindValue(':password', $felt['password']);

    try {
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        return false;
    }
}


function login($username, $password)
{
    global $taxi;

    $sql = "SELECT * FROM users WHERE username = :username ";

    $stmt = $taxi->prepare($sql);
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        return $user;
    } else {
        return false;
    }
}



//ändra information om användaren
function editUser($felt)
{
    global $taxi;

    if (!empty($felt['password'])) {


        $sql = "
    UPDATE users 
    SET name =:name,
        email=:email,
        password=COALESCE(:password, password)
         Where username=:username";

        $stmt = $taxi->prepare($sql);

        $hashedPassword = password_hash($felt['password'], PASSWORD_DEFAULT);

        $stmt->bindValue(':name', $felt['name']);
        $stmt->bindValue(':email', $felt['email']);
        $stmt->bindValue(':password', $hashedPassword);
        $stmt->bindValue(':username', $felt['username']);
    } else {
        $sql = "
    UPDATE users 
    SET name =:name,
        email=:email
         Where username=:username";

        $stmt = $taxi->prepare($sql);

        $stmt->bindValue(':name', $felt['name']);
        $stmt->bindValue(':email', $felt['email']);
        $stmt->bindValue(':username', $felt['username']);
    }

    return ($stmt->execute());
}
function getUser($username)
{
    global $taxi;
   // $sql = "SELECT * FROM users WHERE username = :username ";
 $sql = "SELECT * FROM users";

    $stmt = $taxi->prepare($sql);
  //  $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
  //  return $stmt->fetch(PDO::FETCH_ASSOC);
  return $stmt;
}

function SearchUser($username)
{

    global $taxi;
    $sql = "SELECT * FROM users WHERE username = :username ";

    $stmt = $taxi->prepare($sql);
    $stmt->execute([':username' => $username]);
    return $stmt;
}
