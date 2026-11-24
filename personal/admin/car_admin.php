<?php
session_start();
require_once '../../assets/functions.php';

echo "<pre>";

echo "REQUEST METHOD: ";
var_dump($_SERVER['REQUEST_METHOD']);

echo "CONTENT TYPE: ";
var_dump($_SERVER['CONTENT_TYPE'] ?? null);

echo "CONTENT LENGTH: ";
var_dump($_SERVER['CONTENT_LENGTH'] ?? null);

echo "POST DATA: ";
var_dump($_POST);

echo "FILES DATA: ";
var_dump($_FILES);

echo "</pre>";




// Only admin can access this page
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
//    header('Location: ../../login.php');
//    exit();
}

// Handle form submission
$message = "";
$image_name = null;



// Image upload handling
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        die("Uppladdningsfel, felkod: " . $_FILES['image']['error']);
    }   

    $allowedTypes = [
        'image/jpeg' => '.jpg',
        'image/png' => '.png',
        'image/gif' => '.gif',
        'image/webp' => '.webp'
    ];

    $file_type = mime_content_type($_FILES['image']['tmp_name']);
echo '<pre>';
var_dump($_SERVER['REQUEST_METHOD']);
var_dump($_POST);
var_dump($_FILES);
echo '</pre>';
    if (isset($allowedTypes[$file_type])) {
        $upload_dir = __DIR__ . '/../../uploads/';

        
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Check folder permissions
        if (!is_writable($upload_dir)) {
            die("Upload folder is not writable: " . $upload_dir);
        }

        $extension = $allowedTypes[$file_type];
        $image_name = uniqid('car_', true) . $extension;
        $uploadPath = $upload_dir . $image_name;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
            echo "Image uploaded successfully." . $image_name;
        } else {
            echo "Failed to upload image." . $image_name;
            $image_name = null;
        }
    } else {
        $message = "Invalid image type. Only JPG, PNG, GIF, and WEBP are allowed.";
    }
}

//deleting a car
if (isset($_GET['delete_car'])) {
    $car_id = filter_input(INPUT_GET, 'delete_id', FILTER_VALIDATE_INT);
    if ($car_id && deleteCar($car_id)) {
        $message = "Car deleted successfully!";
    } else {
        $message = "Failed to delete car.";
    }
}

if (isset($_POST['add_car'])) {
    $carData = [
        'car_model'             => trim($_POST['car_model'] ?? ''),
        'car_brand'             => trim($_POST['car_brand'] ?? ''),
        'car_year'              => filter_input(INPUT_POST, 'car_year', FILTER_VALIDATE_INT),
        'car_color'             => trim($_POST['car_color'] ?? ''),
        'meter_reading'         => filter_input(INPUT_POST, 'meter_reading', FILTER_VALIDATE_INT),
        'number_of_rental_days' => filter_input(INPUT_POST, 'number_of_rental_days', FILTER_VALIDATE_INT),
        'price_per_day'         => $_POST['price_per_day'] ?? 0,
        'included_km_per_day'   => filter_input(INPUT_POST, 'included_km_per_day', FILTER_VALIDATE_INT),
        'extra_km_price'        => $_POST['extra_km_price'] ?? 0,
        'image'                 => $image_name

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
    }echo '<pre>';
var_dump($_SERVER['REQUEST_METHOD']);
var_dump($_POST);
var_dump($_FILES);
echo '</pre>';
}

