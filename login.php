<?php
session_start();
require_once 'assets/functions.php';

$error = '';

if (isset($_POST['submit'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    //if (login($username, $password)) {
     //   $_SESSION['username'] = $username;
     //   $_SESSION['password'] = $password;
       // header('Location: index_admin.php');
        //exit();
    //} else {
    //    echo 'invalid username or password';
    //}

$user = login($username, $password);

    
 if ($user) {

         session_regenerate_id(true);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] === 'Admin') {
            header('Location: index_admin.php');
            exit();

        } else if ($user['role'] === 'Employee') {
            header('Location: index_employee.php');
            exit();
        }  else {
        $error = 'Invalid username or password!';
    }
 }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> login</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <h1> login</h1>
    <form method="post" action="" class="add-employee-form">

        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <br>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <br>
        </div>
        <input class="btn" type="submit" name="submit" value="submit">

    </form>
   <?php if (!empty($error)): ?>
    <p class="error">
        <?= htmlspecialchars($error) ?>
    </p>
<?php endif; ?>
</body>

</html>