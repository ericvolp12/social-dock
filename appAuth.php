<?php

$servername = "127.0.0.1";
$username = "user";
$password = "";
$dbname = "android_app";
$hashedEmail= $_POST["hashedEmail"];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT hashedPW FROM user_auth WHERE email='".$hashedEmail."';";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "" . $row["hashedPW"];
    }
} else {
    echo "0 results postData:" . $hashedEmail;
}
$conn->close();
?>