<?php
session_start();
error_reporting(E_ALL); ini_set('display_errors', 1);
$servername = "127.0.0.1";
$username = "server";
$password = "password";
$dbname = "socialdock";
$sender = $_SESSION['user'];
$target = $_POST['target'];
$content = $_POST['pm'];
$user = $_POST['user'];
$body = $_POST['body'];
$board = $_POST['board'];
$DBH = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// Check connection
if ($DBH->connect_error) {
    die("Connection failed: " . $DBH->connect_error);
} 
  $sql = "SELECT * FROM banned WHERE user ='".$user."';";
  $STH = $DBH->prepare($sql);
  $result = $STH->execute();;
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        if(isset($row["isBanned"])){
    $isBanned = true;
    $_SESSION['banned'] = true;
    session_destroy();
    header('Location: /login.html');
  }
    }
} else {
    echo "0 results";
}
  
if(isset($_POST["body"])){
global $DBH;
// Check connection
if ($DBH->connect_error) {
    die("Connection failed: " . $DBH->connect_error);
} 
//Check if admin is clearing logs
if($_POST["body"]=="clearLogs" && $_POST["user"]=="fdfde08128891c30736ec36acd41ca39"){
  $sql = "TRUNCATE TABLE posts WHERE board=$board;";
//Check if admin is banning a user
}else if(strpos($_POST["body"], "banUser") !== false && $_POST["user"]=="fdfde08128891c30736ec36acd41ca39"){
  $sql = "INSERT INTO banned (user, isBanned) VALUES ('".substr($_POST["body"], 8)."','1');";
  $STH = $DBH->prepare($sql);
//Send the community message
}else if($isBanned != true){
global $user, $body;
$sql = "INSERT INTO posts (email, content, board) VALUES (:user, :body, :board);";
$STH = $DBH->prepare($sql);
$STH->bindParam(':user', $user);
$STH->bindParam(':body', $body);
$STH->bindParam(':board', $board);
}
$result = $STH->execute();
}

//Checks if the post type is a Private Message
if(isset($_POST["pm"])){
global $DBH;
// Check connection
if ($DBH->connect_error) {
    die("Connection failed: " . $DBH->connect_error);
} 
else if($isBanned != true){
global $sender, $target, $content;
$sql = "INSERT INTO pms (sender, target, content) VALUES (:sender, :target, :content);";
$STH = $DBH->prepare($sql);
$STH->bindParam(':sender', $sender);
$STH->bindParam(':target', $target);
$STH->bindParam(':content', $content);
}
if ($result = $STH->execute())
{
  echo "it worked";
}
else
{
  echo "it broke";
}
}
$DBH = null;
?>