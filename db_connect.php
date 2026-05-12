<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "flight_ticket"; // Updated to match the new schema

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error());
}
?>