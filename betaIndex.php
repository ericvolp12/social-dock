<?php
session_start();
if($_SESSION['fromLogin'] != "true"){
   //send them back
   header("Location: login.html");
}
else{
    if ($_SESSION['timeout'] + 10 * 60 < time()) {
     header("Location: login.html");
  } else {
     // session ok

  
  
  $servername = "127.0.0.1";
$username = "server";
$password = "password";
$dbname = "socialdock";
   //reset the variable
if(isset($_POST["body"])){
  global $servername, $username, $password, $dbname;
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$postingMessage = str_replace("'","&#39;",$_POST["body"]);
$sql = "INSERT INTO posts (email, content) VALUES ('".$_SESSION['user']."','".$postingMessage."');";

$result = $conn->query($sql);
$conn->close();
}

$_SESSION['timeout'] = time();

function grabData(){
// Create connection
global $servername, $username, $password, $dbname;
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT * FROM posts;";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<div class=\"panel panel-default\">";
        echo $row["timestamp"];
        getUserData($row["email"], "firstname");
        //Processes strigns to fix stuff
        $messageText = str_replace("<", "&lt;", $row["content"]);
        $messageText = str_replace(">", "&gt;", $messageText);
        echo $messageText;
        echo "</div>";
    }
} else {
    echo "0 results postData:" . $hashedEmail;
}
$conn->close();
}


function getUserData($hash, $cat){
  global $servername, $username, $password, $dbname;
  $conn1 = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn1->connect_error);
} 

$sql1 = "SELECT * FROM email WHERE hash='".$hash."';";

$result1 = $conn1->query($sql1);

if ($result1->num_rows > 0) {
    // output data of each row
    while($row1 = $result1->fetch_assoc()) {
        echo $row1[$cat];
    }
} else {
    echo "0 results";
}
$conn1->close();
}
}
}
?>

<html>
<head>
  <link rel="stylesheet" href="styles/bootstrap.min.css">
  <link rel="stylesheet" href="styles/style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<title>
		SocialDock
	</title>
	<script>

	</script>
</head>
<body>
  <div class="jumbotron">
<h1>SocialDock</h1>
<h3>Welcome, <?php getUserData($_SESSION['user'], "firstname");?>!</h3>
</div>
<div class="col-md-6 col-md-offset-3" style="text-align:center;">
<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading"><b>News Feed</b></div>
  
      <?php grabData(); ?>
      
  </div>
  <a name="bottom"></a>
  <div style="color:white;">
  <form action="index.php#bottom" method="post">
Message:
<input type="text" name="body" style="color:black;">

<input type="submit" value="Send" style="color:black;">

</form>
<form action="index.php#bottom" method="post">
  <input type="submit" value="Refresh" style="color:black;">
</form>
  </div>
</div>
</div>
</body>
</html>