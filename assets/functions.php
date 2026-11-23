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
    $sql = "SELECT * FROM cars ORDER BY car_id ASC";

    $stmt = $taxi->prepare($sql);
    $stmt->execute();
    return $stmt;
}
function addCar($car)
{
    global $taxi;
    $sql = "INSERT INTO cars(car_model, car_brand, car_year, car_color, meter_reading, number_of_rental_days, price_per_day, included_km_per_day, extra_km_price, image) 
    VALUES (:car_model, :car_brand, :car_year, :car_color, :meter_reading, :number_of_rental_days, :price_per_day, :included_km_per_day, :extra_km_price, :image)";

    $stmt = $taxi->prepare($sql);

    $stmt->bindValue(':car_model', $car['car_model']);
    $stmt->bindValue(':car_brand', $car['car_brand']);
    $stmt->bindValue(':car_year', $car['car_year'], PDO::PARAM_INT);
    $stmt->bindValue(':car_color', $car['car_color']);
    $stmt->bindValue(':meter_reading', $car['meter_reading'], PDO::PARAM_INT);
    $stmt->bindValue(':number_of_rental_days', $car['number_of_rental_days'], PDO::PARAM_INT);
    $stmt->bindValue(':price_per_day', $car['price_per_day']);
    $stmt->bindValue(':included_km_per_day', $car['included_km_per_day'], PDO::PARAM_INT);
    $stmt->bindValue(':extra_km_price', $car['extra_km_price']);
    $stmt->bindValue(':image', $car['image']);

    try {
        return $stmt->execute();
    } catch (PDOException $e) {
        die("Database error in addCar: " . $e->getMessage());
    }
}

function deleteCar($car_id)
{
    global $taxi;
    $sql = "DELETE FROM cars WHERE car_id = :car_id";
    $stmt = $taxi->prepare($sql);
    $stmt->bindValue(':car_id', $car_id, PDO::PARAM_INT);
    return $stmt->execute();
}

function calculate_total_price($number_of_rental_days, $price_per_day, $included_km_per_day, $extra_km_price, $total_km_driven)
{
    $base_price = $number_of_rental_days * $price_per_day;
    $extra_km = max(0, $total_km_driven - ($number_of_rental_days * $included_km_per_day));
    $extra_km_cost = $extra_km * $extra_km_price;

    return $base_price + $extra_km_cost;
}

function Get_car_by_id($car_id)
{
    global $taxi;
    $sql = "SELECT * FROM cars WHERE car_id = :car_id";
    $stmt = $taxi->prepare($sql);
    $stmt->bindValue(':car_id', $car_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function edit_car($car)
{
    global $taxi;
    $imageSQL = !empty($car['image']) ? ", image = :image" : "";
    $sql = "UPDATE cars 
            SET car_model = :car_model,
                car_brand = :car_brand,
                car_year = :car_year,
                car_color = :car_color,
                meter_reading = :meter_reading,
                number_of_rental_days = :number_of_rental_days,
                price_per_day = :price_per_day,
                included_km_per_day = :included_km_per_day,
                extra_km_price = :extra_km_price
                $imageSQL

            WHERE car_id = :car_id";

    $stmt = $taxi->prepare($sql);

    $stmt->bindValue(':car_model', $car['car_model']);
    $stmt->bindValue(':car_brand', $car['car_brand']);
    $stmt->bindValue(':car_year', $car['car_year'], PDO::PARAM_INT);
    $stmt->bindValue(':car_color', $car['car_color']);
    $stmt->bindValue(':meter_reading', $car['meter_reading'], PDO::PARAM_INT);
    $stmt->bindValue(':number_of_rental_days', $car['number_of_rental_days'], PDO::PARAM_INT);
    $stmt->bindValue(':price_per_day', $car['price_per_day']);
    $stmt->bindValue(':included_km_per_day', $car['included_km_per_day'], PDO::PARAM_INT);
    $stmt->bindValue(':extra_km_price', $car['extra_km_price']);
    $stmt->bindValue(':car_id', $car['car_id'], PDO::PARAM_INT);

    if (!empty($car['image'])) {
        $stmt->bindValue(':image', $car['image']);
    }
    return ($stmt->execute());
    
}
