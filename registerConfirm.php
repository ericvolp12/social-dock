<?php
session_start();
$_SESSION['timeout'] = time();
$servername = "127.0.0.1";
$username = "server";
$password = "password";
$dbname = "socialdock";
$email = md5($_POST["email"]);
$userPassword = md5($_POST["password"]);

// Create connection
global $servername, $username, $password, $dbname;
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
if(strpos($_POST["email"], "@asl.org") != false){

$sql = "INSERT INTO login (email, password) VALUES ('".$email."','".$userPassword."');";

$conn->query($sql);

$sql = "INSERT INTO email (hash, plaintext, firstname, lastname, dob) VALUES ('".$email."','".$_POST["email"]."','".$_POST["firstName"]."','".$_POST["lastName"]."','" . $_POST["dob"]."');";

$conn->query($sql);
$conn->close();
header("Location: login.html");
}else{
  $_SESSION["wrongDomain"] = true;
  $conn->close();
  header("Location: login.html");
}

?>