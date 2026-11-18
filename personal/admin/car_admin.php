<?php
session_start();
require_once '../../assets/functions.php';

// Only admin can access this page
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
    header('Location: ../../login.php');
    exit();
}

// Handle form submission
$message = "";
//deleting a car
if (isset($_POST['delete_car'])) {
    $car_id = $_POST['car_id'];
    if (deleteCar($car_id)) {
        $message = "Car deleted successfully!";
    } else {
        $message = "Failed to delete car.";
    }
}

if (isset($_POST['add_car'])) {
    $carData = [
        'car_model' => trim($_POST['car_model'] ?? ''),
        'car_brand' => trim($_POST['car_brand'] ?? ''),
        'car_year' => $_POST['car_year'] ?? '',
        'car_color' => trim($_POST['car_color'] ?? ''),
        'meter_reading' => $_POST['meter_reading'] ?? '',
        'price_per_day' => $_POST['price_per_day'] ?? '',
        'included_km_per_day' => $_POST['included_km_per_day'] ?? '',
        'extra_km_price' => $_POST['extra_km_price'] ?? '',
        'number_of_rental_days' => $_POST['number_of_rental_days'] ?? '',

    ];

    if (addCar($carData)) {
        $message = "Car added successfully!";
    } else {
        $message = "Failed to add car.";
    }
}

if (isset($_GET['status'])) {
    if ($_GET['status'] === 'success') {
        $message = "Car added successfully!";
    } elseif ($_GET['status'] === 'deleted') {
        $message = "Car deleted successfully!";
    }
}

$cars = getCars();

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style.css">
    <title>Cars</title>
</head>

<body>
    <h1>Cars</h1>

    <nav class="nav">
        <ul>
            <li><a href="index_admin.php">Admin Dashboard</a></li>
            <li><a href="../../logout.php">Logga ut</a></li>
        </ul>
    </nav>


    <div class="form_container">
        <h1>Add Cars</h1>
        <form action="" method="post" class="add-employee-form">

            <p class="form-description">Fill in the details below to add a new car.</p>
            <label for="car_model">Car Model:</label>
            <input type="text" id="car_model" name="car_model" required>

            <label for="car_brand">Car Brand:</label>
            <input type="text" id="car_brand" name="car_brand" required>

            <label for="car_year">Car Year:</label>
            <input type="number" id="car_year" name="car_year" required>

            <label for="car_color">Car Color:</label>
            <input type="text" id="car_color" name="car_color" required>

            <label for="meter_reading">Meter Reading:</label>
            <input type="number" id="meter_reading" name="meter_reading" required>

            <label for="number_of_rental_days">Number of Rental Days:</label>
            <input type="number" name="number_of_rental_days"id="number_of_rental_days" min="1" required>


            <label for="price_per_day">Price per day (SEK):</label>
            <input type="number" id="price_per_day" name="price_per_day" required>

            <label for="included_km_per_day">Included km per day:</label>
            <input type="number" id="included_km_per_day" name="included_km_per_day" required>

            <label for="extra_km_price">Extra km price (SEK):</label>
            <input type="number" id="extra_km_price" name="extra_km_price" required>


            <button class="btn" type="submit" name="add_car">Add Car</button>
        </form>
    </div>


    <h2>list of register cars</h2>
    <table>
        <tr>
            <th>Car ID</th>
            <th>Car Model</th>
            <th>Car Brand</th>
            <th>Car Year</th>
            <th>Car Color</th>
            <th>Meter Reading</th>
            <th>Number of rental days</th>
            <th>Price per meter</th>

        </tr>
        <?php
        require_once '../../assets/functions.php';
        $cars = getCars();
        while ($row = $cars->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['car_id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['car_model']) . "</td>";
            echo "<td>" . htmlspecialchars($row['car_brand']) . "</td>";
            echo "<td>" . htmlspecialchars($row['car_year']) . "</td>";
            echo "<td>" . htmlspecialchars($row['car_color']) . "</td>";
            echo "<td>" . htmlspecialchars($row['meter_reading']) . "</td>";
            echo "<td>" . htmlspecialchars($row['number_of_rental_days']) . "</td>";
            echo "<td>" . htmlspecialchars($row['price_per_meter']) . "</td>";
            echo "</tr>";
        }
        ?>
    </table>

</body>

</html>