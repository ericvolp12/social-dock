<?php
session_start();
$_SESSION['timeout'] = time();
$servername = "127.0.0.1";
$username = "server";
$password = "password";
$dbname = "socialdock";
$email = md5($_POST["email"]);
$userPassword = md5($_POST["password"]);
$_SESSION['board'] = $_POST['board'];
$_SESSION['boardName'] = $_POST['boardName'];

// Create connection
global $servername, $username, $password, $dbname;
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT password FROM login WHERE email = '". $email ."';";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        if($row["password"] == $userPassword){
          $_SESSION['fromLogin'] = "true";
          $_SESSION['user'] = $email;
          $_SESSION['failedLogin'] = false;
          header("Location: index.php");
          echo "Identity Confirmed";
        }else{
          $_SESSION['failedLogin'] = true;
          header("Location: login.html");
        }
    }
} else {
    echo "Incorrect Username or Password";
}
$conn->close();
?>