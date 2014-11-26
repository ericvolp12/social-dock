<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
$servername = "127.0.0.1";
$username = "server";
$password = "password";
$dbname = "socialdock";
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT * FROM boards;";

$result = $conn->query($sql);

$arrRes = array();

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
          echo '<li><a onclick="selectBoard(\''.$row['boardname'].'\', \''.$row['board'].'\')">'.$row['boardname'].'</a></li>';
        }
} else {
    echo "0 results";
}
$conn->close();
?>