if (isset($_POST['edit_car'])) {
    $car_id = filter_input(INPUT_POST, 'car_id', FILTER_VALIDATE_INT);
    $carData = [
        'car_id'                 => filter_input(INPUT_POST, 'car_id', FILTER_VALIDATE_INT),
        'car_model'              => trim($_POST['car_model'] ?? ''),
        'car_brand'              => trim($_POST['car_brand'] ?? ''),
        'car_year'               => filter_input(INPUT_POST, 'car_year', FILTER_VALIDATE_INT),
        'car_color'              => trim($_POST['car_color'] ?? ''),
        'meter_reading'          => filter_input(INPUT_POST, 'meter_reading', FILTER_VALIDATE_INT),
        'number_of_rental_days'  => filter_input(INPUT_POST, 'number_of_rental_days', FILTER_VALIDATE_INT),
        'price_per_day'          => $_POST['price_per_day'] ?? 0,
        'included_km_per_day'    => filter_input(INPUT_POST, 'included_km_per_day', FILTER_VALIDATE_INT),
        'extra_km_price'         => $_POST['extra_km_price'] ?? 0,
        'image'                  => $image_name
    ];

    if (edit_car($carData)) {
        $message = "Car updated successfully!";
    } else {
        $message = "Failed to update car.";
    }
}

