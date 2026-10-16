<?php

require_once 'config/db.php';

function addUser($felt)
{
    global $forum;
    $sql = "INSERT INTO user(username, name, email, password) 
    VALUES (:username, :name, :email, :password)";


    $stmt = $forum->prepare($sql);

    $stmt->bindValue(':username', $felt['username']);
    $stmt->bindValue(':name', $felt['name']);
    $stmt->bindValue(':email', $felt['email']);
    $stmt->bindValue(':password', $felt['password']);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}


function login($username, $password)
{
    global $forum;

    $sql = "SELECT * FROM user WHERE username = :username ";

    $stmt = $forum->prepare($sql);
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
    global $forum;

    if (!empty($felt['password'])) {


        $sql = "
    UPDATE user 
    SET name =:name,
        email=:email,
        password=COALESCE(:password, password)
         Where username=:username";

        $stmt = $forum->prepare($sql);

        $stmt->bindValue(':name', $felt['name']);
        $stmt->bindValue(':email', $felt['email']);
        $stmt->bindValue(':password', $felt['password']);
        $stmt->bindValue(':username', $felt['username']);
    } else {
        $sql = "
    UPDATE user 
    SET name =:name,
        email=:email
         Where username=:username";

        $stmt = $forum->prepare($sql);

        $stmt->bindValue(':name', $felt['name']);
        $stmt->bindValue(':email', $felt['email']);
        $stmt->bindValue(':username', $felt['username']);
    }

    return ($stmt->execute());
}
function getUser($username)
{
    global $forum;
    $sql = "SELECT * FROM user WHERE username = :username ";

    $stmt = $forum->prepare($sql);
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function SearchUser($username)
{

    global $forum;
    $sql = "SELECT * FROM forum WHERE username = :username ";

    $stmt = $forum->prepare($sql);
    $stmt->execute([':username' => $username]);
    return $stmt;
}
