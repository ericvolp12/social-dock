<?php
$servername = "127.0.0.1";
$username = "server";
$password = "password";
$dbname = "socialdock";
// Create connection
global $servername, $username, $password, $dbname;
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT * FROM email;";

$result = $conn->query($sql);

$arrRes = array();

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
          echo '<li><a onclick="selectUser(\''.$row['firstname'].'\', \''.$row['hash'].'\')">'.$row['firstname'].'</a></li>';
        }
} else {
    echo "0 results postData:" . $hashedEmail;
}
$conn->close();
?>