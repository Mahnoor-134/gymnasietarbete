<?php
$host = 'localhost';
$dbname = 'taxi';
$username = "taxi";
$password = 'taxi';

try {
    $taxi = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
      // set the PDO error mode to exception
    $taxi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    //echo "Connected successfully";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
