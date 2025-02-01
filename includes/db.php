<?php
$servername = "MYSQLHOST";
$username = "MYSQLUSER";
$password = "MYSQLPASSWORD";
$dbname = "MYSQLDATABASE";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>