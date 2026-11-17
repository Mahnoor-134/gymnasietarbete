<?php

require_once 'config/db.php';

function addUser($felt)
{
    global $taxi;
    $sql = "INSERT INTO employee(username, name, email, password,  role) 
    VALUES (:username, :name, :email, :password, :role)";


    $stmt = $taxi->prepare($sql);

    // $hashedPassword = password_hash($felt['password'], PASSWORD_DEFAULT);

    $stmt->bindValue(':username', $felt['username']);
    $stmt->bindValue(':name', $felt['name']);
    $stmt->bindValue(':email', $felt['email']);
    $stmt->bindValue(':password', $felt['password']);
    // $stmt->bindValue(':telefon', $felt['telefon']);
    $stmt->bindValue(':role', $felt['role']);


    try {
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        return false;
    }
    //  try {
    //    return $stmt->execute();
    //} catch (PDOException $e) {
    // Visar det riktiga felet från MySQL
    //    die("Databasfel: " . $e->getMessage());
    //}
}


function login($username, $password)
{
    global $taxi;

    $sql = "SELECT * FROM employee WHERE username = :username ";

    $stmt = $taxi->prepare($sql);
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    $users = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($users && password_verify($password, $users['password'])) {
        return $users;
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
    UPDATE employee 
    SET name =:name,
        email=:email,
        password=:password
         Where username=:username";

        $stmt = $taxi->prepare($sql);

        $hashedPassword = password_hash($felt['password'], PASSWORD_DEFAULT);

        $stmt->bindValue(':name', $felt['name']);
        $stmt->bindValue(':email', $felt['email']);
        $stmt->bindValue(':password', $hashedPassword);
        $stmt->bindValue(':username', $felt['username']);
    } else {
        $sql = "
    UPDATE employee 
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
/*function getUser($username)
{
    global $taxi;
   // $sql = "SELECT * FROM users WHERE username = :username ";
 $sql = "SELECT * FROM users";

    $stmt = $taxi->prepare($sql);
  //  $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
  //  return $stmt->fetch(PDO::FETCH_ASSOC);
  return $stmt;
}*/
function deleteUser($username)
{
    global $taxi;

    $sql = "DELETE FROM employee WHERE username = :username";

    $stmt = $taxi->prepare($sql);

    $stmt->bindValue(':username', $username);

    return $stmt->execute();
}

function getUsers()
{
    global $taxi;
    $sql = "select * from employee";

    $stmt = $taxi->prepare($sql);
    $stmt->execute();
    return $stmt;
}

function SearchUser($username)
{

    global $taxi;
    $sql = "SELECT * FROM employee WHERE username = :username ";

    $stmt = $taxi->prepare($sql);
    $stmt->execute([':username' => $username]);
    return $stmt;
}

//car

function getCars()
{
    global $taxi;
    $sql = "SELECT * FROM cars";

    $stmt = $taxi->prepare($sql);
    $stmt->execute();
    return $stmt;
}
function addCar($car)
{
    global $taxi;
    $sql = "INSERT INTO cars(car_model, car_brand, car_year, car_color, meter_reading, number_of_rental_days, price_per_meter) 
    VALUES (:car_model, :car_brand, :car_year, :car_color, :meter_reading, :number_of_rental_days, :price_per_meter)";

    $stmt = $taxi->prepare($sql);

    $stmt->bindValue(':car_model', $car['car_model']);
    $stmt->bindValue(':car_brand', $car['car_brand']);
    $stmt->bindValue(':car_year', $car['car_year']);
    $stmt->bindValue(':car_color', $car['car_color']);
    $stmt->bindValue(':meter_reading', $car['meter_reading']);
    $stmt->bindValue(':number_of_rental_days', $car['number_of_rental_days']);
    $stmt->bindValue(':price_per_meter', $car['price_per_meter']);

    try {
        return $stmt->execute();
    } catch (PDOException $e) {
        return false;
    }
}
function deleteCar($car_id)
{
    global $taxi;
    $sql= "DELETE FROM cars WHERE car_id = :car_id";
    $stmt = $taxi->prepare($sql);
    $stmt->bindValue(':car_id', $car_id);
    return $stmt->execute();
}           
