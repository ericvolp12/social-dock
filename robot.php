<?php
$servername = "127.0.0.1";
$username = "server";
$password = "password";
$dbname = "robot";

// Create connection
global $servername, $username, $password, $dbname;
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "INSERT INTO directions (direction, moving) VALUES ('".$_POST['direction']."','".$_POST['moving']."');";

$conn->query($sql);
?>