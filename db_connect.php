<?php
// ── Database Configuration ──────────────────────────────────
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "flight_booking";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
