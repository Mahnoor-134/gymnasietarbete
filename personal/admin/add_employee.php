<?php
require_once '../../assets/functions.php';

/*
$records = getUsers();

if ($records->rowCount() > 0) {
    $row_Recordset1 = $records->fetch(PDO::FETCH_ASSOC);
}
?>
<?php*/
session_start();

$error = false;



if (isset($_POST['submit'])) {
    if (
        isset($_POST['username'])
        && isset($_POST['name'])
        && isset($_POST['email'])
        && isset($_POST['password'])
        && ($_POST["username"] != "")
        && ($_POST["name"] != "")
        && ($_POST["email"] != "")
        && ($_POST["password"] != "")
    ) {



        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = $_POST['password'];

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $_POST = [
            'username' => $username,
            'name' => $name,
            'email' => $email,
            'password' => $hashed_password
            //'password' => $password // Skickas i klartext om addUser() sköter hashningen

        ];

        if (addUser($_POST)) {
            $_SESSION['username'] = $username;
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            // $_SESSION['password'] = $password;

            // header("Location: ../../index_admin.php");
            exit();
        } else {
            $error = true;
        }
    } else {
        $error = true;
    }
}
// Hämta användarna från databasen
$records = getUsers();

?>


<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>USERS</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body>

    <nav class="nav">
        <ul>
            <li><a href="../../index_admin.php">home page</a></li>
            <li><a href="logout.php">Log out</a></li>
        </ul>
    </nav>
    </nav>


<div class="form_container">

    <h1>Add Employee</h1>

    <?php
    if ($error)
        echo "<p>Kontrollera din uppgifter</p>";
    ?>
    <p class="form-description">Fill in the details below to add a new employee.</p>

    <form method="post" action="" class="add-employee-form">

        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>

        <input  class="btn" type="submit" name="submit" value="Add Employee">
    </form>
    </div>


    <h3>List of Employees</h3>
    <table>
        <thead>
            <tr>
                <th>Username</th>
                <th>Name</th>
                <th>Email</th>
                <th>Password</th>
            </tr>
        </thead>

        <ttbody>
            <?php if ($records && $records->rowCount() > 0): ?>
                <?php while ($row = $records->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td>
                            <?= htmlspecialchars($row['username'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                        </td>

                        <!--<td>••••••••</td>-->
                        <td><?= htmlspecialchars($row['password'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">Inga användare hittades.</td>
                </tr>
            <?php endif; ?>
            </tbody>

    </table>


</body>

</html>