$car_to_edit = false;
if (isset($_GET['edit_id'])) {
    $edit_id = filter_input(INPUT_GET, 'edit_id', FILTER_VALIDATE_INT);
    if ($edit_id) {
        $car_to_edit = Get_car_by_id($edit_id);
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

    <nav class="nav">
        <ul class="nav-left">
            <li><a href="add_employee.php">Add Employee</a></li>
            <li><a href="employee.php">Employees</a></li>
            <li><a href="car_admin.php">Cars</a></li>
            <li><a href="customer.php">Customers</a></li>
        </ul>

        <ul class="nav-right">
            <li><a href="../../logout.php">Log out</a></li>
        </ul>
    </nav>echo '<pre>';
var_dump($_SERVER['REQUEST_METHOD']);
var_dump($_POST);
var_dump($_FILES);
echo '</pre>';


    <?php if ($message): ?>
        <p class="message"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>

    <?php if ($car_to_edit): ?>
        <div class="form_container">
            <h1>Edit Car</h1>
            <form action="car_admin.php" method="post" enctype="multipart/form-data" class="add-employee-form">
                <input type="hidden" name="car_id" value="<?= htmlspecialchars($car_to_edit['car_id'], ENT_QUOTES, 'UTF-8') ?>">

                <label for="car_model">Car Model:</label>
                <input type="text" id="car_model" name="car_model" value="<?= htmlspecialchars($car_to_edit['car_model'], ENT_QUOTES, 'UTF-8') ?>" required>

                <label for="car_brand">Car Brand:</label>
                <input type="text" id="car_brand" name="car_brand" value="<?= htmlspecialchars($car_to_edit['car_brand'], ENT_QUOTES, 'UTF-8') ?>" required>

                <label for="car_year">Car Year:</label>
                <input type="number" id="car_year" name="car_year" value="<?= htmlspecialchars($car_to_edit['car_year'], ENT_QUOTES, 'UTF-8') ?>" required>
echo '<pre>';
var_dump($_SERVER['REQUEST_METHOD']);
var_dump($_POST);
var_dump($_FILES);
echo '</pre>';
                <label for="car_color">Car Color:</label>
                <input type="text" id="car_color" name="car_color" value="<?= htmlspecialchars($car_to_edit['car_color'], ENT_QUOTES, 'UTF-8') ?>" required>

                <label for="meter_reading">Meter Reading:</label>
                <input type="number" id="meter_reading" name="meter_reading" value="<?= htmlspecialchars($car_to_edit['meter_reading'], ENT_QUOTES, 'UTF-8') ?>" required>

                <label for="number_of_rental_days">Number of Rental Days:</label>
                <input type="number" name="number_of_rental_days" id="number_of_rental_days" min="1" value="<?= htmlspecialchars($car_to_edit['number_of_rental_days'], ENT_QUOTES, 'UTF-8') ?>" required>

                <label for="price_per_day">Price per day (SEK):</label>
                <input type="number" id="price_per_day" name="price_per_day" value="<?= htmlspecialchars($car_to_edit['price_per_day'], ENT_QUOTES, 'UTF-8') ?>" required>

                <label for="included_km_per_day">Included km per day:</label>
                <input type="number" id="included_km_per_day" name="included_km_per_day" value="<?= htmlspecialchars($car_to_edit['included_km_per_day'], ENT_QUOTES, 'UTF-8') ?>" required>

                <label for="extra_km_price">Extra km price (SEK):</label>
                <input type="number" step="0.01" id="extra_km_price" name="extra_km_price" value="<?= htmlspecialchars($car_to_edit['extra_km_price'], ENT_QUOTES, 'UTF-8') ?>" required>

                <label for="image">Image:</label>
                <input type="file" id="image" name="image" accept="image/jpeg, image/png, image/webp">

                <button class="btn" type="submit" name="edit_car">Save Changes</button>
                <a class="btn" href="car_admin.php">Cancel</a>


            </form>
        </div>
    <?php else: ?>

        <div class="form_container">
            <h1>Add Cars</h1>
            <form action="car_admin.php" method="post" enctype="multipart/form-data" class="add-employee-form">

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
                <input type="number" name="number_of_rental_days" id="number_of_rental_days" min="1" required>

                <label for="price_per_day">Price per day (SEK):</label>
                <input type="number" id="price_per_day" name="price_per_day" required>

                <label for="included_km_per_day">Included km per day:</label>
                <input type="number" id="included_km_per_day" name="included_km_per_day" required>

                <label for="extra_km_price">Extra km price (SEK):</label>
                <input type="number" step="0.01" id="extra_km_price" name="extra_km_price" required>

                <label for="image">Image:</label>
                <input type="file" id="image" name="image" accept="image/jpeg, image/png, image/webp">

                <button class="btn" type="submit" name="add_car">Add Car</button>
            </form>
        </div>
    <?php endif; ?>


    <h2>List of Registered Cars</h2>
    <table>
        <tr>
            <th>Car ID</th>
            <th>Car Model</th>
            <th>Car Brand</th>
            <th>Car Year</th>
            <th>Car Color</th>
            <th>Meter Reading</th>
            <th>Number of rental days</th>
            <th>Price per day</th>
            <th>Included km per day</th>
            <th>Extra km price</th>
            <th>Base cost (Days × Price)</th>
            <th>Image</th>
            <th>Edit</th>
            <th>Delete</th>

        </tr>
        <?php

        $cars = getCars();
        while ($row = $cars->fetch(PDO::FETCH_ASSOC)) {
            $base_cost = calculate_total_price(
                $row['number_of_rental_days'],
                $row['price_per_day'],
                $row['included_km_per_day'],
                $row['extra_km_price'],
                0
            ); // Assuming 0 km driven for base cost

            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['car_id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['car_model']) . "</td>";
            echo "<td>" . htmlspecialchars($row['car_brand']) . "</td>";
            echo "<td>" . htmlspecialchars($row['car_year']) . "</td>";
            echo "<td>" . htmlspecialchars($row['car_color']) . "</td>";
            echo "<td>" . htmlspecialchars($row['meter_reading']) . "</td>";
            echo "<td>" . htmlspecialchars($row['number_of_rental_days']) . "</td>";
            echo "<td>" . htmlspecialchars($row['price_per_day']) . "</td>";
            echo "<td>" . htmlspecialchars($row['included_km_per_day']) . "</td>";
            echo "<td>" . htmlspecialchars($row['extra_km_price']) . "</td>";
            echo "<td>" . number_format($base_cost, 2) . " SEK</td>";
            if (!empty($row['image'])) {
                echo "<td><img src='../../uploads/" . 
                htmlspecialchars($row['image'], ENT_QUOTES, 'UTF-8') . 
                "' alt='Car Image' style='width:100px; height:auto;'></td>";
            } else {
                echo "<td>No image</td>";
            }
            echo "<td><a href='?edit_id=" . (int)$row['car_id'] . "'>Edit</a></td>";
            echo "<td><a href='?delete_car=1&delete_id=" . (int)$row['car_id'] . "' onclick='return confirm(\"Are you sure you want to delete this car?\");'>Delete</a></td>";

            echo "</tr>";
        }
        ?>
    </table>

</body>

</html>