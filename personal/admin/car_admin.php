<?php
session_start();
require_once '../../assets/functions.php';


// Handle form submission
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $carData = [
        'car_model' => $_POST['car_model'] ?? '',
        'car_brand' => $_POST['car_brand'] ?? '',
        'car_year' => $_POST['car_year'] ?? '',
        'car_color' => $_POST['car_color'] ?? '',
        'meter_reading' => $_POST['meter_reading'] ?? '',
        'number_of_rental_days' => $_POST['number_of_rental_days'] ?? '',
        'price_per_meter' => $_POST['price_per_meter'] ?? '' 
    ];

    if (addCar($carData)) {
        $message = "Car added successfully!";
    } else {
        $message = "Failed to add car.";
    }
}

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
            <li><a href="logout.php">Logga ut</a></li>
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
            <input type="number" id="number_of_rental_days" name="number_of_rental_days" required>

            <label for="price_per_meter">Price per meter:</label>
            <input type="text" id="price_per_meter" name="price_per_meter" required>

            <button  class="btn" type="submit">Add Car</button>
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