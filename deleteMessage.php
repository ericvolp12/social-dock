<?php
session_start();
error_reporting(E_ALL); ini_set('display_errors', 1);
$servername = "127.0.0.1";
$username = "server";
$password = "password";
$dbname = "socialdock";
$time = $_POST["time"];
$DBH = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Check connection
  $sql = "SELECT * FROM banned WHERE user = '".$_SESSION['user']."';";
  $STH = $DBH->prepare($sql);
  $result = $STH->execute();;
    while($row = $STH->fetch()) {
        if(isset($row["isBanned"])){
    $isBanned = true;
    $_SESSION['banned'] = true;
    session_destroy();
    header('Location: /login.html');
  }
    }
function getUserData($hash, $cat){
  global $DBH, $time;
if(isset($_POST["isPM"])==true){
  $sql = "UPDATE pms SET deleted=true WHERE timestamp = '$time';";
    $STH = $DBH->prepare($sql);
    $result = $STH->execute();;
  echo "deleted";
}


$sql1 = "SELECT * FROM email WHERE hash='".$hash."';";
  $STH = $DBH->prepare($sql1);
  $result = $STH->execute();;
    // output data of each row
    while($row = $STH->fetch()) {
        return $row[$cat];
        echo "modcheck returned" . $row[$cat];
    }
}

if(($_POST["delete"]==true) && getUserData($_SESSION["user"], "moderator")==1){
  $sql = "DELETE FROM posts WHERE time = '".$_POST["time"]."';";
  $STH = $DBH->prepare($sql);
  $result = $STH->execute();;
  echo "deleted";
}else{
  echo "trouble verifying identity";
}
$DBH = null;

?>