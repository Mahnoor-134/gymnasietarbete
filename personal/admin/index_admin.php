<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
    header('Location: ../../login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style.css">
    <title>Admin</title>
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
    </nav>

    <h1>Admin</h1>
</body>

</html>