<?php
session_start();

require_once '../../assets/functions.php';

$error = false;

//KONTROLLERA OM ANVÄNDAREN ÄR INLOGGAD
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}


// Hämta information om den valda anställda
if (!isset($_GET['username'])) {
    header('Location: add_employee.php');
    exit;
    }

    $emailusername = $_GET['username'];
    $records = getUser();
    $employee = null;

    while ($row = $records->fetch(PDO::FETCH_ASSOC)) {
    if ($row['username'] === $username) {
        $employee = $row;
        break;
    }
}

// Om användaren inte finns
if (!$employee) {
    header('Location: add_employee.php');
    exit;
}

   //uppdatera information om användaren
if (isset($_POST['submit'])) {
    $name = filter_input(INPUT_POST, 'name',  FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];


    if (!$name || !$email) {
        echo "Vänligen fyll i ett giltigt namn och en giltig e-postadress.";
    } else {

        $hashed_password = null;
        //om lösenord är tomt behålls det gamla
        if (!empty($password)) {
            $password = $employee['password'];
        } else {
            $password = password_hash($password, PASSWORD_DEFAULT);
        }


    $felt = [
        'username' => $_SESSION['username'],
        'name' => $name,
        'email' => $email,
        'password' => $hashed_password

    ];

    if (editUser($felt)) {
        echo "profile uppdaterad";
    } else {
        $error = true;

        echo "något gick fel";
    }
      }
}
 

//hämta info om användaren
$row = getUsers();




?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>edit employee</title>
</head>
<body>
    
<nav>
    
        <ul>
            <li><a href="index_admin.php">Home page</a></li>
            <li><a href="logout.php">Log out</a></li>
            <li><a href="add_employee.php">Add Employee</a></li>
            <li><a href="employee.php">Employees</a></li>
            <li><a href="cars.php">Cars</a></li>
            <li><a href="customer.php">Customers</a></li>
        </ul>
    </nav>
</nav>

    <h1>Edit Employee</h1>

    <div class="form_container">

         <?php if ($error): ?>
        <p>Please check your information.</p>
    <?php endif; ?>

    <form method="post" action="">

      <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($employee['name']); ?>" required><br><br>
      </div>

        <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($employee['email']); ?>" required><br><br>
        </div>

        <div class="form-group">
        <label for="password">Password (leave blank to keep current password):</label>
        <input type="password" id="password" name="password"><br><br>
        </div>

        <input type="submit" name="submit" value="Update">
    </form>

    <a href="add_employee.php">Back to Employee List</a>
    </div>
    
</body>
</html>